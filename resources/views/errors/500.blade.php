@extends('admin.layouts.app')

@section('title', '500 - Server Error')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&family=Fira+Code:wght@400;700&display=swap" rel="stylesheet">
<style>
    :root {
        --server-primary: #8B5CF6;
        --server-secondary: #EC4899;
        --server-dark: #0A0A0F;
        --server-light: #F5F3FF;
        --server-accent: #F59E0B;
    }

    .error-container-500 {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: radial-gradient(circle at 50% 50%, #1A1A2E 0%, var(--server-dark) 100%);
        position: relative;
        overflow: hidden;
        font-family: 'Outfit', sans-serif;
    }

    .circuit-board {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0.15;
        background-image: 
            linear-gradient(90deg, transparent 0%, var(--server-primary) 50%, transparent 100%),
            linear-gradient(0deg, transparent 0%, var(--server-secondary) 50%, transparent 100%);
        background-size: 100px 100px;
        animation: circuitFlow 10s linear infinite;
    }

    @keyframes circuitFlow {
        0% { background-position: 0 0; }
        100% { background-position: 100px 100px; }
    }

    .error-content-500 {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 750px;
        padding: 2rem;
    }

    .server-icon-container {
        width: 220px;
        height: 220px;
        margin: 0 auto 2rem;
        position: relative;
    }

    .server-icon {
        width: 100%;
        height: 100%;
        filter: drop-shadow(0 0 40px rgba(139, 92, 246, 0.4));
    }

    .energy-ring {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        border: 2px solid;
        animation: energyPulse 3s ease-in-out infinite;
    }

    .energy-ring:nth-child(1) {
        width: 160px;
        height: 160px;
        border-color: var(--server-primary);
        animation-delay: 0s;
    }

    .energy-ring:nth-child(2) {
        width: 180px;
        height: 180px;
        border-color: var(--server-secondary);
        animation-delay: 0.5s;
    }

    .energy-ring:nth-child(3) {
        width: 200px;
        height: 200px;
        border-color: var(--server-accent);
        animation-delay: 1s;
    }

    @keyframes energyPulse {
        0%, 100% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 0.6;
        }
        50% {
            transform: translate(-50%, -50%) scale(1.15);
            opacity: 0.2;
        }
    }

    .error-code-500 {
        font-family: 'Fira Code', monospace;
        font-size: clamp(7rem, 18vw, 14rem);
        font-weight: 700;
        line-height: 1;
        margin: 0;
        background: linear-gradient(135deg, var(--server-primary) 0%, var(--server-secondary) 50%, var(--server-accent) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        background-size: 200% 200%;
        animation: gradientShift 3s ease infinite;
    }

    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .error-title-500 {
        font-size: clamp(1.75rem, 4vw, 2.5rem);
        font-weight: 800;
        color: var(--server-light);
        margin: 1.5rem 0 1rem;
        letter-spacing: -0.02em;
    }

    .error-message-500 {
        font-size: clamp(1rem, 2vw, 1.2rem);
        color: rgba(245, 243, 255, 0.7);
        margin-bottom: 2rem;
        line-height: 1.7;
        font-weight: 400;
    }

    .status-panel {
        background: rgba(139, 92, 246, 0.08);
        border: 1px solid rgba(139, 92, 246, 0.25);
        border-radius: 16px;
        padding: 1.75rem;
        margin: 2rem 0;
        backdrop-filter: blur(10px);
        text-align: left;
    }

    .status-panel-title {
        font-family: 'Fira Code', monospace;
        font-size: 0.85rem;
        color: var(--server-secondary);
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--server-secondary);
        animation: blink 1.5s ease-in-out infinite;
    }

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }

    .status-items {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .status-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: rgba(245, 243, 255, 0.8);
        font-size: 0.95rem;
    }

    .status-item-icon {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
    }

    .error-actions-500 {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 2.5rem;
    }

    .btn-error-500 {
        padding: 1rem 2.5rem;
        font-size: 1.05rem;
        font-weight: 600;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        position: relative;
        overflow: hidden;
    }

    .btn-error-500::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-error-500:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-primary-500 {
        background: linear-gradient(135deg, var(--server-primary) 0%, var(--server-secondary) 100%);
        color: white;
        border: none;
        box-shadow: 0 10px 30px rgba(139, 92, 246, 0.3);
    }

    .btn-primary-500:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 15px 40px rgba(139, 92, 246, 0.4);
        color: white;
    }

    .btn-secondary-500 {
        background: rgba(245, 243, 255, 0.08);
        color: var(--server-light);
        border: 2px solid rgba(245, 243, 255, 0.25);
    }

    .btn-secondary-500:hover {
        background: rgba(245, 243, 255, 0.15);
        border-color: rgba(245, 243, 255, 0.4);
        transform: translateY(-3px);
        color: var(--server-light);
    }

    .particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
    }

    .particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: var(--server-primary);
        border-radius: 50%;
        opacity: 0.5;
        animation: particleFloat 15s infinite ease-in-out;
    }

    .particle:nth-child(1) { top: 20%; left: 10%; animation-delay: 0s; background: var(--server-primary); }
    .particle:nth-child(2) { top: 80%; left: 20%; animation-delay: 2s; background: var(--server-secondary); }
    .particle:nth-child(3) { top: 40%; right: 15%; animation-delay: 4s; background: var(--server-accent); }
    .particle:nth-child(4) { top: 60%; right: 25%; animation-delay: 1s; background: var(--server-primary); }
    .particle:nth-child(5) { bottom: 30%; left: 30%; animation-delay: 3s; background: var(--server-secondary); }

    @keyframes particleFloat {
        0%, 100% {
            transform: translate(0, 0);
            opacity: 0.5;
        }
        50% {
            transform: translate(50px, -50px);
            opacity: 0.8;
        }
    }

    @media (max-width: 768px) {
        .error-actions-500 {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-error-500 {
            width: 100%;
            justify-content: center;
        }

        .status-panel {
            text-align: center;
        }
    }
</style>
@endsection

@section('content')
<div class="error-container-500">
    <div class="circuit-board"></div>
    
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="error-content-500">
        <div class="server-icon-container">
            <div class="energy-ring"></div>
            <div class="energy-ring"></div>
            <div class="energy-ring"></div>
            <svg class="server-icon" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Server rack -->
                <rect x="50" y="40" width="100" height="120" rx="8" fill="#8B5CF6" opacity="0.2" stroke="#8B5CF6" stroke-width="2"/>
                
                <!-- Server units -->
                <rect x="60" y="55" width="80" height="20" rx="4" fill="#EC4899" opacity="0.8"/>
                <rect x="60" y="85" width="80" height="20" rx="4" fill="#8B5CF6" opacity="0.8"/>
                <rect x="60" y="115" width="80" height="20" rx="4" fill="#F59E0B" opacity="0.8"/>
                
                <!-- LED indicators -->
                <circle cx="70" cy="65" r="3" fill="#10B981">
                    <animate attributeName="opacity" values="1;0.3;1" dur="1s" repeatCount="indefinite"/>
                </circle>
                <circle cx="80" cy="65" r="3" fill="#EF4444">
                    <animate attributeName="opacity" values="0.3;1;0.3" dur="1.5s" repeatCount="indefinite"/>
                </circle>
                
                <circle cx="70" cy="95" r="3" fill="#EF4444">
                    <animate attributeName="opacity" values="1;0.3;1" dur="1.2s" repeatCount="indefinite"/>
                </circle>
                <circle cx="80" cy="95" r="3" fill="#EF4444">
                    <animate attributeName="opacity" values="0.3;1;0.3" dur="0.8s" repeatCount="indefinite"/>
                </circle>
                
                <circle cx="70" cy="125" r="3" fill="#F59E0B">
                    <animate attributeName="opacity" values="1;0.5;1" dur="1s" repeatCount="indefinite"/>
                </circle>
                
                <!-- Warning symbol -->
                <path d="M100 70 L105 80 L95 80 Z" fill="#FFF" opacity="0.9"/>
                <circle cx="100" cy="77" r="1" fill="#8B5CF6"/>
            </svg>
        </div>

        <h1 class="error-code-500">500</h1>
        <h2 class="error-title-500">Internal Server Error</h2>
        <p class="error-message-500">
            Something went wrong on our end. Our servers encountered an unexpected condition.<br>
            Don't worry, our team has been automatically notified.
        </p>

        <div class="status-panel">
            <div class="status-panel-title">
                <span class="status-indicator"></span>
                System Status
            </div>
            <div class="status-items">
                <div class="status-item">
                    <svg class="status-item-icon" viewBox="0 0 24 24" fill="none" stroke="#EC4899" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    Error detected and logged
                </div>
                <div class="status-item">
                    <svg class="status-item-icon" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                    </svg>
                    Technical team has been notified
                </div>
                <div class="status-item">
                    <svg class="status-item-icon" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    Resolution in progress
                </div>
            </div>
        </div>

        <div class="error-actions-500">
            <a href="{{ url('/') }}" class="btn-error-500 btn-primary-500">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                </svg>
                Back to Home
            </a>
            <a href="javascript:location.reload()" class="btn-error-500 btn-secondary-500">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="23 4 23 10 17 10"></polyline>
                    <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                </svg>
                Try Again
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection