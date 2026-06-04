@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
:root {
    --primary: #ff6b35;
    --primary-dark: #f7931e;
    --primary-light: #ffd23f;
    --bg-dark: rgba(15, 15, 25, 0.85);
    --card-bg: rgba(20, 20, 30, 0.95);
    --border: rgba(255, 107, 53, 0.15);
    --sidebar-width: 260px;
    --sidebar-collapsed: 72px;
}

* { margin: 0; padding: 0; box-sizing: border-box; }
*,*::before,*::after {
    transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease,
        transform 0.3s ease, opacity 0.3s ease, box-shadow 0.3s ease;
}
html, body { overflow-x: hidden; scroll-behavior: smooth; font-family: system-ui, -apple-system, sans-serif; }
body {
    min-height: 100vh; color: #fff;
    background: linear-gradient(var(--bg-dark), var(--bg-dark)),
        url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=2070&q=80');
    background-size: cover; background-position: center; background-attachment: fixed;
    line-height: 1.6; display: flex;
}

/* ── SIDEBAR ── */
.sidebar {
    position: fixed; top: 0; left: 0; height: 100vh; width: var(--sidebar-width);
    background: rgba(10, 14, 26, 0.97); backdrop-filter: blur(24px);
    border-right: 1px solid rgba(255, 107, 53, 0.2); z-index: 1000;
    display: flex; flex-direction: column;
    transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1), transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}
.sidebar.collapsed { width: var(--sidebar-collapsed); }
.sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); z-index: 999; }
.sidebar-overlay.active { display: block; }
.sidebar-header { display: flex; align-items: center; gap: 12px; padding: 20px 16px; border-bottom: 1px solid rgba(255,107,53,0.12); min-height: 72px; flex-shrink: 0; }
.sidebar-logo-img { width: 40px; height: 40px; border-radius: 12px; object-fit: cover; flex-shrink: 0; box-shadow: 0 6px 20px rgba(0,0,0,0.4); }
.sidebar-logo-text { font-size: 1.15rem; font-weight: 900; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; white-space: nowrap; letter-spacing: -0.02em; opacity: 1; transition: opacity 0.2s ease; }
.sidebar.collapsed .sidebar-logo-text { opacity: 0; pointer-events: none; }
.sidebar-toggle { margin-left: auto; background: none; border: none; color: rgba(255,255,255,0.6); cursor: pointer; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
.sidebar-toggle:hover { background: rgba(255,107,53,0.15); color: var(--primary); }
.sidebar.collapsed .sidebar-toggle { margin-left: 0; }
.sidebar-nav { flex: 1; padding: 16px 10px; display: flex; flex-direction: column; gap: 4px; overflow-y: auto; overflow-x: hidden; }
.sidebar-nav::-webkit-scrollbar { width: 4px; }
.sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,107,53,0.3); border-radius: 2px; }
.nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 14px; border-radius: 14px; color: rgba(255,255,255,0.7); text-decoration: none; font-weight: 600; font-size: 0.9rem; white-space: nowrap; position: relative; overflow: hidden; }
.nav-item::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(255,107,53,0.12), rgba(247,147,30,0.06)); opacity: 0; transition: opacity 0.25s ease; border-radius: 14px; }
.nav-item:hover::before { opacity: 1; }
.nav-item:hover { color: #fff; }
.nav-item.active { background: linear-gradient(135deg, rgba(255,107,53,0.22), rgba(247,147,30,0.12)); color: #fff; border: 1px solid rgba(255,107,53,0.25); box-shadow: 0 4px 16px rgba(255,107,53,0.15); }
.nav-item.active .nav-icon { color: var(--primary); }
.nav-icon { font-size: 1.2rem; flex-shrink: 0; width: 22px; text-align: center; }
.nav-label { opacity: 1; transition: opacity 0.2s ease; flex: 1; }
.sidebar.collapsed .nav-label { opacity: 0; pointer-events: none; width: 0; overflow: hidden; }
.sidebar.collapsed .nav-item { justify-content: center; padding: 12px; }
.sidebar-footer { padding: 16px 10px; border-top: 1px solid rgba(255,107,53,0.12); flex-shrink: 0; }
.logout-link { display: flex; align-items: center; gap: 12px; padding: 12px 14px; border-radius: 14px; color: rgba(255,255,255,0.7); font-weight: 600; font-size: 0.9rem; white-space: nowrap; background: none; border: none; width: 100%; cursor: pointer; text-align: left; }
.logout-link:hover { background: rgba(239,68,68,0.12); color: #ef4444; }
.sidebar.collapsed .logout-link { justify-content: center; padding: 12px; }
.sidebar.collapsed .logout-label { opacity: 0; pointer-events: none; width: 0; overflow: hidden; }
.logout-label { opacity: 1; transition: opacity 0.2s ease; }

/* ── MOBILE TOPBAR ── */
.mobile-topbar { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 60px; background: rgba(10,14,26,0.97); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,107,53,0.2); z-index: 1001; align-items: center; padding: 0 16px; gap: 12px; }
.mobile-hamburger { background: none; border: none; color: #fff; font-size: 1.4rem; cursor: pointer; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.mobile-hamburger:hover { background: rgba(255,107,53,0.15); }
.mobile-logo { font-size: 1.1rem; font-weight: 900; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

/* ── PAGE WRAPPER ── */
.page-wrapper { margin-left: var(--sidebar-width); min-height: 100vh; width: calc(100% - var(--sidebar-width)); transition: margin-left 0.35s cubic-bezier(0.4,0,0.2,1), width 0.35s cubic-bezier(0.4,0,0.2,1); padding: 40px clamp(20px,4vw,40px) 40px; }
body.sidebar-collapsed .page-wrapper { margin-left: var(--sidebar-collapsed); width: calc(100% - var(--sidebar-collapsed)); }
.container { max-width: 1000px; margin: 0 auto; position: relative; z-index: 2; }

/* ── PROFILE HEADER ── */
.profile-header { display: flex; align-items: center; gap: clamp(20px,4vw,40px); margin-bottom: 2rem; padding: clamp(24px,4vw,40px); border-radius: 28px; background: linear-gradient(145deg,rgba(255,255,255,0.08),rgba(255,255,255,0.03)); backdrop-filter: blur(25px); border: 1px solid rgba(255,255,255,0.08); box-shadow: 0 10px 40px rgba(0,0,0,0.25),inset 0 1px 0 rgba(255,255,255,0.08); position: relative; overflow: hidden; flex-wrap: wrap; }
.profile-header::before { content: ''; position: absolute; inset: 0; background: radial-gradient(circle at top right,rgba(255,107,53,0.18),transparent 50%); pointer-events: none; }
.profile-header::after { content: ''; position: absolute; top: 0; left: 24px; width: 70px; height: 4px; border-radius: 999px; background: linear-gradient(90deg,var(--primary),var(--primary-dark),var(--primary-light)); }
.avatar-section { display: flex; flex-direction: column; align-items: center; gap: 14px; flex-shrink: 0; }
.avatar-wrapper { position: relative; width: 120px; height: 120px; cursor: pointer; }
.avatar-img { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid rgba(255,107,53,0.5); box-shadow: 0 0 0 6px rgba(255,107,53,0.1),0 15px 40px rgba(0,0,0,0.4); display: block; }
.avatar-upload-overlay { position: absolute; inset: 0; border-radius: 50%; background: rgba(0,0,0,0.55); display: flex; align-items: center; justify-content: center; opacity: 0; cursor: pointer; transition: opacity 0.3s ease; }
.avatar-wrapper:hover .avatar-upload-overlay { opacity: 1; }
.avatar-upload-overlay i { font-size: 1.6rem; color: #fff; }
.avatar-actions { display: flex; gap: 8px; flex-wrap: wrap; justify-content: center; }
.avatar-btn { background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); color: rgba(255,255,255,0.85); padding: 7px 14px; border-radius: 10px; font-size: 0.78rem; font-weight: 600; cursor: pointer; white-space: nowrap; }
.avatar-btn:hover { background: rgba(255,107,53,0.15); border-color: rgba(255,107,53,0.3); color: #fff; }
.avatar-btn.reset-btn:hover { background: rgba(239,68,68,0.15); border-color: rgba(239,68,68,0.3); }
.file-name-display { font-size: 0.74rem; color: rgba(255,255,255,0.4); text-align: center; margin-top: 4px; max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.profile-info { flex: 1; min-width: 0; }
.profile-name { font-size: clamp(1.6rem,4vw,2.2rem); font-weight: 900; background: linear-gradient(135deg,#fff,#ffb088,var(--primary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; letter-spacing: -0.5px; line-height: 1.1; margin-bottom: 6px; }
.profile-email { font-size: 0.95rem; color: rgba(255,255,255,0.6); margin-bottom: 12px; }
.profile-meta { display: flex; gap: 16px; flex-wrap: wrap; }
.meta-chip { display: flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 20px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); font-size: 0.8rem; color: rgba(255,255,255,0.7); font-weight: 600; }
.meta-chip i { color: var(--primary); font-size: 0.85rem; }

/* ── CARDS ── */
.card { background: var(--card-bg); backdrop-filter: blur(25px); border: 1px solid var(--border); border-radius: 28px; padding: clamp(24px,4vw,40px); margin-bottom: 1.5rem; position: relative; overflow: hidden; }
.card::before { content: ''; position: absolute; inset: 0; background: radial-gradient(circle at top right,rgba(255,107,53,0.1),transparent 50%); pointer-events: none; }
.card::after { content: ''; position: absolute; top: 0; left: 24px; width: 60px; height: 3px; border-radius: 999px; background: linear-gradient(90deg,var(--primary),var(--primary-dark),var(--primary-light)); }
.card-title { font-size: clamp(1.2rem,3vw,1.5rem); font-weight: 800; background: linear-gradient(135deg,var(--primary),var(--primary-dark),var(--primary-light)); -webkit-background-clip: text; background-clip: text; color: transparent; margin-bottom: clamp(20px,3vw,30px); display: flex; align-items: center; gap: 10px; }

/* ── FORM ── */
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: clamp(14px,2vw,22px); }
.form-grid .full { grid-column: 1 / -1; }
.form-group { display: flex; flex-direction: column; gap: 8px; }
.form-label { font-weight: 700; color: rgba(255,255,255,0.95); font-size: 0.88rem; letter-spacing: 0.3px; }
.form-input, .form-textarea { width: 100%; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 13px 18px; font-size: 0.93rem; color: #fff; outline: none; transition: all 0.3s cubic-bezier(0.4,0,0.2,1); font-family: inherit; }
.form-input::placeholder, .form-textarea::placeholder { color: rgba(255,255,255,0.35); }
.form-input:hover, .form-textarea:hover { background: rgba(255,255,255,0.09); }
.form-input:focus, .form-textarea:focus { border-color: rgba(255,107,53,0.5); box-shadow: 0 0 0 4px rgba(255,107,53,0.1); background: rgba(255,255,255,0.1); transform: translateY(-1px); }
.form-input.input-error { border-color: #ef4444; background: rgba(239,68,68,0.06); }
.form-textarea { resize: vertical; min-height: 100px; }
.password-wrapper { position: relative; }
.password-wrapper .form-input { padding-right: 50px; }
.toggle-password { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; color: rgba(255,255,255,0.5); cursor: pointer; font-size: 1rem; padding: 4px; border-radius: 6px; line-height: 1; }
.toggle-password:hover { color: rgba(255,255,255,0.9); }
.form-hint { font-size: 0.78rem; color: rgba(255,255,255,0.4); margin-top: 2px; }
.field-error { font-size: 0.78rem; color: #ef4444; margin-top: 2px; display: none; align-items: center; gap: 4px; }
.field-error.show { display: flex; }
.section-divider { grid-column: 1 / -1; border: none; border-top: 1px solid rgba(255,255,255,0.07); margin: 6px 0; }
.section-label { grid-column: 1 / -1; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.4); display: flex; align-items: center; gap: 8px; }
.section-label::after { content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.07); }
.form-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: clamp(20px,3vw,30px); flex-wrap: wrap; }
.btn { padding: 13px clamp(20px,4vw,32px); border-radius: 16px; font-weight: 800; cursor: pointer; border: none; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px; position: relative; overflow: hidden; transition: all 0.4s cubic-bezier(0.4,0,0.2,1); white-space: nowrap; }
.btn::before { content: ''; position: absolute; top: 0; left: -120%; width: 100%; height: 100%; background: linear-gradient(90deg,transparent,rgba(255,255,255,0.18),transparent); transition: left 0.6s ease; }
.btn:hover::before { left: 120%; }
.btn-primary { background: linear-gradient(135deg,var(--primary),var(--primary-dark)); color: #fff; box-shadow: 0 10px 30px rgba(255,107,53,0.35); }
.btn-primary:hover { transform: translateY(-3px); box-shadow: 0 18px 40px rgba(255,107,53,0.5); }
.btn-primary:disabled { opacity: 0.6; pointer-events: none; }
.btn-secondary { background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.85); border: 1px solid rgba(255,255,255,0.12); }
.btn-secondary:hover { background: rgba(255,255,255,0.14); transform: translateY(-2px); }

/* ── MODAL ── */
.modal-backdrop { position: fixed; inset: 0; z-index: 2000; background: rgba(5,8,20,0.82); backdrop-filter: blur(14px); display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: opacity 0.3s ease, visibility 0.3s ease; }
.modal-backdrop.active { opacity: 1; visibility: visible; }
.modal-box { background: rgba(15,23,42,0.98); border: 1px solid rgba(255,107,53,0.25); border-radius: 22px; max-width: 400px; width: calc(100% - 32px); box-shadow: 0 24px 64px rgba(0,0,0,0.6); transform: scale(0.92) translateY(16px); transition: transform 0.35s cubic-bezier(0.34,1.56,0.64,1), opacity 0.3s ease; opacity: 0; overflow: hidden; }
.modal-backdrop.active .modal-box { transform: scale(1) translateY(0); opacity: 1; }
.modal-head { padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: space-between; }
.modal-head.reset-head { background: linear-gradient(135deg,rgba(239,68,68,0.35),rgba(220,38,38,0.25)); }
.modal-head.logout-head { background: linear-gradient(135deg,rgba(255,107,53,0.35),rgba(247,147,30,0.25)); }
.modal-head h3 { font-size: 0.95rem; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; }
.modal-x { background: none; border: none; color: rgba(255,255,255,0.6); font-size: 1.3rem; cursor: pointer; width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; flex-shrink: 0; }
.modal-x:hover { background: rgba(255,255,255,0.1); color: #fff; transform: rotate(90deg); }
.modal-body-inner { padding: 28px 24px 10px; text-align: center; }
.modal-icon { width: 68px; height: 68px; border-radius: 50%; margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; }
.modal-icon.reset-icon { background: linear-gradient(135deg,rgba(239,68,68,0.2),rgba(255,46,99,0.15)); border: 1.5px solid rgba(239,68,68,0.3); color: #f87171; }
.modal-icon.logout-icon { background: linear-gradient(135deg,rgba(255,107,53,0.2),rgba(247,147,30,0.15)); border: 1.5px solid rgba(255,107,53,0.3); color: var(--primary); }
.modal-title { font-size: 1.05rem; font-weight: 800; color: #fff; margin-bottom: 8px; }
.modal-desc { font-size: 0.85rem; color: rgba(255,255,255,0.55); line-height: 1.6; }
.modal-sub { font-size: 0.78rem; color: rgba(255,255,255,0.35); display: block; margin-top: 4px; }
.modal-actions { display: flex; gap: 10px; padding: 18px 24px 24px; }
.btn-modal { flex: 1; padding: 12px; border: none; border-radius: 12px; font-weight: 700; font-size: 0.86rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 7px; transition: all 0.25s; }
.btn-modal-cancel { background: rgba(255,255,255,0.07); border: 1.5px solid rgba(255,255,255,0.12); color: rgba(255,255,255,0.8); }
.btn-modal-cancel:hover { background: rgba(255,255,255,0.12); color: #fff; transform: translateY(-1px); }
.btn-modal-danger { background: linear-gradient(135deg,#EF4444,#dc2626); color: #fff; box-shadow: 0 4px 16px rgba(239,68,68,0.35); }
.btn-modal-danger:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(239,68,68,0.5); }
.btn-modal-primary { background: linear-gradient(135deg,var(--primary),var(--primary-dark)); color: #fff; box-shadow: 0 4px 16px rgba(255,107,53,0.3); }
.btn-modal-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(255,107,53,0.45); }

/* ── TOAST ── */
.toast { position: fixed; top: 20px; right: 20px; min-width: 300px; background: rgba(15,23,42,0.97); border: 1px solid rgba(255,107,53,0.25); backdrop-filter: blur(16px); padding: 16px 20px; border-radius: 16px; z-index: 10002; transform: translateX(120%); opacity: 0; transition: transform 0.5s cubic-bezier(0.4,0,0.2,1), opacity 0.5s ease; box-shadow: 0 12px 40px rgba(0,0,0,0.4); }
.toast.show { transform: translateX(0); opacity: 1; }
.toast-content { display: flex; align-items: center; gap: 14px; }
.toast-content i { font-size: 1.8rem; flex-shrink: 0; }
.toast-text { display: flex; flex-direction: column; gap: 2px; }
.toast-text strong { color: #fff; font-size: 0.95rem; }
.toast-text span { color: rgba(255,255,255,0.65); font-size: 0.85rem; }
.toast-success-icon { color: #22c55e; }
.toast-error-icon { color: #ef4444; }

/* ── RESPONSIVE ── */
@media (max-width: 768px) {
    .sidebar { transform: translateX(-100%); width: var(--sidebar-width) !important; }
    .sidebar.mobile-open { transform: translateX(0); }
    .mobile-topbar { display: flex; }
    .page-wrapper { margin-left: 0 !important; width: 100% !important; padding: 80px 16px 32px; }
    .form-grid { grid-template-columns: 1fr; }
    .form-grid .full { grid-column: 1; }
    .form-grid .section-label { grid-column: 1; }
    .profile-header { flex-direction: column; text-align: center; }
    .profile-meta { justify-content: center; }
    .form-actions { flex-direction: column; }
    .btn { width: 100%; justify-content: center; }
    .modal-actions { flex-direction: column; }
    .toast { top: 72px; right: 12px; left: 12px; min-width: auto; }
}
@media (max-width: 480px) {
    .avatar-actions { flex-direction: column; align-items: center; }
}
</style>

{{-- Hidden forms for photo reset and logout --}}
<form method="POST" action="{{ route('profile.photo.remove') }}" id="resetPhotoForm" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<form method="POST" action="{{ route('logout') }}" id="logoutForm" style="display:none;">
    @csrf
</form>

{{-- Reset Photo Modal --}}
<div class="modal-backdrop" id="resetModalBackdrop">
    <div class="modal-box">
        <div class="modal-head reset-head">
            <h3>Reset Profile Photo</h3>
            <button class="modal-x" onclick="closeResetModal()" type="button">&#10005;</button>
        </div>
        <div class="modal-body-inner">
            <div class="modal-icon reset-icon">
                <i class="bi bi-arrow-counterclockwise"></i>
            </div>
            <div class="modal-title">Remove your photo?</div>
            <div class="modal-desc">Your current photo will be removed and replaced with the default avatar.</div>
            <span class="modal-sub">This action cannot be undone.</span>
        </div>
        <div class="modal-actions">
            <button class="btn-modal btn-modal-cancel" onclick="closeResetModal()" type="button">
                <i class="bi bi-x-lg"></i> Cancel
            </button>
            <button class="btn-modal btn-modal-danger" id="confirmResetBtn" type="button">
                <i class="bi bi-arrow-counterclockwise"></i> Reset
            </button>
        </div>
    </div>
</div>

{{-- Logout Confirm Modal --}}
<div class="modal-backdrop" id="logoutModalBackdrop">
    <div class="modal-box">
        <div class="modal-head logout-head">
            <h3>Confirm Logout</h3>
            <button class="modal-x" onclick="closeLogoutModal()" type="button">&#10005;</button>
        </div>
        <div class="modal-body-inner">
            <div class="modal-icon logout-icon">
                <i class="bi bi-box-arrow-right"></i>
            </div>
            <div class="modal-title">Log out of Task Organizo?</div>
            <div class="modal-desc">Are you sure you want to log out?</div>
            <span class="modal-sub">You will need to sign in again to access your account.</span>
        </div>
        <div class="modal-actions">
            <button class="btn-modal btn-modal-cancel" onclick="closeLogoutModal()" type="button">
                Stay
            </button>
            <button class="btn-modal btn-modal-primary" onclick="document.getElementById('logoutForm').submit()" type="button">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </div>
    </div>
</div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('images/OIP.webp') }}" alt="Task Organizo" class="sidebar-logo-img">
        <span class="sidebar-logo-text">Task Organizo</span>
        <button class="sidebar-toggle" id="sidebarToggle" title="Toggle sidebar">
            <i class="bi bi-layout-sidebar-reverse"></i>
        </button>
    </div>
    <nav class="sidebar-nav">
        <a href="/landing" class="nav-item">
            <i class="bi bi-house-door nav-icon"></i>
            <span class="nav-label">Home</span>
        </a>
        <a href="/profile" class="nav-item active">
            <i class="bi bi-person nav-icon"></i>
            <span class="nav-label">Profile</span>
        </a>
        <a href="/dashboard" class="nav-item">
            <i class="bi bi-grid nav-icon"></i>
            <span class="nav-label">Dashboard</span>
        </a>
    </nav>
</aside>

<div class="mobile-topbar">
    <button class="mobile-hamburger" id="mobileHamburger">
        <i class="bi bi-list"></i>
    </button>
    <span class="mobile-logo">Task Organizo</span>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="page-wrapper">
    <div class="container">

      @php
    use Illuminate\Support\Facades\Storage;

    $avatarTimestamp = $user->updated_at
        ? $user->updated_at->timestamp
        : time();

    $avatarSrc = $user->avatar && Storage::disk('public')->exists($user->avatar)
        ? Storage::disk('public')->url($user->avatar) . '?v=' . $avatarTimestamp
        : asset('images/blank.jpg');

    $defaultAvatar = asset('images/blank.jpg');
@endphp
        {{-- Profile Header --}}
        <div class="profile-header">
            <div class="avatar-section">
                <div class="avatar-wrapper" onclick="document.getElementById('avatarFileInput').click()">
                    <img
                        src="{{ $avatarSrc }}"
                        alt="Profile Photo"
                        class="avatar-img"
                        id="avatarPreview"
                        data-saved="{{ $avatarSrc }}"
                        data-default="{{ $defaultAvatar }}"
                        onerror="this.src='{{ $defaultAvatar }}'"
                    >
                    <div class="avatar-upload-overlay">
                        <i class="bi bi-camera-fill"></i>
                    </div>
                </div>

                {{-- Separate photo upload form --}}
                <form method="POST"
                      action="{{ route('profile.photo.update') }}"
                      enctype="multipart/form-data"
                      id="photoForm">
                    @csrf
                    <input type="file" id="avatarFileInput" name="avatar" accept="image/*" style="display:none;">
                </form>

                <div class="avatar-actions">
                    <button type="button" class="avatar-btn" onclick="document.getElementById('avatarFileInput').click()">
                        <i class="bi bi-upload"></i> Upload
                    </button>
                    <button type="button" class="avatar-btn" id="btnUpdatePhoto" disabled>
                        <i class="bi bi-cloud-upload"></i> Save Photo
                    </button>
                    <button type="button" class="avatar-btn reset-btn" onclick="openResetModal()">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </button>
                </div>
                <div class="file-name-display" id="fileName">No file chosen</div>
            </div>

            <div class="profile-info">
                <div class="profile-name" id="headerName">{{ $user->name ?? 'Your Name' }}</div>
                <div class="profile-email">{{ $user->email ?? '' }}</div>
                <div class="profile-meta">
                    @if($user->phone ?? null)
                    <div class="meta-chip"><i class="bi bi-telephone-fill"></i> {{ $user->phone }}</div>
                    @endif
                    @if($user->address ?? null)
                    <div class="meta-chip"><i class="bi bi-geo-alt-fill"></i> {{ Str::limit($user->address, 30) }}</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Profile Info + Password in one form --}}
        <div class="card">
            <h2 class="card-title"><i class="bi bi-person-lines-fill"></i> Profile Settings</h2>

            <form id="profileForm" method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="form-grid">

                    <div class="section-label">Personal Information</div>

                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-input" value="{{ old('name', $user->name ?? '') }}" placeholder="Enter your full name" id="nameInput" required>
                        <div class="field-error @error('name') show @enderror">
                            <i class="bi bi-exclamation-circle"></i>
                            @error('name'){{ $message }}@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-input {{ $errors->has('email') ? 'input-error' : '' }}" value="{{ old('email', $user->email ?? '') }}" placeholder="Enter your email" required>
                        <div class="field-error @error('email') show @enderror">
                            <i class="bi bi-exclamation-circle"></i>
                            @error('email'){{ $message }}@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-input" value="{{ old('phone', $user->phone ?? '') }}" placeholder="e.g. +63 912 345 6789">
                        <div class="field-error @error('phone') show @enderror">
                            <i class="bi bi-exclamation-circle"></i>
                            @error('phone'){{ $message }}@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-input" value="{{ old('address', $user->address ?? '') }}" placeholder="Enter your address">
                        <div class="field-error @error('address') show @enderror">
                            <i class="bi bi-exclamation-circle"></i>
                            @error('address'){{ $message }}@enderror
                        </div>
                    </div>

                    <div class="form-group full">
                        <label class="form-label">Bio</label>
                        <textarea name="bio" class="form-textarea" placeholder="Tell us a little about yourself...">{{ old('bio', $user->bio ?? '') }}</textarea>
                        <div class="field-error @error('bio') show @enderror">
                            <i class="bi bi-exclamation-circle"></i>
                            @error('bio'){{ $message }}@enderror
                        </div>
                    </div>

                    <hr class="section-divider">
                    <div class="section-label">Change Password</div>

                    <div class="form-group full">
                        <label class="form-label">Current Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="current_password" class="form-input {{ $errors->has('current_password') ? 'input-error' : '' }}" placeholder="Enter current password" id="currentPassword" autocomplete="current-password">
                            <button type="button" class="toggle-password" onclick="togglePwd('currentPassword', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="field-error @error('current_password') show @enderror" id="currentPasswordError">
                            <i class="bi bi-exclamation-circle"></i>
                            @error('current_password'){{ $message }}@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="new_password" class="form-input {{ $errors->has('new_password') ? 'input-error' : '' }}" placeholder="New password (min 8 chars)" id="newPassword" autocomplete="new-password">
                            <button type="button" class="toggle-password" onclick="togglePwd('newPassword', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="field-error @error('new_password') show @enderror" id="newPasswordError">
                            <i class="bi bi-exclamation-circle"></i>
                            @error('new_password'){{ $message }}@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirm New Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="new_password_confirmation" class="form-input" placeholder="Confirm new password" id="confirmPassword" autocomplete="new-password">
                            <button type="button" class="toggle-password" onclick="togglePwd('confirmPassword', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="field-error" id="confirmPasswordError">
                            <i class="bi bi-exclamation-circle"></i>
                            <span></span>
                        </div>
                    </div>

                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="resetProfileForm()">
                        <i class="bi bi-x-lg"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // ── Sidebar ──
    const sidebar         = document.getElementById('sidebar');
    const overlay         = document.getElementById('sidebarOverlay');
    const sidebarToggle   = document.getElementById('sidebarToggle');
    const mobileHamburger = document.getElementById('mobileHamburger');
    const isMobile        = () => window.innerWidth <= 768;

    sidebarToggle?.addEventListener('click', () => {
        if (isMobile()) return;
        sidebar.classList.toggle('collapsed');
        document.body.classList.toggle('sidebar-collapsed');
    });

    mobileHamburger?.addEventListener('click', () => {
        sidebar.classList.toggle('mobile-open');
        overlay.classList.toggle('active');
        document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
    });

    overlay?.addEventListener('click', () => {
        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    });

    window.addEventListener('resize', () => {
        if (!isMobile()) {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeResetModal();
            closeLogoutModal();
        }
    });

    document.getElementById('resetModalBackdrop')?.addEventListener('click', function(e) {
        if (e.target === this) closeResetModal();
    });

    document.getElementById('logoutModalBackdrop')?.addEventListener('click', function(e) {
        if (e.target === this) closeLogoutModal();
    });

    // ── Avatar file picker ──
    const avatarInput  = document.getElementById('avatarFileInput');
    const avatarPreview = document.getElementById('avatarPreview');
    const fileName     = document.getElementById('fileName');
    const btnUpdate    = document.getElementById('btnUpdatePhoto');

    avatarInput?.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) { fileName.textContent = 'No file chosen'; btnUpdate.disabled = true; return; }
        if (!file.type.startsWith('image/')) {
            showToast('error', 'Invalid File', 'Please select a valid image file.');
            this.value = ''; return;
        }
        if (file.size > 2 * 1024 * 1024) {
            showToast('error', 'File Too Large', 'Image must be under 2MB.');
            this.value = ''; return;
        }
        fileName.textContent = file.name;
        btnUpdate.disabled = false;
        const reader = new FileReader();
        reader.onload = e => { avatarPreview.src = e.target.result; };
        reader.readAsDataURL(file);
    });

    // Save Photo button submits the separate photoForm
    btnUpdate?.addEventListener('click', () => {
        document.getElementById('photoForm').submit();
    });

    // ── Reset photo confirm ──
    document.getElementById('confirmResetBtn')?.addEventListener('click', () => {
        avatarPreview.src    = @json($defaultAvatar);
        avatarInput.value    = '';
        fileName.textContent = 'No file chosen';
        btnUpdate.disabled   = true;
        closeResetModal();
        setTimeout(() => document.getElementById('resetPhotoForm').submit(), 320);
    });

    // ── Live name preview ──
    document.getElementById('nameInput')?.addEventListener('input', e => {
        document.getElementById('headerName').textContent = e.target.value || '{{ $user->name ?? "" }}';
    });

    // ── Password match validation ──
    const newPassword     = document.getElementById('newPassword');
    const confirmPassword = document.getElementById('confirmPassword');
    const confirmError    = document.getElementById('confirmPasswordError');

    function checkPasswordMatch() {
        if (confirmPassword.value && newPassword.value !== confirmPassword.value) {
            confirmError.querySelector('span').textContent = 'Passwords do not match.';
            confirmError.classList.add('show');
            confirmPassword.classList.add('input-error');
        } else {
            confirmError.classList.remove('show');
            confirmPassword.classList.remove('input-error');
        }
    }

    newPassword?.addEventListener('input', checkPasswordMatch);
    confirmPassword?.addEventListener('input', checkPasswordMatch);

    document.getElementById('profileForm')?.addEventListener('submit', function(e) {
        if (newPassword.value && newPassword.value !== confirmPassword.value) {
            e.preventDefault();
            confirmError.querySelector('span').textContent = 'Passwords do not match.';
            confirmError.classList.add('show');
            confirmPassword.classList.add('input-error');
            confirmPassword.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    // ── Flash toasts ──
    @if(session('success'))
        showToast('success', 'Success', @json(session('success')));
    @endif

    @if(session('error'))
        showToast('error', 'Error', @json(session('error')));
    @endif

    @if($errors->any() && !session('success'))
        showToast('error', 'Validation Error', @json($errors->first()));
    @endif

});

// ── Helpers ──
function togglePwd(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') { input.type = 'text'; icon.className = 'bi bi-eye-slash'; }
    else                           { input.type = 'password'; icon.className = 'bi bi-eye'; }
}

function resetProfileForm() {
    document.getElementById('profileForm').reset();
    document.getElementById('headerName').textContent = '{{ $user->name ?? "" }}';
    ['currentPassword','newPassword','confirmPassword'].forEach(id => {
        const el = document.getElementById(id);
        if (el) { el.type = 'password'; el.classList.remove('input-error'); }
    });
    document.getElementById('confirmPasswordError')?.classList.remove('show');
}

function showToast(type, title, message) {
    document.querySelectorAll('.toast').forEach(t => t.remove());
    const toast = document.createElement('div');
    toast.className = 'toast';
    const iconClass = type === 'success'
        ? 'bi bi-check-circle-fill toast-success-icon'
        : 'bi bi-x-circle-fill toast-error-icon';
    toast.innerHTML = `
        <div class="toast-content">
            <i class="${iconClass}"></i>
            <div class="toast-text">
                <strong>${title}</strong>
                <span>${message}</span>
            </div>
        </div>`;
    document.body.appendChild(toast);
    requestAnimationFrame(() => toast.classList.add('show'));
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 500);
    }, 4000);
}

function openResetModal() {
    document.getElementById('resetModalBackdrop').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeResetModal() {
    document.getElementById('resetModalBackdrop').classList.remove('active');
    document.body.style.overflow = '';
}

function openLogoutModal() {
    document.getElementById('logoutModalBackdrop').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLogoutModal() {
    document.getElementById('logoutModalBackdrop').classList.remove('active');
    document.body.style.overflow = '';
}
</script>

@endsection