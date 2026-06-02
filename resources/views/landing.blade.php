@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
    :root {
        --primary: #ff6b35;
        --primary-dark: #f7931e;
        --primary-light: #ffd23f;
        --bg-dark: rgba(15, 15, 25, 0.85);
        --glass-bg: rgba(255, 255, 255, 0.08);
        --glass-border: rgba(255, 255, 255, 0.12);
        --text-muted: rgba(255, 255, 255, 0.7);
        --nav-height: 70px;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    html, body {
        overflow-x: hidden;
        scroll-behavior: smooth;
        font-family: system-ui, -apple-system, sans-serif;
    }

    body {
        min-height: 100vh;
        color: #fff;
        background: linear-gradient(var(--bg-dark), var(--bg-dark)),
            url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=2070&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        line-height: 1.6;
    }

    .navbar {
        position: fixed;
        top: 0; left: 0;
        width: 100%;
        height: var(--nav-height);
        backdrop-filter: blur(20px);
        background: rgba(15, 23, 42, 0.95);
        border-bottom: 1px solid rgba(255, 107, 53, 0.25);
        z-index: 10000;
        transition: all 0.3s ease;
    }

    .navbar.scrolled {
        height: 65px;
        background: rgba(15, 23, 42, 0.98);
        box-shadow: 0 8px 30px rgba(0,0,0,0.3);
    }

    .nav-container {
        max-width: 1400px;
        margin: 0 auto;
        height: 100%;
        padding: 0 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: clamp(12px, 2vw, 16px);
        text-decoration: none;
        flex-shrink: 0;
    }

    .logo-image {
        width: clamp(44px, 6vw, 52px);
        height: clamp(44px, 6vw, 52px);
        object-fit: cover;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.4);
        transition: all 0.3s ease;
    }

    .logo span {
        font-size: clamp(1.6rem, 4vw, 2.2rem);
        font-weight: 900;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.02em;
    }

    .logo:hover .logo-image { transform: scale(1.08); box-shadow: 0 12px 32px rgba(255,107,53,0.4); }

    .nav-menu {
        position: absolute;
        left: 50%; top: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        gap: 2rem;
        margin: 0; padding: 0;
        list-style: none;
        flex: none;
        justify-content: center;
        align-items: center;
    }

    .nav-link {
        color: rgba(255,255,255,0.9);
        text-decoration: none;
        font-weight: 500;
        font-size: clamp(0.85rem, 2vw, 0.9rem);
        padding: 8px 0;
        position: relative;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

 .nav-link::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 50%;
    width: 0;
    height: 2px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    transition: all 0.3s ease;
    transform: translateX(-50%);
    border-radius: 1px;
}
    .nav-link:hover, .nav-link.active { color: #fff; }
    .nav-link:hover::after, .nav-link.active::after { width: 100%; }

    .nav-actions { display: flex; gap: 0.8rem; align-items: center; flex-shrink: 0; }

    .logout-btn {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        border: none;
        padding: clamp(8px, 2vw, 10px) clamp(16px, 4vw, 20px);
        border-radius: 20px;
        font-weight: 600;
        font-size: clamp(0.8rem, 2vw, 0.85rem);
        text-decoration: none;
        transition: all 0.3s ease;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 6px;
        height: clamp(36px, 8vw, 40px);
        cursor: pointer;
    }

    .logout-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(255,107,53,0.3); }

    .mobile-menu {
        position: fixed;
        top: 0; left: 0;
        width: 100vw; height: 100vh;
        background: rgba(15, 23, 42, 0.98);
        backdrop-filter: blur(20px);
        z-index: 9999;
        transform: translateX(100%);
        transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
        display: flex;
        flex-direction: column;
        padding: 100px 4% 2rem;
    }

    .mobile-menu.open { transform: translateX(0); }

    .mobile-nav-links {
        list-style: none;
        margin: 0; padding: 0;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        align-items: center;
        justify-content: center;
    }

    .mobile-nav-link {
        color: rgba(255,255,255,0.95);
        text-decoration: none;
        font-weight: 600;
        font-size: clamp(1.1rem, 4vw, 1.3rem);
        padding: 12px 0;
        transition: all 0.3s ease;
    }

    .mobile-nav-link:hover { color: #fff; transform: translateX(10px); }

    .hamburger {
        display: none;
        flex-direction: column;
        gap: 4px;
        cursor: pointer;
        padding: 8px;
        z-index: 10001;
    }

    .hamburger span {
        width: 24px; height: 2px;
        background: #fff;
        transition: all 0.3s ease;
        border-radius: 2px;
    }

    .hamburger.active span:nth-child(1) { transform: rotate(45deg) translate(6px, 6px); }
    .hamburger.active span:nth-child(2) { opacity: 0; }
    .hamburger.active span:nth-child(3) { transform: rotate(-45deg) translate(6px, -5px); }

    .page-wrap { padding-top: var(--nav-height); }

    .hero-section {
        min-height: calc(100vh - var(--nav-height));
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
        overflow: hidden;
        padding: clamp(60px, 10vw, 100px) clamp(20px, 4vw, 40px);
    }

    .hero-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 80% 60% at 50% 40%, rgba(255,107,53,0.08) 0%, transparent 70%);
        pointer-events: none;
    }

    .hero-content {
        max-width: 860px;
        position: relative;
        z-index: 2;
        animation: fadeInUp 1s ease;
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,107,53,0.12);
        border: 1px solid rgba(255,107,53,0.3);
        border-radius: 50px;
        padding: 8px 20px;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--primary-light);
        margin-bottom: 28px;
    }

    .hero-title {
        font-size: clamp(2.8rem, 9vw, 5.2rem);
        font-weight: 900;
        background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: clamp(20px, 3vw, 28px);
        line-height: 1.08;
        letter-spacing: -1px;
    }

    .hero-title span {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark), var(--primary-light));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .hero-subtitle {
        font-size: clamp(1.05rem, 2.5vw, 1.35rem);
        color: rgba(255,255,255,0.8);
        margin-bottom: clamp(40px, 6vw, 56px);
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.7;
        font-weight: 400;
    }

    .hero-actions {
        display: flex;
        gap: 16px;
        justify-content: center;
        flex-wrap: wrap;
        margin-bottom: clamp(48px, 7vw, 72px);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #000;
        border: none;
        padding: clamp(14px, 3vw, 18px) clamp(28px, 5vw, 40px);
        border-radius: 50px;
        font-size: clamp(0.95rem, 2vw, 1.05rem);
        font-weight: 800;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
        box-shadow: 0 12px 32px rgba(255,107,53,0.4);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .btn-primary:hover { transform: translateY(-4px); box-shadow: 0 20px 48px rgba(255,107,53,0.55); }

    .btn-ghost {
        background: rgba(255,255,255,0.08);
        color: #fff;
        border: 2px solid rgba(255,255,255,0.2);
        padding: clamp(14px, 3vw, 18px) clamp(28px, 5vw, 40px);
        border-radius: 50px;
        font-size: clamp(0.95rem, 2vw, 1.05rem);
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        backdrop-filter: blur(10px);
    }

    .btn-ghost:hover { background: rgba(255,255,255,0.14); border-color: rgba(255,107,53,0.5); transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.3); }

    .hero-stats {
        display: flex;
        gap: clamp(32px, 6vw, 56px);
        justify-content: center;
        flex-wrap: wrap;
    }

    .hero-stat { text-align: center; }
    .hero-stat-number {
        font-size: clamp(1.8rem, 5vw, 2.6rem);
        font-weight: 900;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        line-height: 1;
        margin-bottom: 6px;
    }
    .hero-stat-label { font-size: 0.82rem; color: rgba(255,255,255,0.55); font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; }

    .section-wrap {
        max-width: 1400px;
        margin: 0 auto;
        padding: clamp(80px, 12vw, 120px) clamp(20px, 4vw, 40px);
    }

    .section-header {
        text-align: center;
        margin-bottom: clamp(48px, 7vw, 72px);
    }

    .section-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,107,53,0.1);
        border: 1px solid rgba(255,107,53,0.25);
        border-radius: 50px;
        padding: 7px 18px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--primary-light);
        margin-bottom: 20px;
    }

    .section-title {
        font-size: clamp(2rem, 6vw, 3.2rem);
        font-weight: 900;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark), var(--primary-light));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        letter-spacing: -0.5px;
        line-height: 1.15;
        margin-bottom: 16px;
    }

    .section-sub {
        font-size: clamp(1rem, 2.2vw, 1.15rem);
        color: rgba(255,255,255,0.65);
        max-width: 540px;
        margin: 0 auto;
        line-height: 1.7;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: clamp(20px, 3vw, 28px);
    }

    .feature-card {
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 28px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
        position: relative;
        cursor: pointer;
        display: flex;
        flex-direction: column;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark), var(--primary-light));
        border-radius: 28px 28px 0 0;
    }

    .feature-card:hover {
        transform: translateY(-14px) scale(1.02);
        background: rgba(255,255,255,0.08);
        border-color: rgba(255,107,53,0.35);
        box-shadow: 0 32px 72px rgba(0,0,0,0.45);
    }

    .feature-img-wrap {
        width: 100%;
        height: clamp(180px, 22vw, 240px);
        overflow: hidden;
        position: relative;
    }

    .feature-img-wrap::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent 40%, rgba(15,15,25,0.7) 100%);
        pointer-events: none;
    }

    .feature-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(0.4,0,0.2,1);
    }

    .feature-card:hover .feature-img-wrap img { transform: scale(1.1); }

    .feature-body {
        padding: clamp(24px, 4vw, 32px);
        display: flex;
        flex-direction: column;
        gap: 12px;
        flex: 1;
    }

    .feature-icon-wrap {
        width: 48px; height: 48px;
        border-radius: 16px;
        background: rgba(255,107,53,0.15);
        border: 1px solid rgba(255,107,53,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: var(--primary);
        margin-bottom: 4px;
    }

    .feature-body h3 {
        font-size: clamp(1.1rem, 2.5vw, 1.25rem);
        font-weight: 800;
        color: #fff;
        line-height: 1.3;
    }

    .feature-body p {
        color: rgba(255,255,255,0.75);
        font-size: clamp(0.88rem, 1.8vw, 0.95rem);
        line-height: 1.65;
    }

    .feature-card-footer {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: auto;
        padding-top: 16px;
        color: var(--primary);
        font-size: 0.85rem;
        font-weight: 700;
        border-top: 1px solid rgba(255,255,255,0.07);
    }

    .reviews-section {
        background: rgba(255,255,255,0.02);
        border-top: 1px solid rgba(255,255,255,0.06);
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }

    .reviews-inner {
        background: rgba(255,255,255,0.04);
        backdrop-filter: blur(28px);
        border: 1px solid rgba(255,107,53,0.2);
        border-radius: 32px;
        padding: clamp(40px, 6vw, 64px) clamp(28px, 5vw, 56px);
        position: relative;
        overflow: hidden;
    }

    .reviews-inner::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark), var(--primary-light), transparent);
        border-radius: 32px 32px 0 0;
    }

    .reviews-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: clamp(20px, 3vw, 28px);
    }

    .review-card {
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 24px;
        padding: clamp(24px, 4vw, 32px);
        transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .review-card::after {
        content: '\201C';
        position: absolute;
        top: 16px; right: 20px;
        font-size: 5rem;
        line-height: 1;
        font-family: Georgia, serif;
        color: rgba(255,107,53,0.1);
        pointer-events: none;
    }

    .review-card:hover {
        transform: translateY(-10px);
        border-color: rgba(255,107,53,0.35);
        box-shadow: 0 28px 64px rgba(0,0,0,0.4);
        background: rgba(255,255,255,0.08);
    }

    .review-header {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .review-avatar {
        width: clamp(52px, 8vw, 68px);
        height: clamp(52px, 8vw, 68px);
        border-radius: 50%;
        overflow: hidden;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        box-shadow: 0 8px 24px rgba(255,107,53,0.35);
        flex-shrink: 0;
        border: 2px solid rgba(255,107,53,0.4);
    }

    .review-avatar img { width: 100%; height: 100%; object-fit: cover; }

    .review-meta { flex: 1; min-width: 0; }
    .review-author { font-weight: 800; color: #fff; font-size: 0.95rem; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .review-stars { color: var(--primary-light); font-size: 0.9rem; letter-spacing: 2px; text-shadow: 0 2px 8px rgba(255,210,63,0.5); }

    .review-text {
        color: rgba(255,255,255,0.85);
        font-size: clamp(0.9rem, 1.8vw, 0.98rem);
        line-height: 1.75;
        flex: 1;
    }

    .founder-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: clamp(48px, 8vw, 80px);
        align-items: center;
    }

    .founder-content { display: flex; flex-direction: column; gap: 24px; }

    .founder-content h2 {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 900;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.5px;
        line-height: 1.15;
    }

    .founder-bio {
        font-size: clamp(0.95rem, 2vw, 1.05rem);
        line-height: 1.85;
        color: rgba(255,255,255,0.82);
    }

    .founder-badges {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .founder-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,107,53,0.1);
        border: 1px solid rgba(255,107,53,0.25);
        border-radius: 50px;
        padding: 6px 14px;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--primary-light);
    }

    .founder-actions {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }

    .founder-img-wrap {
        position: relative;
        border-radius: 32px;
        overflow: hidden;
        box-shadow: 0 32px 80px rgba(0,0,0,0.5);
    }

    .founder-img-wrap::before {
        content: '';
        position: absolute;
        inset: 0;
        border: 3px solid rgba(255,107,53,0.3);
        border-radius: 32px;
        z-index: 2;
        pointer-events: none;
        transition: border-color 0.4s ease;
    }

    .founder-img-wrap:hover::before { border-color: var(--primary); }

    .founder-img-wrap img {
        width: 100%;
        height: clamp(320px, 45vw, 500px);
        object-fit: cover;
        display: block;
        transition: transform 0.5s cubic-bezier(0.4,0,0.2,1);
    }

    .founder-img-wrap:hover img { transform: scale(1.04); }

    .founder-img-badge {
        position: absolute;
        bottom: 24px; left: 24px;
        background: rgba(15,23,42,0.9);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255,107,53,0.3);
        border-radius: 20px;
        padding: 14px 20px;
        z-index: 3;
    }

    .founder-img-badge-name { font-weight: 800; font-size: 0.95rem; color: #fff; }
    .founder-img-badge-role { font-size: 0.78rem; color: var(--primary-light); font-weight: 600; margin-top: 2px; }

    .footer {
        width: 100vw;
        margin-left: calc(-50vw + 50%);
        background: linear-gradient(180deg, rgba(15,23,42,0.98) 0%, rgba(10,15,30,1) 100%);
        backdrop-filter: blur(20px);
        border-top: 2px solid rgba(255,107,53,0.3);
        padding: 4rem 20px 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .footer::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--primary), var(--primary-dark), var(--primary-light), transparent);
    }

    .footer-content { max-width: 1400px; margin: 0 auto; position: relative; z-index: 2; }
    .footer-top { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2.5rem; margin-bottom: 2rem; }
    .footer-col { margin: 0; }

    .footer-col h4 {
        color: #fff;
        font-weight: 800;
        font-size: clamp(1.05rem, 2.5vw, 1.2rem);
        margin: 0 0 1.5rem 0;
        padding-bottom: 0.5rem;
        position: relative;
    }

    .footer-col h4::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0;
        width: 40px; height: 2px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        border-radius: 1px;
    }

    .footer-col a, .footer-col p {
        color: rgba(255,255,255,0.85);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 8px 0 8px 4px;
        transition: all 0.3s ease;
        position: relative;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .footer-col p { display: block; }

    .footer-col a::before {
        content: '';
        position: absolute;
        left: 0; top: 50%;
        width: 0; height: 2px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        transition: width 0.3s ease;
        transform: translateY(-50%);
        border-radius: 1px;
    }

    .footer-col a:hover { color: #fff; padding-left: 12px; background: rgba(255,255,255,0.05); }
    .footer-col a:hover::before { width: 6px; }

    .newsletter-wrapper { position: relative; margin-top: 1rem; }
    .newsletter-row { display: flex; gap: 12px; flex-wrap: wrap; }

    .newsletter-row input {
        flex: 1;
        min-width: 220px;
        padding: 14px 20px;
        background: rgba(255,255,255,0.06);
        backdrop-filter: blur(20px);
        border: 2px solid rgba(255,255,255,0.12);
        border-radius: 16px;
        color: #fff;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    }

    .newsletter-row input::placeholder { color: rgba(255,255,255,0.5); }

    .newsletter-row input:focus {
        outline: none;
        border-color: var(--primary);
        background: rgba(255,255,255,0.1);
        box-shadow: 0 0 0 4px rgba(255,107,53,0.15);
        transform: translateY(-1px);
    }

    .newsletter-row button {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        border: none;
        border-radius: 16px;
        padding: 14px 24px;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        box-shadow: 0 8px 25px rgba(255,107,53,0.4);
        flex-shrink: 0;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .newsletter-row button:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(255,107,53,0.5); }

    .footer-bottom {
        border-top: 1px solid rgba(255,255,255,0.08);
        padding-top: 2rem;
        margin-top: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        text-align: center;
    }

    .footer-logo-bottom {
        font-size: clamp(1.6rem, 4vw, 2rem);
        font-weight: 900;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark), var(--primary-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.5px;
    }

    .footer-tagline { color: rgba(255,255,255,0.6); font-size: 0.9rem; font-weight: 500; margin: 0; letter-spacing: 0.5px; max-width: 600px; }
    .social-icons { display: flex; gap: 1rem; margin: 0; padding: 0; }

    .social-link {
        width: 48px; height: 48px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.2rem;
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
        flex-shrink: 0;
    }

    .social-link:hover { transform: translateY(-4px) scale(1.08); box-shadow: 0 15px 35px rgba(255,107,53,0.4); border-color: rgba(255,107,53,0.3); }
    .footer-copy { color: rgba(255,255,255,0.4); font-size: 0.85rem; margin: 0; }

    .toast-container {
        position: fixed;
        bottom: clamp(24px, 4vh, 40px);
        right: clamp(20px, 3vw, 32px);
        z-index: 10001;
        display: flex;
        flex-direction: column-reverse;
        gap: 12px;
        max-width: 380px;
        pointer-events: none;
    }

    .toast {
        min-width: clamp(260px, 32vw, 360px);
        padding: 0;
        border-radius: 18px;
        color: #fff;
        font-weight: 500;
        font-size: 0.92rem;
        line-height: 1.5;
        backdrop-filter: blur(28px);
        transform: translateX(110%) scale(0.9);
        opacity: 0;
        transition: transform 0.45s cubic-bezier(0.22,1,0.36,1), opacity 0.35s ease;
        position: relative;
        display: flex;
        align-items: stretch;
        pointer-events: all;
        box-shadow: 0 12px 40px rgba(0,0,0,0.5), 0 1px 0 rgba(255,255,255,0.07) inset;
        overflow: hidden;
    }

    .toast.show { transform: translateX(0) scale(1); opacity: 1; }

    .toast-side { width: 5px; flex-shrink: 0; border-radius: 18px 0 0 18px; }
    .toast-inner { display: flex; align-items: flex-start; gap: 12px; padding: 16px 18px 16px 14px; flex: 1; }

    .toast-icon-wrap {
        width: 34px; height: 34px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: 1rem;
        margin-top: 1px;
    }

    .toast-body { flex: 1; min-width: 0; }
    .toast-label { font-size: 0.68rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; opacity: 0.65; margin-bottom: 2px; }
    .toast-message { color: rgba(255,255,255,0.92); font-size: 0.9rem; font-weight: 500; line-height: 1.45; }

    .toast-progress {
        position: absolute;
        bottom: 0; left: 5px; right: 0;
        height: 3px;
        border-radius: 0 0 18px 0;
        opacity: 0.4;
        animation: toastProgress 4s linear forwards;
    }

    @keyframes toastProgress { from { width: calc(100% - 5px); } to { width: 0; } }

    .toast.success .toast-side       { background: #22c55e; }
    .toast.success .toast-icon-wrap  { background: rgba(34,197,94,0.18); color: #4ade80; border: 1px solid rgba(34,197,94,0.3); }
    .toast.success .toast-label      { color: #4ade80; }
    .toast.success .toast-progress   { background: #22c55e; }
    .toast.success                   { background: rgba(15,30,20,0.92); border: 1px solid rgba(34,197,94,0.2); }

    .toast.error .toast-side         { background: #ef4444; }
    .toast.error .toast-icon-wrap    { background: rgba(239,68,68,0.18); color: #f87171; border: 1px solid rgba(239,68,68,0.3); }
    .toast.error .toast-label        { color: #f87171; }
    .toast.error .toast-progress     { background: #ef4444; }
    .toast.error                     { background: rgba(30,10,10,0.92); border: 1px solid rgba(239,68,68,0.2); }

    .toast.info .toast-side          { background: #3b82f6; }
    .toast.info .toast-icon-wrap     { background: rgba(59,130,246,0.18); color: #60a5fa; border: 1px solid rgba(59,130,246,0.3); }
    .toast.info .toast-label         { color: #60a5fa; }
    .toast.info .toast-progress      { background: #3b82f6; }
    .toast.info                      { background: rgba(10,15,30,0.92); border: 1px solid rgba(59,130,246,0.2); }

    .toast.warning .toast-side       { background: #f59e0b; }
    .toast.warning .toast-icon-wrap  { background: rgba(245,158,11,0.18); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3); }
    .toast.warning .toast-label      { color: #fbbf24; }
    .toast.warning .toast-progress   { background: #f59e0b; }
    .toast.warning                   { background: rgba(30,20,5,0.92); border: 1px solid rgba(245,158,11,0.2); }

    .modal-overlay {
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.75);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 999999;
        backdrop-filter: blur(6px);
    }

    .modal-overlay.show { display: flex; }

    .modal {
        width: clamp(90%, 500px, 600px);
        max-height: 90vh;
        background: rgba(15, 23, 42, 0.98);
        color: white;
        border-radius: 28px;
        padding: clamp(24px, 5vw, 36px);
        transform: scale(0.9) translateY(20px);
        transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
        box-shadow: 0 32px 80px rgba(0,0,0,0.7), 0 0 0 1px rgba(255,107,53,0.2);
        overflow-y: auto;
        backdrop-filter: blur(30px);
        border: 1px solid rgba(255,107,53,0.25);
        opacity: 0;
    }

    .modal-overlay.show .modal { transform: scale(1) translateY(0); opacity: 1; }

    .logout-modal-icon {
        width: 72px; height: 72px;
        border-radius: 24px;
        background: rgba(255,107,53,0.12);
        border: 1px solid rgba(255,107,53,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: var(--primary);
        margin: 0 auto 24px;
    }

    .logout-modal-title {
        font-size: clamp(1.5rem, 4vw, 1.9rem);
        font-weight: 900;
        text-align: center;
        background: linear-gradient(135deg, #fff, rgba(255,255,255,0.85));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 12px;
        letter-spacing: -0.3px;
    }

    .logout-modal-sub {
        text-align: center;
        color: rgba(255,255,255,0.6);
        font-size: 0.95rem;
        line-height: 1.65;
        margin-bottom: 32px;
    }

    .logout-modal-actions {
        display: flex;
        gap: 14px;
    }

    .logout-modal-cancel {
        flex: 1;
        background: rgba(255,255,255,0.08);
        color: #fff;
        border: 2px solid rgba(255,255,255,0.15);
        padding: 16px;
        border-radius: 20px;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-family: inherit;
    }

    .logout-modal-cancel:hover { background: rgba(255,255,255,0.14); border-color: rgba(255,255,255,0.3); transform: translateY(-2px); }

    .logout-modal-confirm {
        flex: 1;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #000;
        border: none;
        padding: 16px;
        border-radius: 20px;
        font-size: 0.95rem;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 12px 32px rgba(255,107,53,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-family: inherit;
    }

    .logout-modal-confirm:hover { transform: translateY(-2px); box-shadow: 0 18px 44px rgba(255,107,53,0.55); }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .fade-in { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
    .fade-in.visible { opacity: 1; transform: translateY(0); }

    @media (max-width: 1024px) {
        .features-grid { grid-template-columns: repeat(2, 1fr); }
        .reviews-grid  { grid-template-columns: repeat(2, 1fr); }
        .founder-section { grid-template-columns: 1fr; gap: 3rem; }
        .founder-img-wrap img { height: clamp(280px, 55vw, 420px); }
    }

    @media (max-width: 768px) {
        .navbar { height: 65px; }
        .navbar.scrolled { height: 60px; }
        .page-wrap { padding-top: 65px; }
        .nav-menu { display: none; }
        .hamburger { display: flex; }
        .nav-actions { display: none; }
        .features-grid { grid-template-columns: 1fr; }
        .reviews-grid  { grid-template-columns: 1fr; }
        .hero-actions { flex-direction: column; align-items: center; }
        .btn-primary, .btn-ghost { width: 100%; max-width: 320px; justify-content: center; }
        .founder-actions { flex-direction: column; align-items: flex-start; }
        .newsletter-row { flex-direction: column; }
        .newsletter-row input { min-width: auto; }
        .footer-top { grid-template-columns: 1fr; text-align: center; gap: 2.5rem; }
        .footer-col h4::after { left: 50%; transform: translateX(-50%); }
        .social-icons { gap: 0.75rem; }
        .social-link { width: 44px; height: 44px; }
        .footer-col a { justify-content: center; }
        .toast-container { right: 12px; left: 12px; max-width: none; }
        .toast { min-width: auto; }
        .hero-stats { gap: clamp(20px, 5vw, 40px); }
        .logout-modal-actions { flex-direction: column; }
    }

    @media (max-width: 480px) {
        .nav-container { padding: 0 8px; }
        .hero-section { padding: 40px 20px; }
    }
    </style>

<div class="toast-container" id="toastContainer"></div>

<nav class="navbar" id="navbar">
    <div class="nav-container">
        <a href="/dashboard" class="logo">
            <img src="{{ asset('images/OIP.webp') }}" alt="Task Organizo" class="logo-image">
            <span>Task Organizo</span>
        </a>
        <ul class="nav-menu" id="navMenu">
            <li><a href="/landing" class="nav-link active">Home</a></li>
            <li><a href="/todos" class="nav-link">Menu List</a></li>
            <li><a href="/contacts" class="nav-link">Contacts</a></li>
        </ul>
        <div class="nav-actions">
            <button type="button" class="logout-btn" id="logoutTrigger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </div>
        <div class="hamburger" id="hamburger">
            <span></span><span></span><span></span>
        </div>
    </div>
</nav>

<div class="mobile-menu" id="mobileMenu">
    <ul class="mobile-nav-links">
        <li><a href="/landing" class="mobile-nav-link active">Home</a></li>
        <li><a href="/todos" class="mobile-nav-link">Menu List</a></li>
        <li><a href="/contacts" class="mobile-nav-link">Contacts</a></li>
    </ul>
    <div style="width:100%;max-width:300px;margin:auto auto 2rem auto;display:flex;flex-direction:column;align-items:center;gap:12px;">
        <button type="button" class="logout-btn" id="logoutTriggerMobile" style="width:100%;justify-content:center;">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </div>
</div>

<div class="modal-overlay" id="logoutModal">
    <div class="modal" style="max-width:480px;text-align:center;">
        <div class="logout-modal-icon">
            <i class="bi bi-box-arrow-right"></i>
        </div>
        <div class="logout-modal-title">Sign Out?</div>
        <div class="logout-modal-sub">You're about to leave Task Organizo. Any unsaved changes will be lost. Are you sure you want to sign out?</div>
        <div class="logout-modal-actions">
            <button type="button" class="logout-modal-cancel" id="logoutCancel">
                <i class="bi bi-x-circle"></i> Stay Here
            </button>
            <form method="POST" action="/logout" style="flex:1;display:flex;">
                @csrf
                <button type="submit" class="logout-modal-confirm" style="width:100%;">
                    <i class="bi bi-box-arrow-right"></i> Yes, Logout
                </button>
            </form>
        </div>
    </div>
</div>

<div class="page-wrap">

    <section class="hero-section">
        <div class="hero-content">
            <div class="hero-eyebrow">
                <i class="bi bi-stars"></i>
                Your Productivity Companion
            </div>
            <h1 class="hero-title">
                Organize Tasks.<br>
                <span>Achieve More.</span>
            </h1>
            <p class="hero-subtitle">
                An all-in-one productivity tool designed to help you manage tasks efficiently, stay focused, and accomplish your goals — every single day.
            </p>
            <div class="hero-actions">
                <a href="/todos" class="btn-primary">
                    <i class="bi bi-plus-circle"></i> Get Started
                </a>
                <a href="#features" class="btn-ghost">
                    <i class="bi bi-play-circle"></i> See Features
                </a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="hero-stat-number">100%</div>
                    <div class="hero-stat-label">Free to Use</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-number">5+</div>
                    <div class="hero-stat-label">Categories</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-number">∞</div>
                    <div class="hero-stat-label">Tasks</div>
                </div>
            </div>
        </div>
    </section>

    <section id="features">
        <div class="section-wrap">
            <div class="section-header fade-in">
                <div class="section-eyebrow">
                    <i class="bi bi-lightning-charge"></i>
                    Core Features
                </div>
                <h2 class="section-title">Why Task Organizo Stands Out</h2>
                <p class="section-sub">Built for real people with real goals — fast, intuitive, and designed around how you actually work.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card fade-in">
                    <div class="feature-img-wrap">
                        <img src="{{ asset('images/task.jpg') }}" alt="Fast Task Management">
                    </div>
                    <div class="feature-body">
                        <div class="feature-icon-wrap"><i class="bi bi-lightning-charge-fill"></i></div>
                        <h3>Fast & Efficient Task Management</h3>
                        <p>Create, organize, and complete tasks instantly with a smooth and responsive system designed to keep up with your workflow without delays.</p>
                        <div class="feature-card-footer"><i class="bi bi-arrow-right-circle-fill"></i> Start organizing</div>
                    </div>
                </div>
                <div class="feature-card fade-in" style="transition-delay: 0.1s;">
                    <div class="feature-img-wrap">
                        <img src="{{ asset('images/smart.jpg') }}" alt="Smart Organization">
                    </div>
                    <div class="feature-body">
                        <div class="feature-icon-wrap"><i class="bi bi-diagram-3-fill"></i></div>
                        <h3>Smart Task Organization</h3>
                        <p>Keep everything structured with categories, priorities, and deadlines. Task Organizo helps you stay focused on what matters most every day.</p>
                        <div class="feature-card-footer"><i class="bi bi-arrow-right-circle-fill"></i> Explore categories</div>
                    </div>
                </div>
                <div class="feature-card fade-in" style="transition-delay: 0.2s;">
                    <div class="feature-img-wrap">
                        <img src="{{ asset('images/trust.jpg') }}" alt="Trusted Productivity Tool">
                    </div>
                    <div class="feature-body">
                        <div class="feature-icon-wrap"><i class="bi bi-shield-fill-check"></i></div>
                        <h3>Trusted by Productive Users</h3>
                        <p>Built for students, professionals, and teams who rely on Task Organizo to stay disciplined, organized, and consistently productive.</p>
                        <div class="feature-card-footer"><i class="bi bi-arrow-right-circle-fill"></i> Read reviews</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="reviews" class="reviews-section">
        <div class="section-wrap">
            <div class="section-header fade-in">
                <div class="section-eyebrow">
                    <i class="bi bi-chat-quote"></i>
                    Testimonials
                </div>
                <h2 class="section-title">What Our Users Say</h2>
                <p class="section-sub">Real people sharing how Task Organizo changed the way they work and plan their days.</p>
            </div>
            <div class="reviews-inner fade-in">
                <div class="reviews-grid">
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-avatar"><img src="{{ asset('images/pangit.jpg') }}" alt="Althea Shane D. Punzalan"></div>
                            <div class="review-meta">
                                <div class="review-author">Althea Shane D. Punzalan</div>
                                <div class="review-stars">★★★★★</div>
                            </div>
                        </div>
                        <div class="review-text">Task Organizo completely changed the way I manage my daily tasks. Everything is organized, simple, and I finally feel in control of my schedule!</div>
                    </div>
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-avatar"><img src="{{ asset('images/pogi.jpg') }}" alt="Louise Diego L. Añover"></div>
                            <div class="review-meta">
                                <div class="review-author">Louise Diego L. Añover</div>
                                <div class="review-stars">★★★★★</div>
                            </div>
                        </div>
                        <div class="review-text">As a busy student, Task Organizo helps me stay on top of deadlines and assignments. The reminders and task tracking are a total lifesaver!</div>
                    </div>
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-avatar"><img src="{{ asset('images/pangitdin.jpg') }}" alt="Zyra D. Casero"></div>
                            <div class="review-meta">
                                <div class="review-author">Zyra D. Casero</div>
                                <div class="review-stars">★★★★★</div>
                            </div>
                        </div>
                        <div class="review-text">I've tried many productivity apps, but Task Organizo stands out. It's simple, fast, and actually helps me get things done every day.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="founder">
        <div class="section-wrap">
            <div class="founder-section">
                <div class="founder-content fade-in">
                    <div class="section-eyebrow" style="align-self: flex-start;">
                        <i class="bi bi-person-heart"></i>
                        Meet the Founder
                    </div>
                    <h2>Jenalyn A. Robles</h2>
                    <p class="founder-bio">
                        Task Organizo was built with a clear mission: help people take control of their time, organize their tasks efficiently, and improve productivity every day. With a strong background in technology and productivity systems, Jenalyn designed Task Organizo to be simple, fast, and effective for students, professionals, and teams alike.
                    </p>
                    <div class="founder-badges">
                        <span class="founder-badge"><i class="bi bi-code-slash"></i> Developer</span>
                        <span class="founder-badge"><i class="bi bi-lightbulb"></i> Innovator</span>
                        <span class="founder-badge"><i class="bi bi-people"></i> Team Builder</span>
                    </div>
                    <div class="founder-actions">
                        <a href="#" class="btn-primary"><i class="bi bi-info-circle"></i> Learn More</a>
                        <a href="/todos" class="btn-ghost"><i class="bi bi-rocket-takeoff"></i> Get Started</a>
                    </div>
                </div>
                <div class="founder-img-wrap fade-in" style="transition-delay: 0.15s;">
                    <img src="{{ asset('images/founder.jpg') }}" alt="Jenalyn A. Robles - Founder of Task Organizo">
                    <div class="founder-img-badge">
                        <div class="founder-img-badge-name">Jenalyn A. Robles</div>
                        <div class="founder-img-badge-role">Founder & Developer</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<footer class="footer">
    <div class="footer-content">
        <div class="footer-top">
            <div class="footer-col">
                <h4>To-Do List</h4>
                <a href="#"><i class="bi bi-eye"></i> View Tasks</a>
                <a href="#"><i class="bi bi-plus-circle"></i> Add New Task</a>
                <a href="#"><i class="bi bi-check2-all"></i> Completed Tasks</a>
                <a href="#"><i class="bi bi-hourglass-split"></i> Pending Tasks</a>
            </div>
            <div class="footer-col">
                <h4>Categories</h4>
                <a href="#"><i class="bi bi-briefcase"></i> Work</a>
                <a href="#"><i class="bi bi-person"></i> Personal</a>
                <a href="#"><i class="bi bi-cart"></i> Shopping</a>
                <a href="#"><i class="bi bi-exclamation-triangle"></i> Urgent</a>
            </div>
            <div class="footer-col">
                <h4>Support</h4>
                <a href="#"><i class="bi bi-question-circle"></i> Help</a>
                <a href="#"><i class="bi bi-chat-left-text"></i> FAQ</a>
                <a href="#"><i class="bi bi-headset"></i> Contact Support</a>
                <a href="#"><i class="bi bi-star"></i> Feedback</a>
            </div>
            <div class="footer-col">
                <h4>Stay Updated</h4>
                <p>Get updates on your tasks and reminders.</p>
                <div class="newsletter-wrapper">
                    <div class="newsletter-row">
                        <input type="email" placeholder="Enter your email">
                        <button type="button"><i class="bi bi-send"></i> Subscribe</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="footer-logo-bottom">Task Organizo</div>
            <p class="footer-tagline">Organize your tasks efficiently, stay on top, and achieve your goals.</p>
            <div class="social-icons">
                <a href="#" class="social-link" aria-label="Facebook" target="_blank" rel="noopener"><i class="bi bi-facebook"></i></a>
                <a href="#" class="social-link" aria-label="Instagram" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a>
                <a href="#" class="social-link" aria-label="X" target="_blank" rel="noopener"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="social-link" aria-label="Telegram" target="_blank" rel="noopener"><i class="bi bi-telegram"></i></a>
            </div>
            <p class="footer-copy">© 2026 Task Organizo Inc. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const hamburger  = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');
    const navbar     = document.getElementById('navbar');

    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 50);
    });

    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('active');
        mobileMenu.classList.toggle('open');
        document.body.style.overflow = mobileMenu.classList.contains('open') ? 'hidden' : '';
    });

    document.querySelectorAll('.mobile-nav-link').forEach(link => {
        link.addEventListener('click', () => {
            hamburger.classList.remove('active');
            mobileMenu.classList.remove('open');
            document.body.style.overflow = '';
        });
    });

    mobileMenu.addEventListener('click', (e) => {
        if (e.target === mobileMenu) {
            hamburger.classList.remove('active');
            mobileMenu.classList.remove('open');
            document.body.style.overflow = '';
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            mobileMenu.classList.remove('open');
            hamburger.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            hamburger.classList.remove('active');
            mobileMenu.classList.remove('open');
            document.body.style.overflow = '';
            document.getElementById('logoutModal').classList.remove('show');
        }
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            const target   = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                const offset = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--nav-height')) || 70;
                const top    = target.getBoundingClientRect().top + window.scrollY - offset;
                window.scrollTo({ top, behavior: 'smooth' });
                if (window.innerWidth <= 768) {
                    hamburger.classList.remove('active');
                    mobileMenu.classList.remove('open');
                    document.body.style.overflow = '';
                }
            }
        });
    });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

    const logoutModal  = document.getElementById('logoutModal');
    const logoutCancel = document.getElementById('logoutCancel');

    document.getElementById('logoutTrigger').addEventListener('click', () => {
        logoutModal.classList.add('show');
    });

    document.getElementById('logoutTriggerMobile').addEventListener('click', () => {
        mobileMenu.classList.remove('open');
        hamburger.classList.remove('active');
        document.body.style.overflow = '';
        logoutModal.classList.add('show');
    });

    logoutCancel.addEventListener('click', () => {
        logoutModal.classList.remove('show');
        showToast('Glad you stayed!', 'success');
    });

    logoutModal.addEventListener('click', (e) => {
        if (e.target === logoutModal) logoutModal.classList.remove('show');
    });

    @if(session('success'))
        showToast(@json(session('success')), 'success');
    @endif

    @if(session('error'))
        showToast(@json(session('error')), 'error');
    @endif
});

function showToast(message, type) {
    type = type || 'success';
    const icons  = { success: 'bi-check-circle-fill', error: 'bi-x-circle-fill', info: 'bi-info-circle-fill', warning: 'bi-exclamation-triangle-fill' };
    const labels = { success: 'Success', error: 'Error', info: 'Info', warning: 'Warning' };
    const container = document.getElementById('toastContainer');
    const toast     = document.createElement('div');
    toast.className = 'toast ' + type;
    toast.innerHTML =
        '<div class="toast-side"></div>' +
        '<div class="toast-inner">' +
            '<div class="toast-icon-wrap"><i class="bi ' + (icons[type] || 'bi-info-circle-fill') + '"></i></div>' +
            '<div class="toast-body">' +
                '<div class="toast-label">' + (labels[type] || 'Info') + '</div>' +
                '<div class="toast-message">' + message + '</div>' +
            '</div>' +
        '</div>' +
        '<div class="toast-progress"></div>';
    container.appendChild(toast);
    requestAnimationFrame(() => {
        requestAnimationFrame(() => { toast.classList.add('show'); });
    });
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => { if (toast.parentNode) toast.parentNode.removeChild(toast); }, 500);
    }, 4000);
}
</script>

@endsection