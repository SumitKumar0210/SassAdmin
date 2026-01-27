<?php

namespace App\Services;

use App\Models\User;
use App\Models\ImpersonationLog;
use App\Events\ImpersonationStarted;
use App\Events\ImpersonationEnded;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ImpersonationService
{
    const SESSION_KEY = 'impersonation';
    const LEVEL_1_KEY = 'level_1'; // super_admin -> admin
    const LEVEL_2_KEY = 'level_2'; // admin -> user
    const MAX_LEVEL = 2;

    public function start(User $userToImpersonate, ?string $reason = null): ImpersonationLog
    {
        $currentUser = Auth::user();
        $currentLevel = $this->getCurrentLevel();

        // Prevent impersonating yourself
        if ($currentUser->id === $userToImpersonate->id) {
            throw new \Exception('You cannot impersonate yourself.');
        }

        // Check if we've reached max impersonation depth
        if ($currentLevel >= self::MAX_LEVEL) {
            throw new \Exception('Maximum impersonation depth reached. You cannot impersonate further.');
        }

        // Determine who is actually doing the impersonation
        $actualImpersonator = $this->getActualUser() ?? $currentUser;
        $newLevel = $currentLevel + 1;
        $parentLogId = null;

        // If this is a second-level impersonation, get the parent log
        if ($currentLevel > 0) {
            $parentLogId = $this->getCurrentLevelLogId($currentLevel);
        }

        // Create log entry
        $log = ImpersonationLog::create([
            'impersonator_id' => $currentUser->id,
            'impersonated_id' => $userToImpersonate->id,
            'parent_log_id' => $parentLogId,
            'level' => $newLevel,
            'started_at' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'reason' => $reason,
        ]);

        // Store in session based on level
        $sessionData = Session::get(self::SESSION_KEY, []);
        
        $levelKey = $this->getLevelKey($newLevel);
        $sessionData[$levelKey] = [
            'original_user_id' => $currentUser->id,
            'impersonated_user_id' => $userToImpersonate->id,
            'log_id' => $log->id,
        ];

        Session::put(self::SESSION_KEY, $sessionData);

        // Login as the target user
        Auth::login($userToImpersonate);

        // Dispatch event
        event(new ImpersonationStarted($currentUser, $userToImpersonate, $log));

        return $log;
    }

    public function stop(?int $specificLevel = null): void
    {
        $currentLevel = $this->getCurrentLevel();

        if ($currentLevel === 0) {
            throw new \Exception('You are not currently impersonating anyone.');
        }

        // If no specific level provided, stop the current level
        $levelToStop = $specificLevel ?? $currentLevel;

        if ($levelToStop > $currentLevel) {
            throw new \Exception('Invalid impersonation level.');
        }

        $sessionData = Session::get(self::SESSION_KEY, []);
        $levelKey = $this->getLevelKey($levelToStop);

        if (!isset($sessionData[$levelKey])) {
            throw new \Exception('No active impersonation at this level.');
        }

        $levelData = $sessionData[$levelKey];
        $originalUserId = $levelData['original_user_id'];
        $logId = $levelData['log_id'];

        $impersonatedUser = Auth::user();

        // Update log with end time
        $log = null;
        if ($logId) {
            $log = ImpersonationLog::find($logId);
            if ($log) {
                $log->update(['ended_at' => now()]);
            }
        }

        // If stopping a parent level, stop all child levels too
        if ($levelToStop < $currentLevel) {
            for ($i = $currentLevel; $i > $levelToStop; $i--) {
                $childLevelKey = $this->getLevelKey($i);
                if (isset($sessionData[$childLevelKey])) {
                    $childLogId = $sessionData[$childLevelKey]['log_id'];
                    if ($childLogId) {
                        $childLog = ImpersonationLog::find($childLogId);
                        if ($childLog) {
                            $childLog->update(['ended_at' => now()]);
                        }
                    }
                    unset($sessionData[$childLevelKey]);
                }
            }
        }

        // Remove the level from session
        unset($sessionData[$levelKey]);

        // If no more levels, clear the entire session
        if (empty($sessionData)) {
            Session::forget(self::SESSION_KEY);
        } else {
            Session::put(self::SESSION_KEY, $sessionData);
        }

        // Login back as original user of this level
        $originalUser = User::findOrFail($originalUserId);
        Auth::login($originalUser);

        // Dispatch event
        if ($log) {
            event(new ImpersonationEnded($originalUser, $impersonatedUser, $log));
        }
    }

    public function stopAll(): void
    {
        $currentLevel = $this->getCurrentLevel();
        
        if ($currentLevel === 0) {
            throw new \Exception('You are not currently impersonating anyone.');
        }

        // Stop from the highest level down to level 1
        $this->stop(1);
    }

    public function isImpersonating(): bool
    {
        return Session::has(self::SESSION_KEY) && !empty(Session::get(self::SESSION_KEY));
    }

    public function getCurrentLevel(): int
    {
        if (!$this->isImpersonating()) {
            return 0;
        }

        $sessionData = Session::get(self::SESSION_KEY, []);
        
        if (isset($sessionData[self::LEVEL_2_KEY])) {
            return 2;
        } elseif (isset($sessionData[self::LEVEL_1_KEY])) {
            return 1;
        }

        return 0;
    }

    public function getActualUser(): ?User
    {
        if (!$this->isImpersonating()) {
            return null;
        }

        $sessionData = Session::get(self::SESSION_KEY, []);
        
        // Always return the level 1 original user (the one who started the chain)
        if (isset($sessionData[self::LEVEL_1_KEY])) {
            $userId = $sessionData[self::LEVEL_1_KEY]['original_user_id'];
            return User::find($userId);
        }

        return null;
    }

    public function getImpersonationChain(): array
    {
        if (!$this->isImpersonating()) {
            return [];
        }

        $sessionData = Session::get(self::SESSION_KEY, []);
        $chain = [];

        // Build chain from level 1 to current level
        for ($i = 1; $i <= self::MAX_LEVEL; $i++) {
            $levelKey = $this->getLevelKey($i);
            if (isset($sessionData[$levelKey])) {
                $chain[] = [
                    'level' => $i,
                    'original_user' => User::find($sessionData[$levelKey]['original_user_id']),
                    'impersonated_user' => User::find($sessionData[$levelKey]['impersonated_user_id']),
                    'log_id' => $sessionData[$levelKey]['log_id'],
                ];
            }
        }

        return $chain;
    }

    public function getCurrentLog(): ?ImpersonationLog
    {
        if (!$this->isImpersonating()) {
            return null;
        }

        $currentLevel = $this->getCurrentLevel();
        $logId = $this->getCurrentLevelLogId($currentLevel);

        return $logId ? ImpersonationLog::find($logId) : null;
    }

    public function logAction(string $action, array $details = []): void
    {
        $log = $this->getCurrentLog();
        
        if ($log) {
            $log->addAction($action, $details);
        }
    }

    public function canImpersonate(User $user, User $targetUser): bool
    {
        $currentLevel = $this->getCurrentLevel();

        // Super admin can impersonate admin (level 1)
        if ($user->hasRole('super-admin') && $targetUser->hasRole('admin') && $currentLevel === 0) {
            return true;
        }

        // Admin can impersonate users (level 2)
        if ($user->hasRole('admin') && !$targetUser->hasRole(['admin', 'super-admin']) && $currentLevel <= 1) {
            return true;
        }

        return false;
    }

    private function getLevelKey(int $level): string
    {
        return match($level) {
            1 => self::LEVEL_1_KEY,
            2 => self::LEVEL_2_KEY,
            default => throw new \Exception("Invalid level: {$level}"),
        };
    }

    private function getCurrentLevelLogId(int $level): ?int
    {
        $sessionData = Session::get(self::SESSION_KEY, []);
        $levelKey = $this->getLevelKey($level);
        
        return $sessionData[$levelKey]['log_id'] ?? null;
    }

    /**
     * Check if session has expired based on timeout configuration
     */
    public function checkTimeout(): bool
    {
        $timeout = config('impersonation.session_timeout', 0);
        
        if ($timeout <= 0 || !$this->isImpersonating()) {
            return false;
        }

        $log = $this->getCurrentLog();
        
        if ($log && $log->started_at->diffInMinutes(now()) >= $timeout) {
            $this->stopAll();
            return true;
        }

        return false;
    }
}