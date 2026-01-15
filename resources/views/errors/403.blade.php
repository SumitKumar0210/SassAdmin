@extends('admin.layouts.app')

@section('title', '403 - Access Forbidden')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
<style>
    :root {
        --forbidden-primary: #DC2626;
        --forbidden-secondary: #EF4444;
        --forbidden-dark: #0F172A;
        --forbidden-light: #F1F5F9;
        --forbidden-accent: #F97316;
    }

    .error-container-403 {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--forbidden-dark);
        position: relative;
        overflow: hidden;
        font-family: 'Sora', sans-serif;
    }

    .error-container-403::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(220, 38, 38, 0.03) 2px,
                rgba(220, 38, 38, 0.03) 4px
            );
        animation: scanline 8s linear infinite;
    }

    @keyframes scanline {
        0% { transform: translateY(0); }
        100% { transform: translateY(100%); }
    }

    .grid-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: 
            linear-gradient(rgba(220, 38, 38, 0.1) 1px, transparent 1px),
            linear-gradient(90deg, rgba(220, 38, 38, 0.1) 1px, transparent 1px);
        background-size: 50px 50px;
        transform: perspective(500px) rotateX(60deg);
        transform-origin: center center;
        opacity: 0.3;
    }

    .error-content-403 {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 700px;
        padding: 2rem;
    }

    .lock-container {
        width: 200px;
        height: 200px;
        margin: 0 auto 2rem;
        position: relative;
    }

    .lock-icon {
        width: 100%;
        height: 100%;
        filter: drop-shadow(0 0 30px rgba(220, 38, 38, 0.5));
    }

    .security-ring {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 160px;
        height: 160px;
        border: 3px solid var(--forbidden-primary);
        border-radius: 50%;
        opacity: 0.3;
        animation: securityPulse 2s ease-in-out infinite;
    }

    .security-ring:nth-child(2) {
        width: 180px;
        height: 180px;
        animation-delay: 0.3s;
    }

    .security-ring:nth-child(3) {
        width: 200px;
        height: 200px;
        animation-delay: 0.6s;
    }

    @keyframes securityPulse {
        0%, 100% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 0.3;
        }
        50% {
            transform: translate(-50%, -50%) scale(1.1);
            opacity: 0.1;
        }
    }

    .error-code-403 {
        font-family: 'JetBrains Mono', monospace;
        font-size: clamp(6rem, 15vw, 12rem);
        font-weight: 700;
        line-height: 1;
        margin: 0;
        color: var(--forbidden-primary);
        text-shadow: 
            0 0 20px rgba(220, 38, 38, 0.5),
            0 0 40px rgba(220, 38, 38, 0.3);
        position: relative;
    }

    .error-code-403::before {
        content: '403';
        position: absolute;
        top: 0;
        left: 0;
        color: var(--forbidden-secondary);
        opacity: 0.5;
        animation: glitchText 5s infinite;
    }

    @keyframes glitchText {
        0%, 90%, 100% { transform: translate(0); opacity: 0; }
        91% { transform: translate(-4px, 2px); opacity: 0.5; }
        92% { transform: translate(2px, -2px); opacity: 0.5; }
        93% { transform: translate(0); opacity: 0; }
    }

    .error-title-403 {
        font-size: clamp(1.75rem, 4vw, 2.75rem);
        font-weight: 800;
        color: var(--forbidden-light);
        margin: 1.5rem 0 1rem;
        letter-spacing: -0.03em;
    }

    .error-message-403 {
        font-size: clamp(1rem, 2vw, 1.2rem);
        color: rgba(241, 245, 249, 0.7);
        margin-bottom: 2rem;
        line-height: 1.7;
        font-weight: 400;
    }

    .permission-box {
        background: rgba(220, 38, 38, 0.1);
        border: 1px solid rgba(220, 38, 38, 0.3);
        border-radius: 12px;
        padding: 1.5rem;
        margin: 2rem 0;
        backdrop-filter: blur(10px);
    }

    .permission-box-title {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.9rem;
        color: var(--forbidden-secondary);
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .permission-box-text {
        color: rgba(241, 245, 249, 0.8);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .error-actions-403 {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 2.5rem;
    }

    .btn-error-403 {
        padding: 1rem 2.5rem;
        font-size: 1.05rem;
        font-weight: 600;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }

    .btn-primary-403 {
        background: linear-gradient(135deg, var(--forbidden-primary) 0%, var(--forbidden-accent) 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
    }

    .btn-primary-403:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
        color: white;
    }

    .btn-secondary-403 {
        background: transparent;
        color: var(--forbidden-light);
        border: 2px solid rgba(241, 245, 249, 0.3);
    }

    .btn-secondary-403:hover {
        background: rgba(241, 245, 249, 0.1);
        border-color: rgba(241, 245, 249, 0.5);
        color: var(--forbidden-light);
    }

    .warning-symbols {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }

    .warning-symbol {
        position: absolute;
        font-size: 2rem;
        color: var(--forbidden-primary);
        opacity: 0.1;
        animation: floatWarning 15s infinite ease-in-out;
    }

    .warning-symbol:nth-child(1) { top: 15%; left: 10%; animation-delay: 0s; }
    .warning-symbol:nth-child(2) { top: 60%; right: 15%; animation-delay: 2s; }
    .warning-symbol:nth-child(3) { bottom: 20%; left: 20%; animation-delay: 4s; }
    .warning-symbol:nth-child(4) { top: 30%; right: 25%; animation-delay: 1s; }

    @keyframes floatWarning {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-30px) rotate(180deg); }
    }

    @media (max-width: 768px) {
        .error-actions-403 {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-error-403 {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="error-container-403">
    <div class="grid-background"></div>
    
    <div class="warning-symbols">
        <div class="warning-symbol">⚠</div>
        <div class="warning-symbol">⚠</div>
        <div class="warning-symbol">⚠</div>
        <div class="warning-symbol">⚠</div>
    </div>

    <div class="error-content-403">
        <div class="lock-container">
            <div class="security-ring"></div>
            <div class="security-ring"></div>
            <div class="security-ring"></div>
            <svg class="lock-icon" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="60" y="90" width="80" height="70" rx="8" fill="#DC2626" opacity="0.9"/>
                <path d="M70 90 V70 C70 53.43 83.43 40 100 40 C116.57 40 130 53.43 130 70 V90" 
                      stroke="#EF4444" stroke-width="8" stroke-linecap="round" fill="none"/>
                <circle cx="100" cy="125" r="12" fill="#F1F5F9"/>
                <rect x="95" y="125" width="10" height="20" rx="2" fill="#F1F5F9"/>
                
                <circle cx="100" cy="100" r="70" stroke="#DC2626" stroke-width="2" stroke-dasharray="4 4" opacity="0.3">
                    <animateTransform
                        attributeName="transform"
                        type="rotate"
                        from="0 100 100"
                        to="360 100 100"
                        dur="20s"
                        repeatCount="indefinite"/>
                </circle>
            </svg>
        </div>

        <h1 class="error-code-403">403</h1>
        <h2 class="error-title-403">Access Denied</h2>
        <p class="error-message-403">
            You don't have permission to access this resource.<br>
            This area is restricted and requires proper authorization.
        </p>

        <div class="permission-box">
            <div class="permission-box-title">Security Notice</div>
            <div class="permission-box-text">
                If you believe you should have access, please contact your administrator or verify your credentials.
            </div>
        </div>

        <div class="error-actions-403">
            <a href="{{ url('/') }}" class="btn-error-403 btn-primary-403">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                </svg>
                Return Home
            </a>
            <a href="{{ url('/support') }}" class="btn-error-403 btn-secondary-403">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
                Get Help
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection