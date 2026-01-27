<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImpersonationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can impersonate other users.
     */
    public function impersonate(User $user): bool
    {
        // Only allow specific roles
        return $user->hasRole(['admin', 'super-admin']);
    }

    /**
     * Determine if the user can impersonate a specific target user.
     * This handles both level 1 and level 2 impersonation.
     */
    public function impersonateUser(User $user, User $targetUser): bool
    {
        // Prevent impersonating yourself
        if ($user->id === $targetUser->id) {
            return false;
        }

        // Super admin can impersonate admins (Level 1)
        if ($user->hasRole('super-admin') && $targetUser->hasRole('admin')) {
            return true;
        }

        // Admin can impersonate regular users (Level 2)
        // This includes admins who are currently being impersonated by super admins
        if ($user->hasRole('admin') && !$targetUser->hasRole(['admin', 'super-admin'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can impersonate at the current level.
     * Used to prevent exceeding max depth.
     */
    public function canImpersonateAtLevel(User $user, int $currentLevel, User $targetUser): bool
    {
        // Cannot exceed level 2
        if ($currentLevel >= 2) {
            return false;
        }

        // Level 0 -> Level 1: Super admin impersonating admin
        if ($currentLevel === 0) {
            return $user->hasRole('super-admin') && $targetUser->hasRole('admin');
        }

        // Level 1 -> Level 2: Admin impersonating user
        if ($currentLevel === 1) {
            return $user->hasRole('admin') && !$targetUser->hasRole(['admin', 'super-admin']);
        }

        return false;
    }

    /**
     * Determine if the user can view impersonation logs.
     */
    public function viewLogs(User $user): bool
    {
        return $user->hasRole(['admin', 'super-admin']);
    }

    /**
     * Determine if the user can view all impersonation logs or only their own.
     */
    public function viewAllLogs(User $user): bool
    {
        return $user->hasRole('super-admin');
    }

    /**
     * Determine if user can view a specific log.
     */
    public function viewLog(User $user, \App\Models\ImpersonationLog $log): bool
    {
        // Super admins can view all logs
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Admins can view their own impersonation logs
        if ($user->hasRole('admin')) {
            return $log->impersonator_id === $user->id || 
                   $log->impersonated_id === $user->id;
        }

        return false;
    }
}