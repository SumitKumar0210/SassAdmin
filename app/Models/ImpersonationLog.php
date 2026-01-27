<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ImpersonationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'impersonator_id',
        'impersonated_id',
        'parent_log_id',
        'level',
        'started_at',
        'ended_at',
        'ip_address',
        'user_agent',
        'reason',
        'actions_performed',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'actions_performed' => 'array',
        'level' => 'integer',
    ];

    public function impersonator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'impersonator_id');
    }

    public function impersonated(): BelongsTo
    {
        return $this->belongsTo(User::class, 'impersonated_id');
    }

    public function parentLog(): BelongsTo
    {
        return $this->belongsTo(ImpersonationLog::class, 'parent_log_id');
    }

    public function childLogs(): HasMany
    {
        return $this->hasMany(ImpersonationLog::class, 'parent_log_id');
    }

    public function getDuration(): ?int
    {
        if (!$this->ended_at) {
            return null;
        }
        
        return $this->started_at->diffInSeconds($this->ended_at);
    }

    public function isActive(): bool
    {
        return $this->ended_at === null;
    }

    public function addAction(string $action, array $details = []): void
    {
        $actions = $this->actions_performed ?? [];
        $actions[] = [
            'action' => $action,
            'details' => $details,
            'timestamp' => now()->toDateTimeString(),
        ];
        
        $this->update(['actions_performed' => $actions]);
    }

    public function isChainedImpersonation(): bool
    {
        return $this->parent_log_id !== null;
    }

    public function getChainDepth(): int
    {
        return $this->level;
    }

    /**
     * Get the full impersonation chain
     */
    public function getChain(): array
    {
        $chain = [$this];
        $current = $this;

        while ($current->parentLog) {
            $current = $current->parentLog;
            array_unshift($chain, $current);
        }

        return $chain;
    }

    /**
     * Get the original user who started the chain
     */
    public function getOriginalImpersonator(): User
    {
        $chain = $this->getChain();
        return $chain[0]->impersonator;
    }
}