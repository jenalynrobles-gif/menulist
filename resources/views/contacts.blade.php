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
    bottom: -2px; left: 50%;
    width: 0; height: 2px;
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

.hero-contact {
    min-height: 38vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    position: relative;
    overflow: hidden;
    padding: clamp(60px, 10vw, 100px) clamp(20px, 4vw, 40px) clamp(40px, 6vw, 60px);
}

.hero-contact::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse 80% 60% at 50% 40%, rgba(255,107,53,0.08) 0%, transparent 70%);
    pointer-events: none;
}

.hero-contact-content {
    max-width: 700px;
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
    font-size: clamp(2.8rem, 9vw, 5rem);
    font-weight: 900;
    background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    margin-bottom: clamp(16px, 2.5vw, 24px);
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
    font-size: clamp(1rem, 2.5vw, 1.2rem);
    color: rgba(255,255,255,0.75);
    line-height: 1.7;
    font-weight: 400;
}

.contact-section {
    max-width: 1400px;
    margin: 0 auto;
    padding: clamp(40px, 8vw, 80px) clamp(20px, 4vw, 40px) clamp(80px, 12vw, 120px);
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: clamp(3rem, 6vw, 5rem);
    align-items: start;
}

.contact-form-card {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(25px);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 32px;
    padding: clamp(36px, 6vw, 56px);
    position: relative;
    overflow: hidden;
}

.contact-form-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary), var(--primary-dark), var(--primary-light));
    border-radius: 32px 32px 0 0;
}

.card-eyebrow {
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

.card-title {
    font-size: clamp(1.8rem, 4vw, 2.6rem);
    font-weight: 900;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    letter-spacing: -0.5px;
    line-height: 1.15;
    margin-bottom: 12px;
}

.card-subtitle {
    font-size: clamp(0.95rem, 2vw, 1.05rem);
    color: rgba(255,255,255,0.72);
    line-height: 1.7;
    margin-bottom: clamp(28px, 5vw, 40px);
}

.contact-form { display: flex; flex-direction: column; gap: clamp(18px, 3vw, 24px); }

.form-group { position: relative; }

.form-group input,
.form-group textarea {
    width: 100%;
    padding: clamp(14px, 2.5vw, 18px) 24px;
    background: rgba(255,255,255,0.08);
    border: 2px solid rgba(255,255,255,0.15);
    border-radius: 20px;
    font-size: clamp(0.92rem, 1.8vw, 1rem);
    color: #fff;
    outline: none;
    backdrop-filter: blur(20px);
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    font-weight: 500;
    font-family: inherit;
}

.form-group input::placeholder,
.form-group textarea::placeholder { color: rgba(255,255,255,0.45); }

.form-group input:focus,
.form-group textarea:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(255,107,53,0.15);
    background: rgba(255,255,255,0.12);
    transform: translateY(-2px);
}

.form-group textarea {
    resize: vertical;
    min-height: clamp(140px, 18vw, 180px);
}

.submit-btn {
    padding: clamp(15px, 3vw, 18px);
    font-size: clamp(0.95rem, 2vw, 1.05rem);
    font-weight: 800;
    border: none;
    border-radius: 50px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #000;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
    box-shadow: 0 12px 32px rgba(255,107,53,0.4);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: clamp(8px, 1.5vw, 12px);
}

.submit-btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 48px rgba(255,107,53,0.55);
}

.contact-sidebar { display: flex; flex-direction: column; gap: clamp(20px, 3vw, 28px); }

.map-card {
    background: rgba(255,255,255,0.04);
    backdrop-filter: blur(25px);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 32px;
    overflow: hidden;
    position: relative;
    box-shadow: 0 25px 60px rgba(0,0,0,0.4);
    transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
}

.map-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary), var(--primary-dark), var(--primary-light));
    z-index: 10;
    border-radius: 32px 32px 0 0;
}

.map-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 40px 80px rgba(0,0,0,0.55);
    border-color: rgba(255,107,53,0.3);
}

.map-label {
    position: absolute;
    top: clamp(14px, 2vw, 20px);
    left: clamp(18px, 2.5vw, 24px);
    background: rgba(15,23,42,0.95);
    backdrop-filter: blur(20px);
    padding: clamp(8px, 1.2vw, 12px) clamp(14px, 2vw, 20px);
    border-radius: 20px;
    font-weight: 700;
    font-size: clamp(0.78rem, 1.6vw, 0.88rem);
    color: var(--primary);
    border: 1px solid rgba(255,107,53,0.3);
    z-index: 15;
    display: flex;
    align-items: center;
    gap: 6px;
}

.map-card iframe {
    width: 100%;
    height: clamp(300px, 35vw, 380px);
    border: none;
    display: block;
    filter: contrast(1.1) brightness(1.05) saturate(1.2);
    transition: filter 0.3s ease;
}

.map-card:hover iframe { filter: contrast(1.15) brightness(1.08) saturate(1.3); }

.info-cards { display: flex; flex-direction: column; gap: clamp(14px, 2vw, 18px); }

.info-card {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 24px;
    padding: clamp(20px, 3vw, 28px);
    display: flex;
    align-items: flex-start;
    gap: 18px;
    transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
    position: relative;
    overflow: hidden;
}

.info-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; bottom: 0;
    width: 4px;
    background: linear-gradient(180deg, var(--primary), var(--primary-dark));
    border-radius: 24px 0 0 24px;
}

.info-card:hover {
    transform: translateX(6px);
    border-color: rgba(255,107,53,0.3);
    background: rgba(255,255,255,0.08);
}

.info-icon {
    width: 48px; height: 48px;
    border-radius: 16px;
    background: rgba(255,107,53,0.15);
    border: 1px solid rgba(255,107,53,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: var(--primary);
    flex-shrink: 0;
}

.info-text { flex: 1; min-width: 0; }
.info-label { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: var(--primary-light); margin-bottom: 4px; }
.info-value { font-size: clamp(0.9rem, 1.8vw, 1rem); font-weight: 600; color: rgba(255,255,255,0.9); }

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

.toast-container {
    position: fixed;
    top: calc(var(--nav-height) + 24px);
    right: clamp(20px, 3vw, 40px);
    z-index: 10001;
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 480px;
    pointer-events: none;
}

.toast {
    width: clamp(380px, 38vw, 480px);
    padding: 0;
    border-radius: 28px;
    color: #fff;
    font-weight: 500;
    font-size: 1rem;
    line-height: 1.6;
    backdrop-filter: blur(28px);
    transform: translateX(110%) scale(0.95);
    opacity: 0;
    transition: transform 0.5s cubic-bezier(0.22,1,0.36,1), opacity 0.4s ease;
    position: relative;
    display: flex;
    align-items: stretch;
    pointer-events: all;
    box-shadow: 0 32px 80px rgba(0,0,0,0.65), 0 1px 0 rgba(255,255,255,0.07) inset;
    overflow: hidden;
}

.toast.show { transform: translateX(0) scale(1); opacity: 1; }

.toast-side { width: 8px; flex-shrink: 0; border-radius: 28px 0 0 28px; }
.toast-inner { display: flex; align-items: center; gap: 20px; padding: 40px 28px 40px 22px; flex: 1; }

.toast-icon-wrap {
    width: 64px; height: 64px;
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    font-size: 2rem;
}

.toast-body { flex: 1; min-width: 0; }
.toast-label { font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.6px; opacity: 0.75; margin-bottom: 8px; }
.toast-message { color: rgba(255,255,255,0.95); font-size: 1.05rem; font-weight: 500; line-height: 1.6; }

.toast-progress {
    position: absolute;
    bottom: 0; left: 8px; right: 0;
    height: 5px;
    border-radius: 0 0 28px 0;
    opacity: 0.5;
    animation: toastProgress 7s linear forwards;
}

@keyframes toastProgress { from { width: calc(100% - 6px); } to { width: 0; } }

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

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(40px); }
    to   { opacity: 1; transform: translateY(0); }
}

.fade-in { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
.fade-in.visible { opacity: 1; transform: translateY(0); }

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

@media (max-width: 1024px) {
    .contact-grid { grid-template-columns: 1fr; gap: 3rem; }
}

@media (max-width: 768px) {
    .navbar { height: 65px; }
    .navbar.scrolled { height: 60px; }
    .page-wrap { padding-top: 65px; }
    .nav-menu { display: none; }
    .hamburger { display: flex; }
    .nav-actions { display: none; }
    .newsletter-row { flex-direction: column; }
    .newsletter-row input { min-width: auto; }
    .footer-top { grid-template-columns: 1fr; text-align: center; gap: 2.5rem; }
    .footer-col h4::after { left: 50%; transform: translateX(-50%); }
    .social-icons { gap: 0.75rem; }
    .social-link { width: 44px; height: 44px; }
    .footer-col a { justify-content: center; }
    .toast-container { right: 12px; left: 12px; max-width: none; top: calc(65px + 16px); }
    .toast { width: 100%; min-width: auto; }
    .toast-inner { padding: 32px 20px 32px 16px; }
    .logout-modal-actions { flex-direction: column; }
}

@media (max-width: 480px) {
    .nav-container { padding: 0 8px; }
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
            <li><a href="/landing" class="nav-link">Home</a></li>
            <li><a href="/todos" class="nav-link">Menu List</a></li>
            <li><a href="/contacts" class="nav-link active">Contacts</a></li>
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
        <li><a href="/landing" class="mobile-nav-link">Home</a></li>
        <li><a href="/todos" class="mobile-nav-link">Menu List</a></li>
        <li><a href="/contacts" class="mobile-nav-link active">Contacts</a></li>
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

    <section class="hero-contact">
        <div class="hero-contact-content">
            <div class="hero-eyebrow">
                <i class="bi bi-chat-heart"></i>
                Get In Touch
            </div>
            <h1 class="hero-title">
                Let's <span>Talk.</span>
            </h1>
            <p class="hero-subtitle">
                Have questions or need help? We're here for you. Send us a message and we'll get back to you promptly.
            </p>
        </div>
    </section>

    <section class="contact-section">
        <div class="contact-grid">

            <div class="contact-form-card fade-in">
                <div class="card-eyebrow">
                    <i class="bi bi-envelope-paper"></i>
                    Send a Message
                </div>
                <h2 class="card-title">Contact Us</h2>
                <p class="card-subtitle">Fill out the form below and our team will respond as soon as possible.</p>
                <form action="{{ route('contacts.store') }}" method="POST" class="contact-form">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="fullname" placeholder="Full Name" value="{{ old('fullname') }}" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <textarea name="message" placeholder="Your Message" required>{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="submit-btn">
                        <i class="bi bi-send-fill"></i> Send Message
                    </button>
                </form>
            </div>

            <div class="contact-sidebar fade-in" style="transition-delay: 0.15s;">
                <div class="map-card">
                    <div class="map-label">
                        <i class="bi bi-geo-alt-fill"></i> Our Location
                    </div>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3865.7345152508883!2d121.08009278928637!3d14.326847738462027!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d7000c04f94f%3A0x66b426055193ab!2sSanto%20Tomas%20binan%20laguna!5e0!3m2!1sen!2sph!4v1778380844923!5m2!1sen!2sph"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <div class="info-cards">
                    <div class="info-card">
                        <div class="info-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div class="info-text">
                            <div class="info-label">Address</div>
                            <div class="info-value">Santo Tomas, Biñan, Laguna, Philippines</div>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon"><i class="bi bi-envelope-fill"></i></div>
                        <div class="info-text">
                            <div class="info-label">Email</div>
                            <div class="info-value">jenalyn.robles@cvsu.edu.ph</div>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon"><i class="bi bi-clock-fill"></i></div>
                        <div class="info-text">
                            <div class="info-label">Response Time</div>
                            <div class="info-value">Within 24 hours on business days</div>
                        </div>
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
    const logoutModal = document.getElementById('logoutModal');

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
            logoutModal.classList.remove('show');
        }
    });

    document.getElementById('logoutTrigger').addEventListener('click', () => {
        logoutModal.classList.add('show');
    });

    document.getElementById('logoutTriggerMobile').addEventListener('click', () => {
        mobileMenu.classList.remove('open');
        hamburger.classList.remove('active');
        document.body.style.overflow = '';
        logoutModal.classList.add('show');
    });

    document.getElementById('logoutCancel').addEventListener('click', () => {
        logoutModal.classList.remove('show');
        showToast('Glad you stayed!', 'success');
    });

    logoutModal.addEventListener('click', (e) => {
        if (e.target === logoutModal) logoutModal.classList.remove('show');
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

    @if(session('success'))
        showToast(@json(session('success')), 'success');
    @endif

    @if(session('error'))
        showToast(@json(session('error')), 'error');
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            showToast(@json($error), 'error');
        @endforeach
    @endif
});

function showToast(message, type) {
    type = type || 'success';
    const icons  = { success: 'bi-check-circle-fill', error: 'bi-x-circle-fill', info: 'bi-info-circle-fill' };
    const labels = { success: 'Success', error: 'Error', info: 'Info' };
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
    }, 7000);
}
</script>

@endsection