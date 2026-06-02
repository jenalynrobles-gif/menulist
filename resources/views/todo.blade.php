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
    flex: none;
    justify-content: center;
    align-items: center;
    list-style: none !important;
}

.nav-menu li {
    list-style: none !important;
    padding: 0;
    margin: 0;
}

.nav-link {
    color: rgba(255,255,255,0.9);
    text-decoration: none;
    font-weight: 500;
    font-size: clamp(0.85rem, 2vw, 0.9rem);
    padding: 8px 0;
    position: relative;
    display: inline-block;
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
.nav-link.active::after {
    width: 100%;
}

.nav-link:hover, .nav-link.active { color: #fff; }
.nav-link:hover::after { width: 100%; }

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
    list-style: none !important;
    margin: 0; padding: 0;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    align-items: center;
    justify-content: center;
}

.mobile-nav-links li {
    list-style: none !important;
    padding: 0;
    margin: 0;
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

.page-wrap { min-height: 100vh; background: transparent; position: relative; padding-top: var(--nav-height); }
.page-content { position: relative; z-index: 2; min-height: 100vh; display: flex; flex-direction: column; }

.main-content {
    flex: 1;
    max-width: 1400px;
    margin: 0 auto;
    padding: clamp(100px, 15vw, 140px) clamp(20px, 4vw, 40px);
}

.hero-section { text-align: center; margin-bottom: clamp(60px, 8vw, 80px); }

.title {
    font-size: clamp(2.5rem, 8vw, 4.5rem);
    font-weight: 900;
    line-height: 1.1;
    letter-spacing: -0.8px;
    animation: fadeInUp 1s ease;
    margin-bottom: clamp(20px, 4vw, 32px);
}

.title-white {
    background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.title-orange {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark), var(--primary-light));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.subtitle {
    color: rgba(255,255,255,0.95);
    font-size: clamp(1.1rem, 3vw, 1.6rem);
    margin-bottom: clamp(40px, 6vw, 60px);
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
    font-weight: 400;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: clamp(20px, 4vw, 32px);
    margin-bottom: clamp(60px, 8vw, 80px);
}

.stat-card {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 24px;
    padding: clamp(24px, 5vw, 32px);
    text-align: center;
    transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
    position: relative;
    overflow: hidden;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary), var(--primary-dark), var(--primary-light));
    border-radius: 24px 24px 0 0;
}

.stat-card:hover {
    transform: translateY(-12px);
    background: rgba(255,255,255,0.08);
    border-color: rgba(255,107,53,0.3);
    box-shadow: 0 25px 50px rgba(0,0,0,0.3);
}

.stat-number { font-size: clamp(2rem, 6vw, 3rem); font-weight: 900; margin-bottom: clamp(8px, 2vw, 12px); }
.stat-label { color: rgba(255,255,255,0.85); font-weight: 600; font-size: clamp(0.9rem, 2vw, 1rem); letter-spacing: 0.5px; display: flex; align-items: center; justify-content: center; gap: 6px; }

.task-form-container {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(30px);
    border: 1px solid rgba(255,107,53,0.25);
    border-radius: 32px;
    padding: clamp(32px, 6vw, 48px);
    margin-bottom: clamp(60px, 8vw, 80px);
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    position: relative;
    overflow: hidden;
}

.form-title {
    font-size: clamp(1.8rem, 4vw, 2.2rem);
    margin-bottom: clamp(24px, 4vw, 32px);
    font-weight: 800;
    text-align: center;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.modern-task-form { display: flex; flex-direction: column; gap: clamp(20px, 4vw, 28px); }
.input-group { display: flex; flex-direction: column; gap: 10px; }
.input-group label { color: rgba(255,255,255,0.85); font-weight: 700; font-size: clamp(0.9rem, 2vw, 1rem); display: flex; align-items: center; gap: 6px; }

.modern-input {
    width: 100%;
    background: rgba(255,255,255,0.08);
    border: 2px solid rgba(255,255,255,0.15);
    border-radius: 20px;
    padding: clamp(16px, 3vw, 20px) 24px;
    color: #afafaf;
    font-size: 1rem;
    outline: none;
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    font-weight: 500;
}

.modern-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(255,107,53,0.15);
    background: rgba(255,255,255,0.12);
    transform: translateY(-1px);
}

.modern-input::placeholder { color: rgba(255,255,255,0.5); }
.modern-textarea { min-height: 120px; resize: vertical; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: clamp(16px, 3vw, 24px); }

.modern-add-btn {
    border: none;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #000;
    padding: clamp(16px, 3vw, 20px);
    border-radius: 25px;
    font-size: clamp(1rem, 2.5vw, 1.1rem);
    font-weight: 800;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
    box-shadow: 0 15px 40px rgba(255,107,53,0.35);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.modern-add-btn:hover { transform: translateY(-4px); box-shadow: 0 20px 50px rgba(255,107,53,0.5); }
.modern-add-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

.filters-container {
    display: flex;
    justify-content: center;
    gap: clamp(12px, 2vw, 16px);
    flex-wrap: wrap;
    margin-bottom: clamp(24px, 4vw, 32px);
}

.filter-btn {
    background: rgba(255,255,255,0.08);
    color: #fff;
    border: 2px solid rgba(255,255,255,0.15);
    padding: clamp(14px, 3vw, 18px) clamp(24px, 4vw, 32px);
    border-radius: 25px;
    font-weight: 700;
    cursor: pointer;
    font-size: clamp(0.85rem, 2vw, 0.95rem);
    text-transform: uppercase;
    letter-spacing: 0.3px;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
}

.filter-btn:hover { border-color: var(--primary); background: rgba(255,107,53,0.15); transform: translateY(-2px); }

.filter-btn.active {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
    border-color: var(--primary) !important;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 15px 40px rgba(255,107,53,0.4);
}

.count-badge {
    border-radius: 12px;
    padding: 4px 10px;
    font-size: 0.8rem;
    font-weight: 700;
    min-width: 28px;
    text-align: center;
}

.count-badge.badge-all     { background: rgba(59,130,246,0.3);  color: #3b82f6; border: 1px solid rgba(59,130,246,0.5); }
.count-badge.badge-pending { background: rgba(245,158,11,0.3);  color: #f59e0b; border: 1px solid rgba(245,158,11,0.5); }
.count-badge.badge-done    { background: rgba(16,185,129,0.3);  color: #10b981; border: 1px solid rgba(16,185,129,0.5); }

.filter-btn.active .count-badge {
    background: rgba(255,255,255,0.4) !important;
    color: #fff !important;
    border-color: rgba(255,255,255,0.6) !important;
}

.organize-menu-section {
    background: rgba(255,255,255,0.04);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(255, 107, 53, 0.2);
    border-radius: 28px;
    padding: clamp(28px, 5vw, 40px);
    margin-bottom: clamp(40px, 6vw, 60px);
    position: relative;
    overflow: hidden;
}

.organize-menu-section::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary), var(--primary-dark), var(--primary-light), transparent);
    border-radius: 28px 28px 0 0;
}

.organize-menu-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
}

.organize-menu-title {
    font-size: clamp(1.1rem, 2.5vw, 1.25rem);
    font-weight: 800;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 10px;
}

.organize-menu-title i {
    font-size: 1.3rem;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.organize-reset-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.6);
    padding: 9px 20px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}

.organize-reset-btn:hover {
    background: rgba(255,107,53,0.15);
    border-color: rgba(255,107,53,0.4);
    color: var(--primary);
}

.organize-divider { height: 1px; background: rgba(255,255,255,0.07); margin-bottom: 24px; }
.organize-groups { display: flex; flex-direction: column; gap: 24px; }
.organize-group { display: flex; flex-direction: column; gap: 12px; }

.organize-group-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    color: rgba(255,255,255,0.4);
}

.organize-group-label i { font-size: 0.9rem; color: var(--primary-dark); opacity: 0.8; }

.organize-group-label::after {
    content: '';
    flex: 1;
    height: 1px;
    background: rgba(255,255,255,0.07);
}

.organize-chips { display: flex; flex-wrap: wrap; gap: 10px; }

.organize-chip {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    border-radius: 20px;
    border: 1.5px solid rgba(255,255,255,0.12);
    background: rgba(255,255,255,0.05);
    color: rgba(255,255,255,0.75);
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
    user-select: none;
    white-space: nowrap;
}

.organize-chip i { font-size: 1rem; transition: color 0.25s; }

.organize-chip:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.25);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.2);
}

.organize-chip.active {
    background: rgba(255,107,53,0.18);
    border-color: rgba(255,107,53,0.55);
    color: #fff;
    box-shadow: 0 4px 18px rgba(255,107,53,0.25);
    transform: translateY(-2px);
}

.organize-chip.active i { color: var(--primary-light); }

.chip-icon-work     { color: #3b82f6; }
.chip-icon-personal { color: #a855f7; }
.chip-icon-shopping { color: #ec4899; }
.chip-icon-urgent   { color: #ef4444; }
.chip-icon-other    { color: #6b7280; }
.chip-icon-high     { color: #ef4444; }
.chip-icon-medium   { color: #f59e0b; }
.chip-icon-low      { color: #10b981; }
.chip-icon-today    { color: #f97316; }
.chip-icon-week     { color: #3b82f6; }
.chip-icon-overdue  { color: #ef4444; }
.chip-icon-nodate   { color: #6b7280; }

.active-organize-info {
    display: none;
    align-items: center;
    gap: 10px;
    padding: 13px 20px;
    background: rgba(255,107,53,0.08);
    border: 1px solid rgba(255,107,53,0.22);
    border-radius: 16px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.active-organize-info.visible { display: flex; }
.active-organize-info > i { font-size: 1rem; color: var(--primary); }
.active-organize-info span { font-size: 0.85rem; color: rgba(255,255,255,0.75); font-weight: 500; }

.active-organize-tag {
    background: rgba(255,107,53,0.2);
    border: 1px solid rgba(255,107,53,0.4);
    color: var(--primary-light);
    padding: 3px 12px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 700;
}

.organize-count-pill {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.5);
    padding: 3px 10px;
    border-radius: 10px;
    font-size: 0.78rem;
    font-weight: 600;
    margin-left: auto;
}

.tasks-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: clamp(24px, 4vw, 32px);
    align-items: start;
}

.task-card {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 28px;
    overflow: hidden;
    backdrop-filter: blur(25px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.3);
    transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
    position: relative;
    min-height: 320px;
    cursor: pointer;
}

.task-card:hover {
    border-color: rgba(255,107,53,0.4);
    transform: translateY(-12px) scale(1.02);
    box-shadow: 0 32px 80px rgba(0,0,0,0.5);
}

.task-card.hidden-by-filter { display: none; }

.card-accent { height: 4px; opacity: 0; transition: opacity 0.3s ease; background: linear-gradient(90deg, transparent, var(--primary-dark), transparent); }
.task-card:hover .card-accent { opacity: 1; }

.card-content { height: 100%; display: flex; flex-direction: column; gap: 20px; padding: clamp(24px, 4vw, 32px); }
.card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 12px; }

.status-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 1px solid;
    display: flex;
    align-items: center;
    gap: 6px;
}

.badge-pending { color: var(--primary-dark); background: rgba(247,147,30,0.15); border-color: rgba(247,147,30,0.3); }
.badge-done    { color: #10b981; background: rgba(16,185,129,0.15); border-color: rgba(16,185,129,0.3); }

.task-actions { display: flex; gap: 10px; align-items: center; }

.edit-btn, .info-btn, .delete-btn {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 50%;
    width: 42px; height: 42px;
    color: rgba(255,255,255,0.7);
    cursor: pointer;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.edit-btn:hover   { background: rgba(59,130,246,0.2);  border-color: rgba(59,130,246,0.4);  color: #3b82f6; transform: scale(1.1); }
.info-btn:hover   { background: rgba(245,158,11,0.2);  border-color: rgba(245,158,11,0.4);  color: #f59e0b; transform: scale(1.1); }
.delete-btn:hover { background: rgba(239,68,68,0.2);   border-color: rgba(239,68,68,0.4);   color: #ef4444; transform: scale(1.1); }

.task-title { font-size: clamp(1.3rem, 3vw, 1.5rem); font-weight: 800; margin-bottom: 16px; line-height: 1.3; color: #fff; word-break: break-word; }
.task-title.done { text-decoration: line-through; color: rgba(255,255,255,0.5); }

.task-description { color: rgba(255,255,255,0.8); line-height: 1.6; font-size: 0.95rem; margin-bottom: 20px; word-break: break-word; }

.task-meta { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px; align-items: center; }
.task-meta-item { display: flex; align-items: center; gap: 6px; color: rgba(255,255,255,0.65); font-size: 0.9rem; }
.task-meta-item i { font-size: 0.95rem; }

.priority-badge { padding: 4px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
.priority-low    { background: rgba(16,185,129,0.2);  color: #10b981; }
.priority-medium { background: rgba(245,158,11,0.2);  color: #f59e0b; }
.priority-high   { background: rgba(239,68,68,0.2);   color: #ef4444; }

.category-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 13px;
    border-radius: 14px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 1px solid transparent;
    transition: all 0.2s ease;
}

.category-work     { background: rgba(59,130,246,0.15);  color: #60a5fa; border-color: rgba(59,130,246,0.3); }
.category-personal { background: rgba(168,85,247,0.15); color: #c084fc; border-color: rgba(168,85,247,0.3); }
.category-shopping { background: rgba(236,72,153,0.15); color: #f472b6; border-color: rgba(236,72,153,0.3); }
.category-urgent   { background: rgba(239,68,68,0.15);  color: #f87171; border-color: rgba(239,68,68,0.3); }
.category-other    { background: rgba(107,114,128,0.15); color: #9ca3af; border-color: rgba(107,114,128,0.3); }

.task-date { color: rgba(255,255,255,0.5); font-size: 0.9rem; line-height: 1.5; display: flex; align-items: center; gap: 6px; }
.card-actions { margin-top: auto; }

.toggle-btn {
    width: 100%;
    padding: clamp(16px, 3vw, 20px);
    border-radius: 25px;
    color: #fff;
    font-weight: 800;
    font-size: 1rem;
    cursor: pointer;
    letter-spacing: 0.4px;
    text-transform: uppercase;
    transition: all 0.3s ease;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.toggle-btn.not-done { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); box-shadow: 0 12px 36px rgba(255,107,53,0.4); }
.toggle-btn.is-done  { background: rgba(255,255,255,0.08); border: 2px solid rgba(255,255,255,0.15); }
.toggle-btn:hover    { transform: translateY(-3px) scale(1.02); box-shadow: 0 20px 50px rgba(0,0,0,0.4); }

.empty-state { text-align: center; padding: clamp(120px, 20vw, 160px) clamp(40px, 8vw, 60px); color: rgba(255,255,255,0.6); }
.empty-icon  { font-size: clamp(4rem, 12vw, 6rem); margin-bottom: clamp(32px, 6vw, 48px); color: rgba(255,107,53,0.4); }
.empty-title  { color: #fff; font-size: clamp(2rem, 6vw, 2.5rem); font-weight: 800; margin-bottom: 16px; }
.empty-subtitle { font-size: clamp(1rem, 2.5vw, 1.2rem); max-width: 500px; margin: 0 auto; line-height: 1.6; }

.no-results-state { text-align: center; padding: clamp(80px, 14vw, 120px) clamp(40px, 8vw, 60px); color: rgba(255,255,255,0.6); display: none; }
.no-results-state.visible { display: block; }

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
    -webkit-backdrop-filter: blur(28px);
    transform: translateX(110%) scale(0.9);
    opacity: 0;
    transition: transform 0.45s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.35s ease;
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
    flex-shrink: 0; font-size: 1rem; margin-top: 1px;
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

.modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
.modal-title  { font-size: clamp(1.4rem, 3vw, 1.8rem); font-weight: 800; color: #fff; display: flex; align-items: center; gap: 10px; }
.modal-title i { color: var(--primary); }

.modal-close {
    width: 44px; height: 44px;
    border: none; border-radius: 50%;
    background: rgba(255,255,255,0.1);
    color: #fff; font-size: 1.1rem;
    cursor: pointer; transition: all 0.3s ease;
    display: flex; align-items: center; justify-content: center;
}

.modal-close:hover { background: #ef4444; transform: scale(1.1); }

.modal-body { margin-bottom: 28px; }

.modal-info-row {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 14px 0;
    border-bottom: 1px solid rgba(255,255,255,0.07);
}

.modal-info-row:last-child { border-bottom: none; }

.modal-info-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: rgba(255,107,53,0.12);
    border: 1px solid rgba(255,107,53,0.2);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 1rem; color: var(--primary);
}

.modal-info-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.9px; color: rgba(255,255,255,0.4); margin-bottom: 4px; }
.modal-info-value { color: rgba(255,255,255,0.9); font-size: 0.95rem; font-weight: 500; line-height: 1.5; }

.edit-input {
    width: 100%;
    background: rgba(255,255,255,0.12);
    border: 2px solid rgba(255,255,255,0.25);
    border-radius: 20px;
    padding: clamp(16px, 3vw, 20px) 24px;
    font-size: 1rem;
    color: #afafaf;
    outline: none;
    font-family: inherit;
    transition: all 0.3s ease;
    margin-bottom: 20px;
}

.edit-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(255,107,53,0.2);
    background: rgba(255,255,255,0.18);
}

.edit-input::placeholder { color: rgba(255,255,255,0.5); }

.modal-actions { display: flex; gap: 16px; justify-content: flex-end; }

.modal-btn {
    padding: clamp(14px, 3vw, 18px) clamp(24px, 4vw, 32px);
    border-radius: 25px;
    font-weight: 700;
    font-size: clamp(0.9rem, 2vw, 1rem);
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: none;
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    font-family: inherit;
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 8px;
}

.modal-btn-primary   { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #000; box-shadow: 0 12px 35px rgba(255,107,53,0.4); }
.modal-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 18px 45px rgba(255,107,53,0.5); }
.modal-btn-secondary { background: rgba(255,255,255,0.1); color: #fff; border: 2px solid rgba(255,255,255,0.2); }
.modal-btn-secondary:hover { background: rgba(255,255,255,0.2); transform: translateY(-2px); }

.logout-modal-icon {
    width: 72px; height: 72px;
    border-radius: 24px;
    background: rgba(255,107,53,0.12);
    border: 1px solid rgba(255,107,53,0.3);
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem; color: var(--primary);
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

.logout-modal-actions { display: flex; gap: 14px; }

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
    display: flex; align-items: center; justify-content: center;
    gap: 8px; font-family: inherit;
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
    display: flex; align-items: center; justify-content: center;
    gap: 8px; font-family: inherit;
}

.logout-modal-confirm:hover { transform: translateY(-2px); box-shadow: 0 18px 44px rgba(255,107,53,0.55); }

.landing-divider {
    width: 100%;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,107,53,0.3), transparent);
    margin: clamp(60px, 8vw, 100px) 0 0;
}

.section-wrap {
    max-width: 1400px;
    margin: 0 auto;
    padding: clamp(80px, 12vw, 120px) clamp(20px, 4vw, 40px);
}

.section-header { text-align: center; margin-bottom: clamp(48px, 7vw, 72px); }

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

.tips-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: clamp(20px, 3vw, 28px);
}

.tip-card {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 28px;
    padding: clamp(28px, 4vw, 40px);
    transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.tip-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary), var(--primary-dark), var(--primary-light));
    border-radius: 28px 28px 0 0;
}

.tip-card:hover {
    transform: translateY(-14px) scale(1.02);
    background: rgba(255,255,255,0.08);
    border-color: rgba(255,107,53,0.35);
    box-shadow: 0 32px 72px rgba(0,0,0,0.45);
}

.tip-step {
    width: 48px; height: 48px;
    border-radius: 16px;
    background: rgba(255,107,53,0.15);
    border: 1px solid rgba(255,107,53,0.3);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; color: var(--primary);
}

.tip-card h3 { font-size: clamp(1.1rem, 2.5vw, 1.25rem); font-weight: 800; color: #fff; line-height: 1.3; }
.tip-card p  { color: rgba(255,255,255,0.75); font-size: clamp(0.88rem, 1.8vw, 0.95rem); line-height: 1.65; flex: 1; }

.tip-number {
    font-size: clamp(3rem, 7vw, 4rem);
    font-weight: 900;
    background: linear-gradient(135deg, rgba(255,107,53,0.15), rgba(247,147,30,0.1));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    line-height: 1;
    position: absolute;
    bottom: 20px; right: 24px;
    pointer-events: none;
}

.shortcuts-section {
    background: rgba(255,255,255,0.02);
    border-top: 1px solid rgba(255,255,255,0.06);
    border-bottom: 1px solid rgba(255,255,255,0.06);
}

.shortcuts-inner {
    background: rgba(255,255,255,0.04);
    backdrop-filter: blur(28px);
    border: 1px solid rgba(255,107,53,0.2);
    border-radius: 32px;
    padding: clamp(40px, 6vw, 64px) clamp(28px, 5vw, 56px);
    position: relative;
    overflow: hidden;
}

.shortcuts-inner::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary), var(--primary-dark), var(--primary-light), transparent);
    border-radius: 32px 32px 0 0;
}

.shortcuts-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: clamp(16px, 2.5vw, 24px);
}

.shortcut-card {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 20px;
    padding: clamp(20px, 3vw, 28px);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    text-decoration: none;
    cursor: pointer;
}

.shortcut-card:hover {
    transform: translateY(-6px);
    border-color: rgba(255,107,53,0.35);
    background: rgba(255,255,255,0.08);
    box-shadow: 0 20px 48px rgba(0,0,0,0.35);
}

.shortcut-icon {
    width: 52px; height: 52px;
    border-radius: 16px;
    background: rgba(255,107,53,0.15);
    border: 1px solid rgba(255,107,53,0.3);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; color: var(--primary);
    flex-shrink: 0;
}

.shortcut-text { flex: 1; min-width: 0; }
.shortcut-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.9px; color: var(--primary-light); margin-bottom: 4px; }
.shortcut-title { font-size: clamp(0.9rem, 1.8vw, 1rem); font-weight: 700; color: #fff; }

.cta-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: clamp(48px, 8vw, 80px);
    align-items: center;
}

.cta-content { display: flex; flex-direction: column; gap: 24px; }

.cta-content h2 {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 900;
    line-height: 1.15;
    letter-spacing: -0.5px;
}

.cta-content h2 .white { color: #fff; }
.cta-content h2 .orange {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.cta-bio { font-size: clamp(0.95rem, 2vw, 1.05rem); line-height: 1.85; color: rgba(255,255,255,0.82); }

.cta-badges { display: flex; gap: 10px; flex-wrap: wrap; }

.cta-badge {
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

.cta-actions { display: flex; gap: 14px; flex-wrap: wrap; }

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

.cta-visual {
    background: rgba(255,255,255,0.04);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,107,53,0.2);
    border-radius: 32px;
    padding: clamp(28px, 4vw, 40px);
    display: flex;
    flex-direction: column;
    gap: 16px;
    position: relative;
    overflow: hidden;
}

.cta-visual::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary), var(--primary-dark), var(--primary-light));
    border-radius: 32px 32px 0 0;
}

.cta-visual-title {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--primary-light);
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.cta-visual-empty {
    text-align: center;
    padding: 32px 16px;
    color: rgba(255,255,255,0.35);
    font-size: 0.9rem;
    font-weight: 500;
}

.cta-visual-empty i {
    display: block;
    font-size: 2.5rem;
    margin-bottom: 12px;
    color: rgba(255,107,53,0.3);
}

.mock-task {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 16px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: all 0.3s ease;
}

.mock-task:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,107,53,0.25); }

.mock-check {
    width: 24px; height: 24px;
    border-radius: 8px;
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem;
}

.mock-check.done   { background: rgba(16,185,129,0.2); border: 1px solid rgba(16,185,129,0.4); color: #10b981; }
.mock-check.undone { background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.2); }

.mock-task-text { flex: 1; min-width: 0; }
.mock-task-title { font-size: 0.9rem; font-weight: 600; color: #fff; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.mock-task-title.done { text-decoration: line-through; color: rgba(255,255,255,0.4); }
.mock-task-meta { font-size: 0.75rem; color: rgba(255,255,255,0.45); }

.mock-priority {
    padding: 3px 10px;
    border-radius: 10px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    flex-shrink: 0;
}

.mock-priority.high   { background: rgba(239,68,68,0.2);  color: #ef4444; }
.mock-priority.medium { background: rgba(245,158,11,0.2); color: #f59e0b; }
.mock-priority.low    { background: rgba(16,185,129,0.2); color: #10b981; }

.toggle-modal-icon {
    width: 72px; height: 72px;
    border-radius: 24px;
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem;
    margin: 0 auto 24px;
}

.toggle-modal-icon.completing {
    background: rgba(16,185,129,0.12);
    border: 1px solid rgba(16,185,129,0.3);
    color: #10b981;
}

.toggle-modal-icon.undoing {
    background: rgba(255,107,53,0.12);
    border: 1px solid rgba(255,107,53,0.3);
    color: var(--primary);
}

.toggle-modal-title {
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

.toggle-modal-task-preview {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 16px;
    padding: 14px 20px;
    margin-bottom: 20px;
    color: rgba(255,255,255,0.8);
    font-size: 0.95rem;
    font-weight: 600;
    text-align: center;
    line-height: 1.4;
}

.toggle-modal-sub {
    text-align: center;
    color: rgba(255,255,255,0.6);
    font-size: 0.95rem;
    line-height: 1.65;
    margin-bottom: 32px;
}

.toggle-modal-actions { display: flex; gap: 14px; }

.toggle-modal-cancel {
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
    display: flex; align-items: center; justify-content: center;
    gap: 8px; font-family: inherit;
}

.toggle-modal-cancel:hover { background: rgba(255,255,255,0.14); border-color: rgba(255,255,255,0.3); transform: translateY(-2px); }

.toggle-modal-confirm {
    flex: 1;
    border: none;
    padding: 16px;
    border-radius: 20px;
    font-size: 0.95rem;
    font-weight: 800;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex; align-items: center; justify-content: center;
    gap: 8px; font-family: inherit;
}

.toggle-modal-confirm.completing {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    box-shadow: 0 12px 32px rgba(16,185,129,0.4);
}

.toggle-modal-confirm.completing:hover { transform: translateY(-2px); box-shadow: 0 18px 44px rgba(16,185,129,0.55); }

.toggle-modal-confirm.undoing {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #000;
    box-shadow: 0 12px 32px rgba(255,107,53,0.4);
}

.toggle-modal-confirm.undoing:hover { transform: translateY(-2px); box-shadow: 0 18px 44px rgba(255,107,53,0.55); }

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
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.2rem;
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
    flex-shrink: 0;
}

.social-link:hover { transform: translateY(-4px) scale(1.08); box-shadow: 0 15px 35px rgba(255,107,53,0.4); border-color: rgba(255,107,53,0.3); }
.footer-copy { color: rgba(255,255,255,0.4); font-size: 0.85rem; margin: 0; }

.fade-in { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
.fade-in.visible { opacity: 1; transform: translateY(0); }

@media (max-width: 1024px) {
    .stats-grid { grid-template-columns: repeat(3, 1fr); gap: 2rem; }
    .form-row   { grid-template-columns: 1fr; }
    .tips-grid  { grid-template-columns: repeat(2, 1fr); }
    .shortcuts-grid { grid-template-columns: repeat(2, 1fr); }
    .cta-section { grid-template-columns: 1fr; gap: 3rem; }
    .tasks-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 768px) {
    .navbar { height: 65px; }
    .navbar.scrolled { height: 60px; }
    .page-wrap { padding-top: 65px; }
    .nav-menu { display: none; }
    .hamburger { display: flex; }
    .nav-actions { display: none; }
    .main-content { padding: clamp(80px, 20vw, 120px) 3% clamp(60px, 12vw, 80px); }
    .stats-grid { grid-template-columns: 1fr; gap: 1.5rem; }
    .filters-container { flex-direction: column; align-items: center; }
    .filter-btn { width: 100%; max-width: 400px; justify-content: center; }
    .card-header { flex-direction: column; gap: 12px; align-items: flex-start; }
    .task-actions { order: 3; width: 100%; justify-content: flex-end; }
    .tips-grid { grid-template-columns: 1fr; }
    .shortcuts-grid { grid-template-columns: 1fr; }
    .cta-actions { flex-direction: column; align-items: flex-start; }
    .newsletter-row { flex-direction: column; }
    .newsletter-row input { min-width: auto; }
    .footer-top { grid-template-columns: 1fr; text-align: center; gap: 2.5rem; }
    .footer-col h4::after { left: 50%; transform: translateX(-50%); }
    .social-icons { gap: 0.75rem; }
    .social-link { width: 44px; height: 44px; }
    .organize-chips { gap: 8px; }
    .organize-chip { font-size: 0.8rem; padding: 8px 14px; }
    .footer-col a { justify-content: center; }
    .toast-container { right: 12px; left: 12px; max-width: none; }
    .toast { min-width: auto; }
    .logout-modal-actions { flex-direction: column; }
    .toggle-modal-actions { flex-direction: column; }
    .tasks-grid { grid-template-columns: 1fr; }
}

@media (max-width: 480px) {
    .main-content { padding: 0 2.5%; }
    .nav-container { padding: 0 8px; }
    .task-form-container { padding: 24px; }
    .modal { margin: 20px; padding: 24px; }
}
</style>

<nav class="navbar" id="navbar">
    <div class="nav-container">
        <a href="/dashboard" class="logo">
            <img src="{{ asset('images/OIP.webp') }}" alt="Task Organizo" class="logo-image">
            <span>Task Organizo</span>
        </a>
        <ul class="nav-menu" id="navMenu">
            <li><a href="/landing" class="nav-link">Home</a></li>
            <li><a href="/todos" class="nav-link active">Menu List</a></li>
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
        <li><a href="/landing" class="mobile-nav-link">Home</a></li>
        <li><a href="/todos" class="mobile-nav-link active">Menu List</a></li>
        <li><a href="/contacts" class="mobile-nav-link">Contacts</a></li>
    </ul>
    <div style="width:100%;max-width:300px;margin:auto auto 2rem auto;display:flex;flex-direction:column;align-items:center;gap:12px;">
        <button type="button" class="logout-btn" id="logoutTriggerMobile" style="width:100%;justify-content:center;">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </div>
</div>

<div class="page-wrap">
    <div class="page-content">
        <main class="main-content">

            <div class="hero-section">
                <h1 class="title">
                    <span class="title-white">Your Tasks,</span><br>
                    <span class="title-orange">Your Control.</span>
                </h1>
                <p class="subtitle">Master your productivity with elegant task management. Stay organized, achieve more.</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number" style="color:var(--primary);">{{ $totalCount }}</div>
                    <div class="stat-label"><i class="bi bi-list-check"></i> Total Tasks</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" style="color:var(--primary-dark);">{{ $pendingCount }}</div>
                    <div class="stat-label"><i class="bi bi-hourglass-split"></i> Pending</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" style="color:#10b981;">{{ $completedCount }}</div>
                    <div class="stat-label"><i class="bi bi-check-circle"></i> Completed</div>
                </div>
            </div>

            <div class="task-form-container">
                <h2 class="form-title">
                    <i class="bi bi-plus-circle-dotted"></i> Create New Task
                </h2>
                <form method="POST" action="{{ route('todos.store') }}" class="modern-task-form" id="taskForm">
                    @csrf
                    <div class="input-group">
                        <label><i class="bi bi-pencil"></i> Task Title</label>
                        <input type="text" name="task" class="modern-input" placeholder="Enter your task..." value="{{ old('task') }}" required>
                    </div>
                    <div class="input-group">
                        <label><i class="bi bi-text-paragraph"></i> Description</label>
                        <textarea name="description" class="modern-input modern-textarea" placeholder="Task details...">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-row">
                        <div class="input-group">
                            <label><i class="bi bi-flag"></i> Priority</label>
                            <select name="priority" class="modern-input">
                                <option value="low"    {{ old('priority') == 'low'    ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high"   {{ old('priority') == 'high'   ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label><i class="bi bi-calendar-event"></i> Due Date</label>
                            <input type="date" name="due_date" class="modern-input" value="{{ old('due_date') }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group">
                            <label><i class="bi bi-tag"></i> Category</label>
                            <select name="category" class="modern-input">
                                <option value="work"     {{ old('category') == 'work'     ? 'selected' : '' }}>Work</option>
                                <option value="personal" {{ old('category') == 'personal' ? 'selected' : '' }}>Personal</option>
                                <option value="shopping" {{ old('category') == 'shopping' ? 'selected' : '' }}>Shopping</option>
                                <option value="urgent"   {{ old('category') == 'urgent'   ? 'selected' : '' }}>Urgent</option>
                                <option value="other"    {{ old('category') == 'other'    ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="modern-add-btn" id="addTaskBtn">
                        <i class="bi bi-plus-lg"></i> Create Task
                    </button>
                </form>
            </div>

            <div class="filters-container">
                <a href="{{ route('todos.index') }}" class="filter-btn {{ $filter === 'all' ? 'active' : '' }}">
                    <i class="bi bi-grid-3x3-gap"></i> All <span class="count-badge badge-all">{{ $totalCount }}</span>
                </a>
                <a href="{{ route('todos.index', ['filter' => 'pending']) }}" class="filter-btn {{ $filter === 'pending' ? 'active' : '' }}">
                    <i class="bi bi-hourglass-split"></i> Pending <span class="count-badge badge-pending">{{ $pendingCount }}</span>
                </a>
                <a href="{{ route('todos.index', ['filter' => 'completed']) }}" class="filter-btn {{ $filter === 'completed' ? 'active' : '' }}">
                    <i class="bi bi-check2-all"></i> Completed <span class="count-badge badge-done">{{ $completedCount }}</span>
                </a>
            </div>

            <div class="organize-menu-section">
                <div class="organize-menu-header">
                    <div class="organize-menu-title">
                        <i class="bi bi-sliders"></i>
                        Organize Tasks
                    </div>
                    <button class="organize-reset-btn" id="organizeResetBtn">
                        <i class="bi bi-arrow-counterclockwise"></i> Clear Filters
                    </button>
                </div>
                <div class="organize-divider"></div>
                <div class="organize-groups">
                    <div class="organize-group">
                        <div class="organize-group-label">
                            <i class="bi bi-tag"></i> By Category
                        </div>
                        <div class="organize-chips">
                            <div class="organize-chip" data-type="category" data-value="work"><i class="bi bi-briefcase chip-icon-work"></i> Work</div>
                            <div class="organize-chip" data-type="category" data-value="personal"><i class="bi bi-person chip-icon-personal"></i> Personal</div>
                            <div class="organize-chip" data-type="category" data-value="shopping"><i class="bi bi-cart chip-icon-shopping"></i> Shopping</div>
                            <div class="organize-chip" data-type="category" data-value="urgent"><i class="bi bi-exclamation-triangle chip-icon-urgent"></i> Urgent</div>
                            <div class="organize-chip" data-type="category" data-value="other"><i class="bi bi-pin chip-icon-other"></i> Other</div>
                        </div>
                    </div>
                    <div class="organize-group">
                        <div class="organize-group-label">
                            <i class="bi bi-flag"></i> By Priority
                        </div>
                        <div class="organize-chips">
                            <div class="organize-chip" data-type="priority" data-value="high"><i class="bi bi-arrow-up-circle chip-icon-high"></i> High</div>
                            <div class="organize-chip" data-type="priority" data-value="medium"><i class="bi bi-dash-circle chip-icon-medium"></i> Medium</div>
                            <div class="organize-chip" data-type="priority" data-value="low"><i class="bi bi-arrow-down-circle chip-icon-low"></i> Low</div>
                        </div>
                    </div>
                    <div class="organize-group">
                        <div class="organize-group-label">
                            <i class="bi bi-calendar3"></i> By Due Date
                        </div>
                        <div class="organize-chips">
                            <div class="organize-chip" data-type="due" data-value="today"><i class="bi bi-calendar-check chip-icon-today"></i> Due Today</div>
                            <div class="organize-chip" data-type="due" data-value="week"><i class="bi bi-calendar-week chip-icon-week"></i> This Week</div>
                            <div class="organize-chip" data-type="due" data-value="overdue"><i class="bi bi-calendar-x chip-icon-overdue"></i> Overdue</div>
                            <div class="organize-chip" data-type="due" data-value="no-date"><i class="bi bi-calendar2-minus chip-icon-nodate"></i> No Date</div>
                        </div>
                    </div>
                </div>
                <div class="active-organize-info" id="activeOrganizeInfo">
                    <i class="bi bi-funnel"></i>
                    <span>Showing tasks:</span>
                    <span class="active-organize-tag" id="activeOrganizeTag"></span>
                    <span class="organize-count-pill" id="organizeMatchCount"></span>
                </div>
            </div>

            @if($todos->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon"><i class="bi bi-clipboard2-x"></i></div>
                    <h3 class="empty-title">{{ $filter === 'all' ? 'No tasks yet!' : 'No ' . ucfirst($filter) . ' tasks' }}</h3>
                    <p class="empty-subtitle">{{ $filter === 'all' ? 'Start by adding your first task above to kick things off.' : 'Create some tasks or try a different filter.' }}</p>
                </div>
            @else
                <div class="tasks-grid" id="tasksGrid">
                    @foreach($todos as $todo)
                        @php
                            $categoryIcons = [
                                'work'     => 'bi-briefcase',
                                'personal' => 'bi-person',
                                'shopping' => 'bi-cart',
                                'urgent'   => 'bi-exclamation-triangle',
                                'other'    => 'bi-pin',
                            ];
                            $cat = $todo->category ?? 'other';
                            $catIcon = $categoryIcons[$cat] ?? 'bi-pin';
                        @endphp
                        <div class="task-card"
                             data-priority="{{ $todo->priority }}"
                             data-category="{{ $cat }}"
                             data-due="{{ $todo->due_date ?? '' }}">
                            <div class="card-accent"></div>
                            <div class="card-content">
                                <div class="card-header">
                                    <span class="status-badge badge-{{ $todo->completed ? 'done' : 'pending' }}">
                                        @if($todo->completed)
                                            <i class="bi bi-check-circle"></i> Completed
                                        @else
                                            <i class="bi bi-hourglass-split"></i> Pending
                                        @endif
                                    </span>
                                    <div class="task-actions">
                                        <button type="button" class="info-btn"
                                                data-task="{{ $todo->task }}"
                                                data-description="{{ $todo->description ?? '' }}"
                                                data-date="{{ $todo->created_at->format('M d, Y h:i A') }}"
                                                data-status="{{ $todo->completed ? 'Completed' : 'Pending' }}"
                                                data-priority="{{ $todo->priority }}"
                                                data-due="{{ $todo->due_date }}"
                                                data-category="{{ $cat }}"
                                                title="View details">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                        <button type="button" class="edit-btn"
                                                data-id="{{ $todo->id }}"
                                                data-task="{{ $todo->task }}"
                                                data-description="{{ $todo->description ?? '' }}"
                                                data-priority="{{ $todo->priority }}"
                                                data-due="{{ $todo->due_date }}"
                                                data-category="{{ $cat }}"
                                                title="Edit task">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="delete-btn" data-id="{{ $todo->id }}" title="Delete task">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="task-title {{ $todo->completed ? 'done' : '' }}">{{ $todo->task }}</h3>
                                @if($todo->description)
                                    <p class="task-description">{{ $todo->description }}</p>
                                @endif
                                <div class="task-meta">
                                    <span class="category-pill category-{{ $cat }}">
                                        <i class="bi {{ $catIcon }}"></i>
                                        {{ ucfirst($cat) }}
                                    </span>
                                    @if($todo->priority)
                                        <span class="priority-badge priority-{{ $todo->priority }}">{{ ucfirst($todo->priority) }}</span>
                                    @endif
                                    @if($todo->due_date)
                                        <div class="task-meta-item">
                                            <i class="bi bi-calendar-event"></i>
                                            <span>{{ \Carbon\Carbon::parse($todo->due_date)->format('M d, Y') }}</span>
                                        </div>
                                    @endif
                                </div>
                                <p class="task-date">
                                    <i class="bi bi-clock-history"></i>
                                    Added {{ $todo->created_at->format('M d, Y \a\t h:i A') }}
                                </p>
                                <div class="card-actions">
                                    <button type="button"
                                            class="toggle-btn {{ $todo->completed ? 'is-done' : 'not-done' }} toggle-trigger"
                                            data-id="{{ $todo->id }}"
                                            data-task="{{ $todo->task }}"
                                            data-completed="{{ $todo->completed ? '1' : '0' }}">
                                        @if($todo->completed)
                                            <i class="bi bi-arrow-counterclockwise"></i> Mark Incomplete
                                        @else
                                            <i class="bi bi-check2-circle"></i> Mark Complete
                                        @endif
                                    </button>
                                    <form method="POST"
                                          action="{{ route('todos.toggle', $todo) }}"
                                          class="toggle-form"
                                          id="toggleForm-{{ $todo->id }}"
                                          style="display:none;">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="no-results-state" id="noResultsState">
                    <div class="empty-icon" style="font-size:4rem;color:rgba(255,107,53,0.4);margin-bottom:2rem;">
                        <i class="bi bi-search"></i>
                    </div>
                    <h3 class="empty-title">No matching tasks</h3>
                    <p class="empty-subtitle">Try a different filter or clear your current selection.</p>
                </div>
            @endif

        </main>

        <div class="landing-divider"></div>

        <section id="tips">
            <div class="section-wrap">
                <div class="section-header fade-in">
                    <div class="section-eyebrow">
                        <i class="bi bi-lightbulb"></i>
                        Productivity Tips
                    </div>
                    <h2 class="section-title">Get More Done Every Day</h2>
                    <p class="section-sub">Simple habits that turn your task list into real results — one step at a time.</p>
                </div>
                <div class="tips-grid">
                    <div class="tip-card fade-in">
                        <div class="tip-step"><i class="bi bi-1-circle-fill"></i></div>
                        <h3>Start With Your Top 3</h3>
                        <p>Each morning, pick just three tasks that would make today a win. Focusing on fewer priorities keeps you from feeling overwhelmed and builds real momentum.</p>
                        <div class="tip-number">01</div>
                    </div>
                    <div class="tip-card fade-in" style="transition-delay: 0.1s;">
                        <div class="tip-step"><i class="bi bi-2-circle-fill"></i></div>
                        <h3>Set Deadlines on Everything</h3>
                        <p>Tasks without due dates drift forever. Assigning a deadline — even a soft one — trains your brain to treat the task as real and worth finishing.</p>
                        <div class="tip-number">02</div>
                    </div>
                    <div class="tip-card fade-in" style="transition-delay: 0.2s;">
                        <div class="tip-step"><i class="bi bi-3-circle-fill"></i></div>
                        <h3>Review & Reset Weekly</h3>
                        <p>Spend five minutes every Sunday reviewing what's done, what's overdue, and what carries over. A quick reset keeps your list clean and your head clear.</p>
                        <div class="tip-number">03</div>
                    </div>
                </div>
            </div>
        </section>

        <section id="shortcuts" class="shortcuts-section">
            <div class="section-wrap">
                <div class="section-header fade-in">
                    <div class="section-eyebrow">
                        <i class="bi bi-grid-1x2"></i>
                        Quick Actions
                    </div>
                    <h2 class="section-title">Jump Right In</h2>
                    <p class="section-sub">Everything you need to manage your tasks is one tap away.</p>
                </div>
                <div class="shortcuts-inner fade-in">
                    <div class="shortcuts-grid">
                        <a href="{{ route('todos.index') }}" class="shortcut-card">
                            <div class="shortcut-icon"><i class="bi bi-grid-3x3-gap"></i></div>
                            <div class="shortcut-text">
                                <div class="shortcut-label">View</div>
                                <div class="shortcut-title">All Tasks</div>
                            </div>
                        </a>
                        <a href="{{ route('todos.index', ['filter' => 'pending']) }}" class="shortcut-card">
                            <div class="shortcut-icon"><i class="bi bi-hourglass-split"></i></div>
                            <div class="shortcut-text">
                                <div class="shortcut-label">Filter</div>
                                <div class="shortcut-title">Pending Tasks</div>
                            </div>
                        </a>
                        <a href="{{ route('todos.index', ['filter' => 'completed']) }}" class="shortcut-card">
                            <div class="shortcut-icon"><i class="bi bi-check2-all"></i></div>
                            <div class="shortcut-text">
                                <div class="shortcut-label">Filter</div>
                                <div class="shortcut-title">Completed Tasks</div>
                            </div>
                        </a>
                        <div class="shortcut-card" onclick="document.querySelector('input[name=task]').focus()">
                            <div class="shortcut-icon"><i class="bi bi-plus-circle"></i></div>
                            <div class="shortcut-text">
                                <div class="shortcut-label">Create</div>
                                <div class="shortcut-title">New Task</div>
                            </div>
                        </div>
                        <div class="shortcut-card" onclick="document.getElementById('organizeResetBtn').click()">
                            <div class="shortcut-icon"><i class="bi bi-arrow-counterclockwise"></i></div>
                            <div class="shortcut-text">
                                <div class="shortcut-label">Reset</div>
                                <div class="shortcut-title">Clear All Filters</div>
                            </div>
                        </div>
                        <a href="/contacts" class="shortcut-card">
                            <div class="shortcut-icon"><i class="bi bi-headset"></i></div>
                            <div class="shortcut-text">
                                <div class="shortcut-label">Need Help?</div>
                                <div class="shortcut-title">Contact Support</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="cta">
            <div class="section-wrap">
                <div class="cta-section">
                    <div class="cta-content fade-in">
                        <div class="section-eyebrow" style="align-self: flex-start;">
                            <i class="bi bi-rocket-takeoff"></i>
                            Stay on Track
                        </div>
                        <h2>
                            <span class="white">Stop Forgetting.</span><br>
                            <span class="orange">Start Finishing.</span>
                        </h2>
                        <p class="cta-bio">
                            Every task you log is a commitment to yourself. Use priorities to focus on what moves the needle, set due dates so nothing slips through, and watch your completed count grow — one tick at a time.
                        </p>
                        <div class="cta-badges">
                            <span class="cta-badge"><i class="bi bi-check2-circle"></i> Free Forever</span>
                            <span class="cta-badge"><i class="bi bi-lock"></i> Your Data Only</span>
                            <span class="cta-badge"><i class="bi bi-lightning-charge"></i> Instant Updates</span>
                        </div>
                        <div class="cta-actions">
                            <button class="btn-primary" onclick="document.querySelector('input[name=task]').focus()">
                                <i class="bi bi-plus-circle"></i> Add a Task Now
                            </button>
                            <a href="/contacts" class="btn-ghost">
                                <i class="bi bi-chat-dots"></i> Get Help
                            </a>
                        </div>
                    </div>
                    <div class="cta-visual fade-in" style="transition-delay: 0.15s;">
                        <div class="cta-visual-title"><i class="bi bi-list-check"></i> Your Task Board</div>
                        <div id="ctaTaskBoard">
                            @php
                                $boardTasks = $todos->take(4);
                            @endphp
                            @if($boardTasks->isEmpty())
                                <div class="cta-visual-empty">
                                    <i class="bi bi-clipboard2-plus"></i>
                                    No tasks yet — add your first one above!
                                </div>
                            @else
                                @foreach($boardTasks as $bt)
                                    @php
                                        $btPriority = $bt->priority ?? 'low';
                                        $btCat = $bt->category ?? 'other';
                                        $btDue = $bt->due_date
                                            ? \Carbon\Carbon::parse($bt->due_date)->diffForHumans()
                                            : 'No due date';
                                    @endphp
                                    <div class="mock-task" id="boardTask-{{ $bt->id }}">
                                        <div class="mock-check {{ $bt->completed ? 'done' : 'undone' }}">
                                            @if($bt->completed)<i class="bi bi-check"></i>@endif
                                        </div>
                                        <div class="mock-task-text">
                                            <div class="mock-task-title {{ $bt->completed ? 'done' : '' }}">{{ $bt->task }}</div>
                                            <div class="mock-task-meta">{{ ucfirst($btCat) }} · {{ $btDue }}</div>
                                        </div>
                                        <div class="mock-priority {{ $btPriority }}">{{ ucfirst(substr($btPriority, 0, 3)) }}</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

<div class="toast-container" id="toastContainer"></div>

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

<div class="modal-overlay" id="editModal">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Task</h2>
            <button type="button" class="modal-close" id="editClose"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body">
            <form method="POST" id="editForm">
                @csrf
                @method('PATCH')
                <div class="input-group">
                    <label><i class="bi bi-pencil"></i> Task Title</label>
                    <input type="text" name="task" id="editTaskField" class="edit-input" required>
                </div>
                <div class="input-group">
                    <label><i class="bi bi-text-paragraph"></i> Description</label>
                    <textarea name="description" id="editDescriptionField" class="edit-input modern-textarea"></textarea>
                </div>
                <div class="form-row">
                    <div class="input-group">
                        <label><i class="bi bi-flag"></i> Priority</label>
                        <select name="priority" id="editPriorityField" class="edit-input">
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label><i class="bi bi-calendar-event"></i> Due Date</label>
                        <input type="date" name="due_date" id="editDueField" class="edit-input">
                    </div>
                </div>
                <div class="input-group">
                    <label><i class="bi bi-tag"></i> Category</label>
                    <select name="category" id="editCategoryField" class="edit-input">
                        <option value="work">Work</option>
                        <option value="personal">Personal</option>
                        <option value="shopping">Shopping</option>
                        <option value="urgent">Urgent</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-actions">
            <button type="button" class="modal-btn modal-btn-secondary" id="editCancel"><i class="bi bi-x-circle"></i> Cancel</button>
            <button type="button" class="modal-btn modal-btn-primary" id="editSave"><i class="bi bi-check-circle"></i> Update Task</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="infoModal">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title"><i class="bi bi-info-circle"></i> Task Details</h2>
            <button type="button" class="modal-close" id="infoClose"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body">
            <div class="modal-info-row">
                <div class="modal-info-icon"><i class="bi bi-pencil"></i></div>
                <div><div class="modal-info-label">Task</div><div class="modal-info-value" id="infoTask"></div></div>
            </div>
            <div class="modal-info-row">
                <div class="modal-info-icon"><i class="bi bi-text-paragraph"></i></div>
                <div><div class="modal-info-label">Description</div><div class="modal-info-value" id="infoDescription"></div></div>
            </div>
            <div class="modal-info-row">
                <div class="modal-info-icon"><i class="bi bi-activity"></i></div>
                <div><div class="modal-info-label">Status</div><div class="modal-info-value" id="infoStatus"></div></div>
            </div>
            <div class="modal-info-row">
                <div class="modal-info-icon"><i class="bi bi-flag"></i></div>
                <div><div class="modal-info-label">Priority</div><div class="modal-info-value" id="infoPriority"></div></div>
            </div>
            <div class="modal-info-row">
                <div class="modal-info-icon"><i class="bi bi-tag"></i></div>
                <div><div class="modal-info-label">Category</div><div class="modal-info-value" id="infoCategory"></div></div>
            </div>
            <div class="modal-info-row">
                <div class="modal-info-icon"><i class="bi bi-calendar-event"></i></div>
                <div><div class="modal-info-label">Due Date</div><div class="modal-info-value" id="infoDue"></div></div>
            </div>
            <div class="modal-info-row">
                <div class="modal-info-icon"><i class="bi bi-clock-history"></i></div>
                <div><div class="modal-info-label">Created</div><div class="modal-info-value" id="infoDate"></div></div>
            </div>
        </div>
        <div class="modal-actions">
            <button type="button" class="modal-btn modal-btn-primary" id="infoOk"><i class="bi bi-check2"></i> Close</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title"><i class="bi bi-trash3"></i> Delete Task</h2>
            <button type="button" class="modal-close" id="deleteClose"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body">
            <div style="display:flex;align-items:center;gap:16px;padding:20px;background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);border-radius:16px;">
                <i class="bi bi-exclamation-triangle-fill" style="font-size:2rem;color:#ef4444;flex-shrink:0;"></i>
                <p style="color:rgba(255,255,255,0.9);line-height:1.6;margin:0;">Are you sure you want to delete this task? This action cannot be undone.</p>
            </div>
        </div>
        <div class="modal-actions">
            <button type="button" class="modal-btn modal-btn-secondary" id="deleteCancel"><i class="bi bi-x-circle"></i> Cancel</button>
            <form method="POST" id="deleteForm" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="modal-btn modal-btn-primary" style="background:linear-gradient(135deg,#ef4444,#dc2626);box-shadow:0 12px 35px rgba(239,68,68,0.4);">
                    <i class="bi bi-trash3"></i> Delete Task
                </button>
            </form>
        </div>
    </div>
</div>

<div class="modal-overlay" id="toggleModal">
    <div class="modal" style="max-width:480px;text-align:center;">
        <div class="toggle-modal-icon completing" id="toggleModalIcon">
            <i class="bi bi-check2-circle" id="toggleModalIconInner"></i>
        </div>
        <div class="toggle-modal-title" id="toggleModalTitle">Mark as Complete?</div>
        <div class="toggle-modal-task-preview" id="toggleModalTaskPreview"></div>
        <div class="toggle-modal-sub" id="toggleModalSub">
            This will mark the task as completed and move it to your done list.
        </div>
        <div class="toggle-modal-actions">
            <button type="button" class="toggle-modal-cancel" id="toggleModalCancel">
                <i class="bi bi-x-circle"></i> Cancel
            </button>
            <button type="button" class="toggle-modal-confirm completing" id="toggleModalConfirm">
                <i class="bi bi-check2-circle" id="toggleModalConfirmIcon"></i>
                <span id="toggleModalConfirmText">Yes, Complete It</span>
            </button>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="footer-content">
        <div class="footer-top">
            <div class="footer-col">
                <h4>To-Do List</h4>
                <a href="{{ route('todos.index') }}"><i class="bi bi-eye"></i> View Tasks</a>
                <a href="#" onclick="window.scrollTo({top:0,behavior:'smooth'});setTimeout(()=>document.querySelector('input[name=task]').focus(),600);return false;"><i class="bi bi-plus-circle"></i> Add New Task</a>
                <a href="{{ route('todos.index', ['filter' => 'completed']) }}"><i class="bi bi-check2-all"></i> Completed Tasks</a>
                <a href="{{ route('todos.index', ['filter' => 'pending']) }}"><i class="bi bi-hourglass-split"></i> Pending Tasks</a>
            </div>
            <div class="footer-col">
                <h4>Categories</h4>
                <a href="{{ route('todos.index') }}" onclick="sessionStorage.setItem('autoFilter','work')"><i class="bi bi-briefcase"></i> Work</a>
                <a href="{{ route('todos.index') }}" onclick="sessionStorage.setItem('autoFilter','personal')"><i class="bi bi-person"></i> Personal</a>
                <a href="{{ route('todos.index') }}" onclick="sessionStorage.setItem('autoFilter','shopping')"><i class="bi bi-cart"></i> Shopping</a>
                <a href="{{ route('todos.index') }}" onclick="sessionStorage.setItem('autoFilter','urgent')"><i class="bi bi-exclamation-triangle"></i> Urgent</a>
            </div>
            <div class="footer-col">
                <h4>Support</h4>
                <a href="/contacts"><i class="bi bi-question-circle"></i> Help</a>
                <a href="/contacts"><i class="bi bi-chat-left-text"></i> FAQ</a>
                <a href="/contacts"><i class="bi bi-headset"></i> Contact Support</a>
                <a href="/contacts"><i class="bi bi-star"></i> Feedback</a>
            </div>
            <div class="footer-col">
                <h4>Stay Updated</h4>
                <p>Get updates on your tasks and reminders.</p>
                <div class="newsletter-wrapper">
                    <div class="newsletter-row">
                        <input type="email" id="newsletterEmail" placeholder="Enter your email">
                        <button type="button" onclick="handleNewsletter()"><i class="bi bi-send"></i> Subscribe</button>
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
    const hamburger   = document.getElementById('hamburger');
    const mobileMenu  = document.getElementById('mobileMenu');
    const navbar      = document.getElementById('navbar');
    const taskForm    = document.getElementById('taskForm');
    const addTaskBtn  = document.getElementById('addTaskBtn');
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
            document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('show'));
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

    if (taskForm) {
        taskForm.addEventListener('submit', function (e) {
            const taskInput = taskForm.querySelector('input[name="task"]');
            if (taskInput.value.trim().length < 3) {
                e.preventDefault();
                showToast('Task must be at least 3 characters long!', 'error');
                return false;
            }
            addTaskBtn.disabled = true;
            addTaskBtn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Adding...';
            showToast('Creating your task...', 'info');
        });
    }

    document.querySelectorAll('.modern-input').forEach(input => {
        input.addEventListener('input', function () { this.classList.remove('error'); });
    });

    document.addEventListener('click', function (e) {
        const editBtn   = e.target.closest('.edit-btn');
        const infoBtn   = e.target.closest('.info-btn');
        const deleteBtn = e.target.closest('.delete-btn');
        if (editBtn) {
            openEditModal(editBtn.dataset.id, editBtn.dataset.task, editBtn.dataset.description, editBtn.dataset.priority, editBtn.dataset.due, editBtn.dataset.category);
        } else if (infoBtn) {
            openInfoModal(infoBtn.dataset.task, infoBtn.dataset.description, infoBtn.dataset.date, infoBtn.dataset.status, infoBtn.dataset.priority, infoBtn.dataset.due, infoBtn.dataset.category);
        } else if (deleteBtn) {
            openDeleteModal(deleteBtn.dataset.id);
        }
    });

    document.getElementById('editClose').addEventListener('click', closeEditModal);
    document.getElementById('editCancel').addEventListener('click', closeEditModal);
    document.getElementById('editSave').addEventListener('click', saveEdit);
    document.getElementById('infoClose').addEventListener('click', closeInfoModal);
    document.getElementById('infoOk').addEventListener('click', closeInfoModal);
    document.getElementById('deleteClose').addEventListener('click', closeDeleteModal);
    document.getElementById('deleteCancel').addEventListener('click', closeDeleteModal);

    document.getElementById('deleteForm').addEventListener('submit', () => {
        showToast('Deleting task...', 'warning');
    });

    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) modal.classList.remove('show');
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

    @if (session('success'))
        showToast(@json(session('success')), 'success');
    @endif

    @if ($errors->any())
        showToast(@json($errors->first()), 'error');
    @endif

    const activeFilters = { category: null, priority: null, due: null };

    const autoFilter = sessionStorage.getItem('autoFilter');
    if (autoFilter) {
        sessionStorage.removeItem('autoFilter');
        const chip = document.querySelector(`.organize-chip[data-type="category"][data-value="${autoFilter}"]`);
        if (chip) {
            activeFilters.category = autoFilter;
            chip.classList.add('active');
            applyOrganizeFilters();
            chip.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    function getCardDueStatus(dueDateStr) {
        if (!dueDateStr) return 'no-date';
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const due = new Date(dueDateStr);
        due.setHours(0, 0, 0, 0);
        const weekEnd = new Date(today);
        weekEnd.setDate(today.getDate() + 7);
        if (due < today) return 'overdue';
        if (due.getTime() === today.getTime()) return 'today';
        if (due <= weekEnd) return 'week';
        return 'future';
    }

    function applyOrganizeFilters() {
        const cards = document.querySelectorAll('.task-card');
        let visibleCount = 0;
        const hasFilter = activeFilters.category || activeFilters.priority || activeFilters.due;

        cards.forEach(card => {
            let show = true;
            if (activeFilters.category && card.dataset.category !== activeFilters.category) show = false;
            if (activeFilters.priority && card.dataset.priority !== activeFilters.priority) show = false;
            if (activeFilters.due && getCardDueStatus(card.dataset.due) !== activeFilters.due) show = false;
            card.classList.toggle('hidden-by-filter', !show);
            if (show) visibleCount++;
        });

        const noResults = document.getElementById('noResultsState');
        if (noResults) noResults.classList.toggle('visible', hasFilter && visibleCount === 0);

        const infoBar = document.getElementById('activeOrganizeInfo');
        const tag     = document.getElementById('activeOrganizeTag');
        const count   = document.getElementById('organizeMatchCount');

        if (hasFilter) {
            const labels = [];
            if (activeFilters.category) labels.push(activeFilters.category);
            if (activeFilters.priority) labels.push(activeFilters.priority + ' priority');
            if (activeFilters.due)      labels.push(activeFilters.due);
            tag.textContent   = labels.join(' · ');
            count.textContent = visibleCount + ' task' + (visibleCount !== 1 ? 's' : '');
            infoBar.classList.add('visible');
        } else {
            infoBar.classList.remove('visible');
        }
    }

    document.querySelectorAll('.organize-chip').forEach(chip => {
        chip.addEventListener('click', function () {
            const type  = this.dataset.type;
            const value = this.dataset.value;
            if (activeFilters[type] === value) {
                activeFilters[type] = null;
                this.classList.remove('active');
            } else {
                document.querySelectorAll(`.organize-chip[data-type="${type}"]`).forEach(c => c.classList.remove('active'));
                activeFilters[type] = value;
                this.classList.add('active');
            }
            applyOrganizeFilters();
        });
    });

    document.getElementById('organizeResetBtn').addEventListener('click', function () {
        activeFilters.category = null;
        activeFilters.priority = null;
        activeFilters.due      = null;
        document.querySelectorAll('.organize-chip').forEach(c => c.classList.remove('active'));
        applyOrganizeFilters();
        showToast('Filters cleared', 'info');
    });

    let pendingToggleId   = null;
    let pendingCompleted  = false;

    document.addEventListener('click', function (e) {
        const toggleBtn = e.target.closest('.toggle-trigger');
        if (!toggleBtn) return;

        pendingToggleId  = toggleBtn.dataset.id;
        pendingCompleted = toggleBtn.dataset.completed === '1';

        const taskName    = toggleBtn.dataset.task;
        const isCompleting = !pendingCompleted;

        const modalIcon        = document.getElementById('toggleModalIcon');
        const modalIconInner   = document.getElementById('toggleModalIconInner');
        const modalTitle       = document.getElementById('toggleModalTitle');
        const modalPreview     = document.getElementById('toggleModalTaskPreview');
        const modalSub         = document.getElementById('toggleModalSub');
        const modalConfirm     = document.getElementById('toggleModalConfirm');
        const modalConfirmIcon = document.getElementById('toggleModalConfirmIcon');
        const modalConfirmText = document.getElementById('toggleModalConfirmText');

        if (isCompleting) {
            modalIcon.className       = 'toggle-modal-icon completing';
            modalIconInner.className  = 'bi bi-check2-circle';
            modalTitle.textContent    = 'Mark as Complete?';
            modalSub.textContent      = 'This will mark the task as completed and move it to your done list.';
            modalConfirm.className    = 'toggle-modal-confirm completing';
            modalConfirmIcon.className = 'bi bi-check2-circle';
            modalConfirmText.textContent = 'Yes, Complete It';
        } else {
            modalIcon.className       = 'toggle-modal-icon undoing';
            modalIconInner.className  = 'bi bi-arrow-counterclockwise';
            modalTitle.textContent    = 'Mark as Incomplete?';
            modalSub.textContent      = 'This will move the task back to your pending list.';
            modalConfirm.className    = 'toggle-modal-confirm undoing';
            modalConfirmIcon.className = 'bi bi-arrow-counterclockwise';
            modalConfirmText.textContent = 'Yes, Mark Incomplete';
        }

        modalPreview.textContent = '"' + taskName + '"';
        document.getElementById('toggleModal').classList.add('show');
    });

    document.getElementById('toggleModalCancel').addEventListener('click', () => {
        document.getElementById('toggleModal').classList.remove('show');
        pendingToggleId  = null;
        pendingCompleted = false;
        showToast('No changes made.', 'info');
    });

    document.getElementById('toggleModalConfirm').addEventListener('click', () => {
        if (!pendingToggleId) return;
        document.getElementById('toggleModal').classList.remove('show');

        const isCompleting = !pendingCompleted;
        showToast(isCompleting ? 'Marking task as complete...' : 'Marking task as incomplete...', 'info');

        const boardItem = document.getElementById('boardTask-' + pendingToggleId);
        if (boardItem) {
            const checkEl  = boardItem.querySelector('.mock-check');
            const titleEl  = boardItem.querySelector('.mock-task-title');
            if (isCompleting) {
                checkEl.className   = 'mock-check done';
                checkEl.innerHTML   = '<i class="bi bi-check"></i>';
                titleEl.classList.add('done');
            } else {
                checkEl.className   = 'mock-check undone';
                checkEl.innerHTML   = '';
                titleEl.classList.remove('done');
            }
        }

        document.getElementById('toggleForm-' + pendingToggleId).submit();
    });
});

function handleNewsletter() {
    const input = document.getElementById('newsletterEmail');
    const email = input.value.trim();
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        showToast('Please enter a valid email address.', 'error');
        return;
    }
    showToast('Thanks for subscribing!', 'success');
    input.value = '';
}

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

function openEditModal(id, task, description, priority, due_date, category) {
    document.getElementById('editTaskField').value        = task        || '';
    document.getElementById('editDescriptionField').value = description || '';
    document.getElementById('editPriorityField').value    = priority    || 'low';
    document.getElementById('editDueField').value         = due_date    || '';
    document.getElementById('editCategoryField').value    = category    || 'other';
    document.getElementById('editForm').action            = '/todos/' + id;
    document.getElementById('editModal').classList.add('show');
}

function closeEditModal() { document.getElementById('editModal').classList.remove('show'); }

function saveEdit() {
    const taskField = document.getElementById('editTaskField');
    if (taskField.value.trim().length < 3) { showToast('Task must be at least 3 characters long!', 'error'); return; }
    document.getElementById('editForm').submit();
}

function openInfoModal(task, description, date, status, priority, due_date, category) {
    document.getElementById('infoTask').textContent        = task        || 'N/A';
    document.getElementById('infoDescription').textContent = description || 'No description';
    document.getElementById('infoDate').textContent        = date        || 'N/A';
    document.getElementById('infoStatus').textContent      = status      || 'N/A';
    document.getElementById('infoPriority').textContent    = priority    ? ucfirst(priority) : 'N/A';
    document.getElementById('infoCategory').textContent    = category    ? ucfirst(category) : 'N/A';
    document.getElementById('infoDue').textContent         = due_date    ? new Date(due_date).toLocaleDateString() : 'N/A';
    document.getElementById('infoModal').classList.add('show');
}

function closeInfoModal() { document.getElementById('infoModal').classList.remove('show'); }

function openDeleteModal(id) {
    document.getElementById('deleteForm').action = '/todos/' + id;
    document.getElementById('deleteModal').classList.add('show');
}

function closeDeleteModal() { document.getElementById('deleteModal').classList.remove('show'); }

function ucfirst(str) { return str.charAt(0).toUpperCase() + str.slice(1); }
</script>

@endsection