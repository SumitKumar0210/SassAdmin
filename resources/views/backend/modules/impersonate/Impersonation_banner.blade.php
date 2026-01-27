@inject('impersonationService', 'App\Services\ImpersonationService')

@if($impersonationService->isImpersonating())
    @php
        $currentLevel = $impersonationService->getCurrentLevel();
        $chain = $impersonationService->getImpersonationChain();
        $actualUser = $impersonationService->getActualUser();
        $currentUser = Auth::user();
    @endphp

    <div class="bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 text-white shadow-2xl border-b-4 border-red-600">
        <div class="container mx-auto px-4 py-4">
            <!-- Header -->
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center space-x-3">
                    <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">
                            {{ $currentLevel === 2 ? '⚠️ Two-Level Impersonation Active' : '🔐 Impersonation Mode' }}
                        </h3>
                        <p class="text-xs opacity-90">All actions are being logged for security and compliance</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-2">
                    @if($currentLevel === 2)
                        <form action="{{ route('impersonate.stop', ['level' => 2]) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition-all shadow-md flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                <span>Back to Admin</span>
                            </button>
                        </form>
                    @endif
                    
                    <form action="{{ route('impersonate.stop-all') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="bg-red-700 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-800 transition-all shadow-md flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span>Exit All</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Impersonation Chain -->
            <div class="bg-white bg-opacity-10 rounded-lg p-4 backdrop-blur-sm">
                <div class="flex flex-wrap items-center gap-3">
                    @foreach($chain as $index => $link)
                        @if($index > 0)
                            <!-- Arrow -->
                            <div class="flex items-center">
                                <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                        @endif

                        <!-- User Card -->
                        <div class="flex items-center space-x-2 bg-white bg-opacity-20 rounded-lg px-3 py-2">
                            <!-- Level Badge -->
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold
                                {{ $link['level'] === 1 ? 'bg-purple-600' : 'bg-indigo-600' }}">
                                L{{ $link['level'] }}
                            </span>

                            <!-- User Info -->
                            <div class="text-sm">
                                <div class="font-semibold">{{ $link['impersonated_user']->name }}</div>
                                <div class="text-xs opacity-75">{{ $link['impersonated_user']->email }}</div>
                            </div>

                            <!-- Role Badge -->
                            @if($link['impersonated_user']->hasRole('super-admin'))
                                <span class="text-xs px-2 py-0.5 bg-red-600 rounded">Super Admin</span>
                            @elseif($link['impersonated_user']->hasRole('admin'))
                                <span class="text-xs px-2 py-0.5 bg-orange-600 rounded">Admin</span>
                            @else
                                <span class="text-xs px-2 py-0.5 bg-blue-600 rounded">User</span>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Summary Info -->
                <div class="mt-3 pt-3 border-t border-white border-opacity-20 flex items-center justify-between text-xs">
                    <div class="space-x-4">
                        <span>
                            <strong>Viewing as:</strong> {{ $currentUser->name }}
                        </span>
                        <span class="opacity-75">|</span>
                        <span>
                            <strong>Original user:</strong> {{ $actualUser->name }}
                        </span>
                    </div>
                    <div class="opacity-75">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Session is being monitored
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif