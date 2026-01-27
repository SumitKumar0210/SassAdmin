<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ImpersonationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ImpersonationController extends Controller
{
    public function __construct(
        protected ImpersonationService $impersonationService
    ) {}

    public function start(Request $request, $uuid)
    {
        $currentUser = auth()->guard('super_admin')->user();
        dd($currentUser,$request->all(), $uuid);
        
        // Check if user can impersonate the target
        // if (!$this->impersonationService->canImpersonate($currentUser, $user)) {
        //     abort(403, 'You are not authorized to impersonate this user.');
        // }

        try {
            $validated = $request->validate([
                'reason' => 'nullable|string|max:500',
            ]);

            $log = $this->impersonationService->start($user, $validated['reason'] ?? null);
            
            $level = $log->level;
            $message = $level === 1 
                ? "You are now impersonating {$user->name} (Admin Level)." 
                : "You are now impersonating {$user->name} (User Level).";

            return redirect()
                ->intended(route('dashboard'))
                ->with('success', $message . ' Remember to stop impersonation when done.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function stop(Request $request)
    {
        try {
            $level = $request->input('level');
            
            if ($level) {
                $this->impersonationService->stop((int)$level);
                $message = "You have stopped level {$level} impersonation.";
            } else {
                $currentLevel = $this->impersonationService->getCurrentLevel();
                $this->impersonationService->stop();
                $message = "You have stopped level {$currentLevel} impersonation.";
            }

            return redirect()
                ->back()
                ->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function stopAll()
    {
        try {
            $this->impersonationService->stopAll();

            return redirect()
                ->route('dashboard')
                ->with('success', 'You have stopped all impersonation and returned to your account.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function logs(Request $request)
    {
        // Authorization check
        if (!Gate::allows('view-impersonation-logs')) {
            abort(403, 'You are not authorized to view impersonation logs.');
        }

        $query = \App\Models\ImpersonationLog::with(['impersonator', 'impersonated', 'parentLog'])
            ->orderBy('started_at', 'desc');

        // Filter by level
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // Filter by impersonator
        if ($request->filled('impersonator_id')) {
            $query->where('impersonator_id', $request->impersonator_id);
        }

        // Filter by impersonated user
        if ($request->filled('impersonated_id')) {
            $query->where('impersonated_id', $request->impersonated_id);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('started_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('started_at', '<=', $request->end_date);
        }

        // Filter active sessions
        if ($request->boolean('active_only')) {
            $query->whereNull('ended_at');
        }

        // Filter chained impersonations
        if ($request->boolean('chained_only')) {
            $query->whereNotNull('parent_log_id');
        }

        $logs = $query->paginate(50);

        return view('admin.impersonation.logs', compact('logs'));
    }

    public function show(\App\Models\ImpersonationLog $log)
    {
        // Authorization check
        if (!Gate::allows('view-impersonation-logs')) {
            abort(403, 'You are not authorized to view impersonation logs.');
        }

        $log->load(['impersonator', 'impersonated', 'parentLog', 'childLogs']);

        return view('admin.impersonation.show', compact('log'));
    }

    public function chain(\App\Models\ImpersonationLog $log)
    {
        // Authorization check
        if (!Gate::allows('view-impersonation-logs')) {
            abort(403, 'You are not authorized to view impersonation logs.');
        }

        // Get the full chain
        $chain = $log->getChain();

        return view('admin.impersonation.chain', compact('chain', 'log'));
    }
}