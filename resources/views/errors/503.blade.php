@extends('admin.layouts.app')

@section('title', '503 - Service Unavailable')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;600;800&family=Source+Code+Pro:wght@400;700&display=swap" rel="stylesheet">
<style>
    :root {
        --maintenance-primary: #06B6D4;
        --maintenance-secondary: #0EA5E9;
        --maintenance-dark: #0C1222;
        --maintenance-light: #F0F9FF;
        --maintenance-accent: #8B5CF6;
    }

    .error-container-503 {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #0C1222 0%, #1E293B 100%);
        position: relative;
        overflow: hidden;
        font-family: 'DM Sans', sans-serif;
    }

    .wave-background {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 40%;
        opacity: 0.1;
    }

    .wave {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 200%;
        height: 100%;
        background: linear-gradient(90deg, transparent, var(--maintenance-primary), transparent);
        animation: waveMove 8s linear infinite;
    }

    .wave:nth-child(2) {
        background: linear-gradient(90deg, transparent, var(--maintenance-secondary), transparent);
        animation-delay: 2s;
        animation-duration: 10s;
        opacity: 0.7;
    }

    .wave:nth-child(3) {
        background: linear-gradient(90deg, transparent, var(--maintenance-accent), transparent);
        animation-delay: 4s;
        animation-duration: 12s;
        opacity: 0.5;
    }

    @keyframes waveMove {
        0% { transform: translateX(-50%); }
        100% { transform: translateX(0); }
    }

    .error-content-503 {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        padding: 2rem;
    }

    .maintenance-icon-container {
        width: 240px;
        height: 240px;
        margin: 0 auto 2.5rem;
        position: relative;
    }

    .gear-container {
        width: 100%;
        height: 100%;
        filter: drop-shadow(0 0 40px rgba(6, 182, 212, 0.4));
    }

    .rotating-orbit {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border: 2px dashed var(--maintenance-primary);
        border-radius: 50%;
        opacity: 0.3;
    }

    .orbit-1 {
        width: 180px;
        height: 180px;
        animation: rotateOrbit 15s linear infinite;
    }

    .orbit-2 {
        width: 220px;
        height: 220px;
        animation: rotateOrbit 20s linear infinite reverse;
    }

    @keyframes rotateOrbit {
        from { transform: translate(-50%, -50%) rotate(0deg); }
        to { transform: translate(-50%, -50%) rotate(360deg); }
    }

    .error-code-503 {
        font-family: 'Source Code Pro', monospace;
        font-size: clamp(6.5rem, 16vw, 13rem);
        font-weight: 700;
        line-height: 1;
        margin: 0;
        background: linear-gradient(135deg, var(--maintenance-primary) 0%, var(--maintenance-accent) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 0 80px rgba(6, 182, 212, 0.3);
    }

    .error-title-503 {
        font-size: clamp(1.75rem, 4vw, 2.75rem);
        font-weight: 800;
        color: var(--maintenance-light);
        margin: 1.5rem 0 1rem;
        letter-spacing: -0.02em;
    }

    .error-message-503 {
        font-size: clamp(1rem, 2vw, 1.25rem);
        color: rgba(240, 249, 255, 0.7);
        margin-bottom: 2.5rem;
        line-height: 1.7;
        font-weight: 400;
    }

    .maintenance-info {
        background: rgba(6, 182, 212, 0.08);
        border: 1px solid rgba(6, 182, 212, 0.25);
        border-left: 4px solid var(--maintenance-primary);
        border-radius: 12px;
        padding: 2rem;
        margin: 2.5rem 0;
        backdrop-filter: blur(10px);
    }

    .maintenance-info-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--maintenance-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .maintenance-info-icon {
        width: 24px;
        height: 24px;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .maintenance-info-text {
        color: rgba(240, 249, 255, 0.85);
        font-size: 1rem;
        line-height: 1.6;
    }

    .countdown-container {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        margin: 2rem 0;
        flex-wrap: wrap;
    }

    .countdown-item {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(6, 182, 212, 0.2);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        min-width: 100px;
        backdrop-filter: blur(10px);
    }

    .countdown-value {
        font-family: 'Source Code Pro', monospace;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--maintenance-primary);
        display: block;
        line-height: 1;
    }

    .countdown-label {
        font-size: 0.85rem;
        color: rgba(240, 249, 255, 0.6);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-top: 0.5rem;
    }

    .error-actions-503 {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 2.5rem;
    }

    .btn-error-503 {
        padding: 1rem 2.5rem;
        font-size: 1.05rem;
        font-weight: 600;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        position: relative;
        overflow: hidden;
    }

    .btn-primary-503 {
        background: linear-gradient(135deg, var(--maintenance-primary) 0%, var(--maintenance-secondary) 100%);
        color: white;
        border: none;
        box-shadow: 0 8px 25px rgba(6, 182, 212, 0.3);
    }

    .btn-primary-503:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(6, 182, 212, 0.4);
        color: white;
    }

    .btn-secondary-503 {
        background: transparent;
        color: var(--maintenance-light);
        border: 2px solid rgba(240, 249, 255, 0.25);
    }

    .btn-secondary-503:hover {
        background: rgba(240, 249, 255, 0.1);
        border-color: rgba(240, 249, 255, 0.4);
        color: var(--maintenance-light);
    }

    .floating-tools {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }

    .tool-icon {
        position: absolute;
        font-size: 2.5rem;
        opacity: 0.08;
        animation: floatTool 20s infinite ease-in-out;
    }

    .tool-icon:nth-child(1) { top: 10%; left: 15%; animation-delay: 0s; }
    .tool-icon:nth-child(2) { top: 70%; right: 10%; animation-delay: 5s; }
    .tool-icon:nth-child(3) { bottom: 15%; left: 10%; animation-delay: 10s; }
    .tool-icon:nth-child(4) { top: 30%; right: 20%; animation-delay: 3s; }

    @keyframes floatTool {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-30px) rotate(180deg); }
    }

    @media (max-width: 768px) {
        .error-actions-503 {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-error-503 {
            width: 100%;
            justify-content: center;
        }

        .countdown-container {
            gap: 1rem;
        }

        .countdown-item {
            min-width: 80px;
            padding: 1rem;
        }

        .countdown-value {
            font-size: 2rem;
        }
    }
</style>
@endsection

@section('content')
<div class="error-container-503">
    <div class="wave-background">
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

    <div class="floating-tools">
        <div class="tool-icon">🔧</div>
        <div class="tool-icon">⚙️</div>
        <div class="tool-icon">🛠️</div>
        <div class="tool-icon">🔨</div>
    </div>

    <div class="error-content-503">
        <div class="maintenance-icon-container">
            <div class="rotating-orbit orbit-1"></div>
            <div class="rotating-orbit orbit-2"></div>
            <svg class="gear-container" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Main gear -->
                <g transform="translate(100, 100)">
                    <animateTransform
                        attributeName="transform"
                        type="rotate"
                        from="0 100 100"
                        to="360 100 100"
                        dur="8s"
                        repeatCount="indefinite"/>
                    
                    <circle r="40" fill="#06B6D4" opacity="0.9"/>
                    <circle r="25" fill="#0C1222"/>
                    
                    <rect x="-8" y="-55" width="16" height="20" rx="3" fill="#06B6D4"/>
                    <rect x="-8" y="35" width="16" height="20" rx="3" fill="#06B6D4"/>
                    <rect x="35" y="-8" width="20" height="16" rx="3" fill="#06B6D4"/>
                    <rect x="-55" y="-8" width="20" height="16" rx="3" fill="#06B6D4"/>
                    
                    <rect x="-6" y="-40" width="12" height="14" rx="2" fill="#0EA5E9" transform="rotate(45)"/>
                    <rect x="-6" y="-40" width="12" height="14" rx="2" fill="#0EA5E9" transform="rotate(135)"/>
                    <rect x="-6" y="-40" width="12" height="14" rx="2" fill="#0EA5E9" transform="rotate(225)"/>
                    <rect x="-6" y="-40" width="12" height="14" rx="2" fill="#0EA5E9" transform="rotate(315)"/>
                </g>
                
                <!-- Small gear -->
                <g transform="translate(145, 65)">
                    <animateTransform
                        attributeName="transform"
                        type="rotate"
                        from="0 145 65"
                        to="-360 145 65"
                        dur="5s"
                        repeatCount="indefinite"/>
                    
                    <circle r="20" fill="#8B5CF6" opacity="0.8"/>
                    <circle r="12" fill="#0C1222"/>
                    
                    <rect x="-4" y="-28" width="8" height="10" rx="2" fill="#8B5CF6"/>
                    <rect x="-4" y="18" width="8" height="10" rx="2" fill="#8B5CF6"/>
                    <rect x="18" y="-4" width="10" height="8" rx="2" fill="#8B5CF6"/>
                    <rect x="-28" y="-4" width="10" height="8" rx="2" fill="#8B5CF6"/>
                </g>
            </svg>
        </div>

        <h1 class="error-code-503">503</h1>
        <h2 class="error-title-503">We'll Be Right Back</h2>
        <p class="error-message-503">
            Our service is temporarily unavailable due to scheduled maintenance.<br>
            We're working hard to improve your experience.
        </p>

        <div class="maintenance-info">
            <div class="maintenance-info-title">
                <svg class="maintenance-info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                Scheduled Maintenance
            </div>
            <div class="maintenance-info-text">
                We're upgrading our systems to serve you better. Thank you for your patience.
            </div>
        </div>

        <div class="countdown-container">
            <div class="countdown-item">
                <span class="countdown-value" id="hours">--</span>
                <span class="countdown-label">Hours</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-value" id="minutes">--</span>
                <span class="countdown-label">Minutes</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-value" id="seconds">--</span>
                <span class="countdown-label">Seconds</span>
            </div>
        </div>

        <div class="error-actions-503">
            <a href="javascript:location.reload()" class="btn-error-503 btn-primary-503">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="23 4 23 10 17 10"></polyline>
                    <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                </svg>
                Refresh Page
            </a>
            <a href="{{ url('/status') }}" class="btn-error-503 btn-secondary-503">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="22" y1="12" x2="2" y2="12"></line>
                    <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>
                    <line x1="6" y1="16" x2="6.01" y2="16"></line>
                    <line x1="10" y1="16" x2="10.01" y2="16"></line>
                </svg>
                System Status
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Countdown timer - set your target time here
    // Example: 2 hours from now
    const targetTime = new Date().getTime() + (2 * 60 * 60 * 1000);

    function updateCountdown() {
        const now = new Date().getTime();
        const distance = targetTime - now;

        if (distance < 0) {
            document.getElementById('hours').textContent = '00';
            document.getElementById('minutes').textContent = '00';
            document.getElementById('seconds').textContent = '00';
            return;
        }

        const hours = Math.floor(distance / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('hours').textContent = String(hours).padStart(2, '0');
        document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
        document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
    }

    // Update countdown every second
    updateCountdown();
    setInterval(updateCountdown, 1000);
</script>
@endsection