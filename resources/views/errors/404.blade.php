@extends('admin.layouts.app')

@section('title', '404 - Page Not Found')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<style>
    :root {
        --error-primary: #FF6B6B;
        --error-secondary: #4ECDC4;
        --error-dark: #1A1A2E;
        --error-light: #F8F9FA;
        --error-accent: #FFE66D;
    }

    .error-container-404 {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--error-dark) 0%, #16213E 100%);
        position: relative;
        overflow: hidden;
        font-family: 'Manrope', sans-serif;
    }

    .error-container-404::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 50%, rgba(78, 205, 196, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255, 107, 107, 0.1) 0%, transparent 50%);
        animation: pulseGlow 8s ease-in-out infinite;
    }

    @keyframes pulseGlow {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }

    .error-content-404 {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        padding: 2rem;
    }

    .error-code-404 {
        font-family: 'Space Mono', monospace;
        font-size: clamp(8rem, 20vw, 16rem);
        font-weight: 700;
        line-height: 1;
        margin: 0;
        background: linear-gradient(135deg, var(--error-primary) 0%, var(--error-secondary) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
        animation: glitchAnimation 3s infinite;
    }

    @keyframes glitchAnimation {
        0%, 90%, 100% { transform: translate(0); }
        92% { transform: translate(-2px, 2px); }
        94% { transform: translate(2px, -2px); }
        96% { transform: translate(-2px, -2px); }
        98% { transform: translate(2px, 2px); }
    }

    .error-icon-404 {
        width: 180px;
        height: 180px;
        margin: 0 auto 2rem;
        position: relative;
        animation: floatAnimation 3s ease-in-out infinite;
    }

    @keyframes floatAnimation {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    .error-icon-404 svg {
        width: 100%;
        height: 100%;
        filter: drop-shadow(0 10px 30px rgba(78, 205, 196, 0.3));
    }

    .error-title-404 {
        font-size: clamp(1.5rem, 4vw, 2.5rem);
        font-weight: 800;
        color: var(--error-light);
        margin: 1.5rem 0 1rem;
        letter-spacing: -0.02em;
    }

    .error-message-404 {
        font-size: clamp(1rem, 2vw, 1.25rem);
        color: rgba(248, 249, 250, 0.7);
        margin-bottom: 3rem;
        line-height: 1.6;
        font-weight: 400;
    }

    .error-actions-404 {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-error-primary {
        padding: 1rem 2.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }

    .btn-error-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-error-primary:hover::before {
        left: 100%;
    }

    .btn-primary-404 {
        background: linear-gradient(135deg, var(--error-primary) 0%, #FF8E53 100%);
        color: white;
        border: none;
    }

    .btn-primary-404:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(255, 107, 107, 0.4);
        color: white;
    }

    .btn-secondary-404 {
        background: rgba(255, 255, 255, 0.1);
        color: var(--error-light);
        border: 2px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
    }

    .btn-secondary-404:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        color: var(--error-light);
    }

    .floating-shapes {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
    }

    .shape {
        position: absolute;
        opacity: 0.1;
        animation: floatShapes 20s infinite ease-in-out;
    }

    .shape:nth-child(1) {
        top: 10%;
        left: 10%;
        width: 80px;
        height: 80px;
        background: var(--error-secondary);
        border-radius: 50%;
        animation-delay: 0s;
    }

    .shape:nth-child(2) {
        top: 70%;
        left: 80%;
        width: 120px;
        height: 120px;
        background: var(--error-primary);
        border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
        animation-delay: 2s;
    }

    .shape:nth-child(3) {
        top: 40%;
        left: 5%;
        width: 60px;
        height: 60px;
        background: var(--error-accent);
        border-radius: 50%;
        animation-delay: 4s;
    }

    .shape:nth-child(4) {
        top: 20%;
        right: 15%;
        width: 100px;
        height: 100px;
        background: var(--error-secondary);
        border-radius: 20% 80% 80% 20% / 50% 50% 50% 50%;
        animation-delay: 1s;
    }

    @keyframes floatShapes {
        0%, 100% {
            transform: translate(0, 0) rotate(0deg);
        }
        33% {
            transform: translate(30px, -30px) rotate(120deg);
        }
        66% {
            transform: translate(-20px, 20px) rotate(240deg);
        }
    }

    @media (max-width: 768px) {
        .error-actions-404 {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-error-primary {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="error-container-404">
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="error-content-404">
        <div class="error-icon-404">
            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="100" cy="100" r="80" stroke="#4ECDC4" stroke-width="4" stroke-dasharray="10 5" opacity="0.3"/>
                <path d="M100 40 L140 80 L100 120 L60 80 Z" fill="#FF6B6B" opacity="0.8"/>
                <circle cx="100" cy="100" r="50" fill="none" stroke="#FFE66D" stroke-width="3" stroke-dasharray="5 5">
                    <animateTransform
                        attributeName="transform"
                        type="rotate"
                        from="0 100 100"
                        to="360 100 100"
                        dur="10s"
                        repeatCount="indefinite"/>
                </circle>
                <path d="M80 90 Q100 70 120 90" stroke="#fff" stroke-width="4" stroke-linecap="round" fill="none"/>
                <circle cx="85" cy="110" r="4" fill="#fff"/>
                <circle cx="115" cy="110" r="4" fill="#fff"/>
            </svg>
        </div>

        <h1 class="error-code-404">404</h1>
        <h2 class="error-title-404">Lost in the Digital Void</h2>
        <p class="error-message-404">
            The page you're searching for has wandered off into the unknown.<br>
            It might have been moved, deleted, or never existed in the first place.
        </p>

        <div class="error-actions-404">
            <a href="{{ url('/') }}" class="btn-error-primary btn-primary-404">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                Back to Home
            </a>
            <a href="{{ url('/support') }}" class="btn-error-primary btn-secondary-404">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                Contact Support
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection