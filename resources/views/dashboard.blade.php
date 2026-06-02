@php
use Illuminate\Support\Facades\Storage;
@endphp
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
.sidebar-nav::-webkit-scrollbar-track { background: transparent; }
.sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,107,53,0.3); border-radius: 2px; }
.nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 14px; border-radius: 14px; color: rgba(255,255,255,0.7); text-decoration: none; font-weight: 600; font-size: 0.9rem; white-space: nowrap; position: relative; overflow: hidden; }
.nav-item::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(255,107,53,0.12), rgba(247,147,30,0.06)); opacity: 0; transition: opacity 0.25s ease; border-radius: 14px; }
.nav-item:hover::before { opacity: 1; }
.nav-item:hover { color: #fff; }
.nav-item.active { background: linear-gradient(135deg, rgba(255,107,53,0.22), rgba(247,147,30,0.12)); color: #fff; border: 1px solid rgba(255,107,53,0.25); box-shadow: 0 4px 16px rgba(255,107,53,0.15); }
.nav-item.active .nav-icon { color: var(--primary); }
.nav-icon { font-size: 1.2rem; flex-shrink: 0; width: 22px; text-align: center; transition: color 0.25s ease; }
.nav-label { opacity: 1; transition: opacity 0.2s ease; flex: 1; }
.sidebar.collapsed .nav-label { opacity: 0; pointer-events: none; width: 0; overflow: hidden; }
.sidebar.collapsed .nav-item { justify-content: center; padding: 12px; }
.sidebar-footer { padding: 16px 10px; border-top: 1px solid rgba(255,107,53,0.12); flex-shrink: 0; }
.logout-link { display: flex; align-items: center; gap: 12px; padding: 12px 14px; border-radius: 14px; color: rgba(255,255,255,0.7); font-weight: 600; font-size: 0.9rem; white-space: nowrap; background: none; border: none; width: 100%; cursor: pointer; text-align: left; transition: all 0.25s ease; }
.logout-link:hover { background: rgba(239,68,68,0.12); color: #ef4444; border-radius: 14px; }
.logout-link .nav-icon { color: inherit; }
.sidebar.collapsed .logout-link { justify-content: center; padding: 12px; }
.sidebar.collapsed .logout-label { opacity: 0; pointer-events: none; width: 0; overflow: hidden; }
.logout-label { opacity: 1; transition: opacity 0.2s ease; }

.mobile-topbar { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 60px; background: rgba(10,14,26,0.97); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,107,53,0.2); z-index: 1001; align-items: center; padding: 0 16px; gap: 12px; }
.mobile-hamburger { background: none; border: none; color: #fff; font-size: 1.4rem; cursor: pointer; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.mobile-hamburger:hover { background: rgba(255,107,53,0.15); }
.mobile-logo { font-size: 1.1rem; font-weight: 900; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

.page-wrapper { margin-left: var(--sidebar-width); min-height: 100vh; width: calc(100% - var(--sidebar-width)); transition: margin-left 0.35s cubic-bezier(0.4,0,0.2,1), width 0.35s cubic-bezier(0.4,0,0.2,1); padding: 40px clamp(20px,4vw,40px) 40px; }
body.sidebar-collapsed .page-wrapper { margin-left: var(--sidebar-collapsed); width: calc(100% - var(--sidebar-collapsed)); }

.modal, .delete-modal { background: rgba(5,10,20,0.72); backdrop-filter: blur(18px); animation: fadeBackdrop 0.35s ease; }
@keyframes fadeBackdrop { from { opacity: 0; } to { opacity: 1; } }
.modal-content, .delete-modal-content { position: relative; overflow: hidden; background: linear-gradient(145deg,rgba(30,41,59,0.96),rgba(15,23,42,0.96)); border: 1px solid rgba(255,255,255,0.08); box-shadow: 0 20px 60px rgba(0,0,0,0.45),inset 0 1px 0 rgba(255,255,255,0.05); backdrop-filter: blur(30px); animation: modalPop 0.35s cubic-bezier(0.4,0,0.2,1); }
.modal-content::before, .delete-modal-content::before { content: ''; position: absolute; top: 0; left: 30px; width: 90px; height: 4px; border-radius: 999px; background: linear-gradient(90deg,var(--primary),var(--primary-dark),var(--primary-light)); }
.modal-content::after, .delete-modal-content::after { content: ''; position: absolute; inset: 0; background: radial-gradient(circle at top right,rgba(255,107,53,0.14),transparent 40%); pointer-events: none; }
@keyframes modalPop { from { opacity: 0; transform: translateY(20px) scale(0.96); } to { opacity: 1; transform: translateY(0) scale(1); } }
.modal-title { font-size: clamp(1.7rem,4vw,2.1rem); background: linear-gradient(135deg,#fff,#ffb088,var(--primary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 900; letter-spacing: -0.5px; }
.form-input, .form-select { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); box-shadow: inset 0 1px 0 rgba(255,255,255,0.04); transition: all 0.25s ease; }
.form-input:hover, .form-select:hover { background: rgba(255,255,255,0.09); }
.form-input:focus, .form-select:focus { border-color: rgba(255,107,53,0.5); box-shadow: 0 0 0 4px rgba(255,107,53,0.12),0 10px 25px rgba(255,107,53,0.12); transform: translateY(-1px); }
.option-item { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); }
.option-item:hover { transform: translateY(-2px); background: rgba(255,107,53,0.08); }
.option-item.active { background: linear-gradient(135deg,rgba(255,107,53,0.95),rgba(247,147,30,0.95)); border-color: rgba(255,255,255,0.15); box-shadow: 0 12px 30px rgba(255,107,53,0.35); }
.btn,.add-btn,.confirm-delete,.cancel-delete { position: relative; overflow: hidden; }
.btn::before,.add-btn::before,.confirm-delete::before,.cancel-delete::before { content: ''; position: absolute; top: 0; left: -120%; width: 100%; height: 100%; background: linear-gradient(90deg,transparent,rgba(255,255,255,0.18),transparent); transition: left 0.6s ease; }
.btn:hover::before,.add-btn:hover::before,.confirm-delete:hover::before,.cancel-delete:hover::before { left: 120%; }
tbody tr { transition: background 0.25s ease, transform 0.25s ease; }
tbody tr:hover { background: rgba(255,255,255,0.04); transform: scale(1.005); }
.analytics-card { transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease, background 0.35s ease; }

.container { max-width: 1400px; margin: 0 auto; position: relative; z-index: 2; }

.analytics-grid { display: grid; grid-template-columns: repeat(auto-fit,minmax(260px,1fr)); gap: 1.5rem; margin-bottom: 2rem; }
.analytics-card { position: relative; overflow: hidden; padding: 2rem; border-radius: 28px; background: linear-gradient(145deg,rgba(255,255,255,0.08),rgba(255,255,255,0.03)); backdrop-filter: blur(25px); border: 1px solid rgba(255,255,255,0.08); box-shadow: 0 10px 40px rgba(0,0,0,0.25),inset 0 1px 0 rgba(255,255,255,0.08); display: flex; flex-direction: column; justify-content: space-between; min-height: 200px; }
.analytics-card::before { content: ''; position: absolute; inset: 0; background: radial-gradient(circle at top right,rgba(255,107,53,0.22),transparent 45%); pointer-events: none; }
.analytics-card::after { content: ''; position: absolute; top: 0; left: 24px; width: 70px; height: 4px; border-radius: 999px; background: linear-gradient(90deg,var(--primary),var(--primary-dark),var(--primary-light)); }
.analytics-card:hover { transform: translateY(-8px); border-color: rgba(255,107,53,0.25); box-shadow: 0 25px 60px rgba(0,0,0,0.35),0 0 25px rgba(255,107,53,0.15); }
.analytics-number { font-size: clamp(2.8rem,6vw,4rem); font-weight: 900; line-height: 1; margin-top: auto; margin-bottom: 1.2rem; background: linear-gradient(135deg,#ffffff,#ffb088,#ff6b35); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; letter-spacing: -2px; }
.analytics-label { font-size: 0.9rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: rgba(255,255,255,0.7); display: flex; align-items: center; gap: 10px; }
.analytics-label::before { content: ''; width: 10px; height: 10px; border-radius: 50%; background: linear-gradient(135deg,var(--primary),var(--primary-dark)); box-shadow: 0 0 12px rgba(255,107,53,0.5); }
.analytics-card:nth-child(1) .analytics-label::before { background: linear-gradient(135deg,#3b82f6,#2563eb); box-shadow: 0 0 12px rgba(59,130,246,0.5); }
.analytics-card:nth-child(2) .analytics-label::before { background: linear-gradient(135deg,#22c55e,#16a34a); box-shadow: 0 0 12px rgba(34,197,94,0.5); }
.analytics-card:nth-child(3) .analytics-label::before { background: linear-gradient(135deg,#ef4444,#dc2626); box-shadow: 0 0 12px rgba(239,68,68,0.5); }

.table-container { background: var(--card-bg); backdrop-filter: blur(25px); border: 1px solid var(--border); border-radius: 28px; padding: clamp(24px,4vw,40px); overflow: hidden; }
.table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: clamp(24px,4vw,36px); flex-wrap: wrap; gap: 16px; }
.table-title { font-size: clamp(1.5rem,4vw,2.2rem); font-weight: 800; background: linear-gradient(135deg,var(--primary),var(--primary-dark),var(--primary-light)); -webkit-background-clip: text; background-clip: text; color: transparent; margin: 0; }
.add-btn { background: linear-gradient(135deg,var(--primary),var(--primary-dark)); color: #fff; border: none; padding: 12px 24px; border-radius: 20px; font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: all 0.4s cubic-bezier(0.4,0,0.2,1); box-shadow: 0 12px 35px rgba(255,107,53,0.4); white-space: nowrap; display: flex; align-items: center; gap: 8px; }
.add-btn:hover { transform: translateY(-3px); box-shadow: 0 20px 45px rgba(255,107,53,0.6); }

.table-scroll-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; border-radius: 16px; }
.table-scroll-wrap::-webkit-scrollbar { height: 6px; }
.table-scroll-wrap::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); border-radius: 3px; }
.table-scroll-wrap::-webkit-scrollbar-thumb { background: rgba(255,107,53,0.4); border-radius: 3px; }
.table-scroll-wrap::-webkit-scrollbar-thumb:hover { background: rgba(255,107,53,0.6); }

table { width: 100%; min-width: 750px; border-collapse: collapse; color: #fff; font-size: 0.9rem; }
th, td { padding: 16px 14px; text-align: left; border-bottom: 1px solid var(--border); white-space: nowrap; }
th { background: rgba(255,107,53,0.12); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.78rem; color: rgba(255,255,255,0.9); }
th:nth-child(2), td:nth-child(2) { text-align: center; width: 70px; padding: 10px 8px; }

.user-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,107,53,0.5); box-shadow: 0 0 0 3px rgba(255,107,53,0.1),0 4px 12px rgba(0,0,0,0.3); display: block; margin: 0 auto; transition: transform 0.3s ease, box-shadow 0.3s ease; }
.user-avatar:hover { transform: scale(1.15); box-shadow: 0 0 0 3px rgba(255,107,53,0.3),0 8px 20px rgba(0,0,0,0.4); }

.role-badge, .status-badge, .gender-badge { padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; border: 1px solid; white-space: nowrap; display: inline-block; }
.user-badge { background: rgba(59,130,246,0.15); color: #60a5fa; border-color: rgba(59,130,246,0.3); }
.admin-badge { background: rgba(250,204,21,0.2); color: #facc15; border-color: rgba(250,204,21,0.4); }
.male-badge { background: rgba(91,92,94,0.15); color: #b4b5b6; border-color: rgba(163,165,168,0.3); }
.female-badge { background: rgba(236,72,153,0.2); color: #f472b6; border-color: rgba(236,72,153,0.3); }
.other-badge { background: rgba(168,85,247,0.15); color: #c084fc; border-color: rgba(168,85,247,0.3); }
.status-active { background: rgba(34,197,94,0.2); color: #22c55e; border-color: rgba(34,197,94,0.4); }
.status-inactive { background: rgba(239,68,68,0.2); color: #ef4444; border-color: rgba(239,68,68,0.4); }

.action-btn { background: none; border: none; color: var(--primary); cursor: pointer; padding: 8px 14px; border-radius: 10px; transition: all 0.3s ease; margin: 0 3px; font-weight: 600; font-size: 0.82rem; }
.action-btn:hover { background: rgba(255,107,53,0.15); transform: scale(1.05); }
.delete-btn { color: #ef4444; }
.delete-btn:hover { background: rgba(239,68,68,0.15); }

.modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(20px); z-index: 10000; align-items: center; justify-content: center; padding: 20px; }
.modal.active { display: flex; }
.modal-content { background: rgba(25,25,35,0.98); backdrop-filter: blur(25px); border-radius: 28px; padding: clamp(28px,6vw,44px); max-width: 580px; width: 100%; max-height: 90vh; overflow-y: auto; border: 1px solid rgba(255,107,53,0.3); position: relative; animation: modalSlideIn 0.4s cubic-bezier(0.4,0,0.2,1); }
@keyframes modalSlideIn { from { opacity: 0; transform: scale(0.95) translateY(-30px); } to { opacity: 1; transform: scale(1) translateY(0); } }
.modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: clamp(20px,3vw,30px); }
.close-btn { background: none; border: none; font-size: 1.8rem; color: rgba(255,255,255,0.8); cursor: pointer; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; }
.close-btn:hover { background: rgba(255,107,53,0.2); color: #fff; transform: rotate(90deg); }

.form-group { margin-bottom: clamp(16px,3vw,24px); }
.form-label { display: block; margin-bottom: 10px; font-weight: 700; color: rgba(255,255,255,0.95); font-size: 0.95rem; }
.form-input, .form-select { width: 100%; background: rgba(255,255,255,0.08); border: 2px solid rgba(255,255,255,0.15); border-radius: 16px; padding: 14px 20px; font-size: 0.95rem; color: #fff; outline: none; backdrop-filter: blur(15px); transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
.form-input::placeholder { color: rgba(255,255,255,0.5); }
.form-input:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(255,107,53,0.15); background: rgba(255,255,255,0.12); transform: translateY(-1px); }

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: clamp(12px,2vw,20px); }
.option-group { display: flex; gap: clamp(8px,1.5vw,14px); flex-wrap: wrap; }
.option-item { flex: 1; min-width: 100px; display: flex; align-items: center; gap: 10px; padding: clamp(12px,2.5vw,16px) clamp(14px,2.5vw,18px); background: rgba(255,255,255,0.08); border: 2px solid rgba(255,255,255,0.15); border-radius: 14px; cursor: pointer; transition: all 0.3s cubic-bezier(0.4,0,0.2,1); color: #fff; font-weight: 600; font-size: 0.85rem; }
.option-item:hover { border-color: var(--primary); background: rgba(255,107,53,0.1); }
.option-item.active { background: linear-gradient(135deg,var(--primary),var(--primary-dark)); border-color: var(--primary); box-shadow: 0 8px 25px rgba(255,107,53,0.4); transform: translateY(-2px); }

.modal-actions { display: flex; gap: clamp(10px,2vw,16px); justify-content: flex-end; margin-top: clamp(24px,4vw,36px); }
.btn { padding: 14px clamp(20px,4vw,32px); border-radius: 18px; font-weight: 800; cursor: pointer; transition: all 0.4s cubic-bezier(0.4,0,0.2,1); border: none; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; display: flex; align-items: center; justify-content: center; flex: 1; }
.btn-primary { background: linear-gradient(135deg,var(--primary),var(--primary-dark)); color: #fff; box-shadow: 0 12px 35px rgba(255,107,53,0.4); }
.btn-primary:hover { transform: translateY(-3px); box-shadow: 0 20px 45px rgba(255,107,53,0.5); }
.btn-secondary { background: rgba(255,255,255,0.1); color: #fff; border: 2px solid rgba(255,255,255,0.2); }
.btn-secondary:hover { background: rgba(255,255,255,0.2); transform: translateY(-2px); }

.delete-modal { position: fixed; inset: 0; background: rgba(0,0,0,0.8); display: none; align-items: center; justify-content: center; z-index: 10001; padding: 20px; }
.delete-modal.active { display: flex; }
.delete-modal-content { width: min(500px,90vw); background: rgba(31,41,55,0.98); padding: clamp(28px,6vw,40px); border-radius: 28px; text-align: center; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(25px); }
.delete-modal-content p { color: rgba(255,255,255,0.85); margin-bottom: clamp(24px,4vw,36px); line-height: 1.7; font-size: 0.95rem; }
.delete-modal-buttons { display: flex; gap: clamp(10px,2vw,16px); justify-content: center; flex-wrap: wrap; }
.delete-modal-buttons button { flex: 1; min-width: 130px; border: none; padding: 14px 24px; border-radius: 18px; cursor: pointer; font-weight: 800; font-size: 0.9rem; transition: all 0.3s cubic-bezier(0.4,0,0.2,1); text-transform: uppercase; letter-spacing: 0.5px; }
.cancel-delete { background: rgba(75,85,99,0.5); color: #fff; }
.cancel-delete:hover { background: rgba(75,85,99,0.7); transform: translateY(-2px); }
.confirm-delete { background: linear-gradient(135deg,#ef4444,#dc2626); color: #fff; box-shadow: 0 10px 30px rgba(239,68,68,0.4); }
.confirm-delete:hover { transform: translateY(-2px); box-shadow: 0 15px 40px rgba(239,68,68,0.5); }

.toast { position: fixed; top: 20px; right: 20px; min-width: 280px; padding: 16px 20px; border-radius: 18px; box-shadow: 0 20px 50px rgba(0,0,0,0.4); z-index: 10002; color: #fff; font-weight: 600; font-size: 0.95rem; opacity: 0; transform: translateX(100%); transition: all 0.4s cubic-bezier(0.4,0,0.2,1); }
.toast.show { opacity: 1; transform: translateX(0); }
.success-toast { background: linear-gradient(135deg,#22c55e,#16a34a); }
.error-toast { background: linear-gradient(135deg,#ef4444,#dc2626); }
.loading { opacity: 0.7; pointer-events: none; }

@media (max-width: 768px) {
    .sidebar { transform: translateX(-100%); width: var(--sidebar-width) !important; }
    .sidebar.mobile-open { transform: translateX(0); }
    .mobile-topbar { display: flex; }
    .page-wrapper { margin-left: 0 !important; width: 100% !important; padding: 80px 16px 32px; }
    .analytics-grid { grid-template-columns: 1fr; gap: 1rem; }
    .table-header { flex-direction: column; align-items: stretch; text-align: center; }
    .add-btn { width: 100%; justify-content: center; }
    .modal-actions { flex-direction: column; }
    .btn { width: 100%; }
    .delete-modal-buttons { flex-direction: column; }
    .form-row { grid-template-columns: 1fr; }
}
@media (max-width: 480px) {
    th:nth-child(1), td:nth-child(1) { display: none; }
}
</style>

@if(session('success'))
<div class="toast success-toast show">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="toast error-toast show">{{ session('error') }}</div>
@endif

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
        <a href="/profile" class="nav-item">
            <i class="bi bi-person nav-icon"></i>
            <span class="nav-label">Profile</span>
        </a>
        <a href="/dashboard" class="nav-item active">
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
        <div class="analytics-grid">
            <div class="analytics-card">
                <div class="analytics-number">{{ $totalUsers }}</div>
                <div class="analytics-label">Total Users</div>
            </div>
            <div class="analytics-card">
                <div class="analytics-number" style="background: linear-gradient(135deg,#22c55e,#16a34a); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    {{ $activeUsers }}
                </div>
                <div class="analytics-label">Active Users</div>
            </div>
            <div class="analytics-card">
                <div class="analytics-number" style="background: linear-gradient(135deg,#ef4444,#dc2626); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    {{ $inactiveUsers }}
                </div>
                <div class="analytics-label">Inactive Users</div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h2 class="table-title">User Management</h2>
                <button class="add-btn" onclick="userManager.openAddModal()">
                    <i class="bi bi-plus-lg"></i> Add New User
                </button>
            </div>
            <div class="table-scroll-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                        <tr>
                            <td>{{ $u->id }}</td>
                          <td>
    <img
        src="{{ $u->avatar ? Storage::url($u->avatar) . '?v=' . ($u->updated_at ? $u->updated_at->timestamp : time()) : asset('images/blank.jpg') }}"
        alt="{{ $u->name }}"
        class="user-avatar"
        onerror="this.src='{{ asset('images/blank.jpg') }}'"
    >
</td> 
                             
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                {{-- ✅ FIX: Guard against null gender --}}
                                @php $gender = $u->gender ?? 'other'; @endphp
                                <span class="gender-badge {{ $gender === 'male' ? 'male-badge' : ($gender === 'female' ? 'female-badge' : 'other-badge') }}">
                                    {{ ucfirst($gender) }}
                                </span>
                            </td>
                            <td>
                                <span class="role-badge {{ ($u->role ?? 'user') === 'admin' ? 'admin-badge' : 'user-badge' }}">
                                    {{ ucfirst($u->role ?? 'user') }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge {{ ($u->status ?? 'inactive') === 'active' ? 'status-active' : 'status-inactive' }}">
                                    {{ ucfirst($u->status ?? 'inactive') }}
                                </span>
                            </td>
                            <td>
                                <button class="action-btn" onclick="userManager.openEditModal({{ $u->id }})">Edit</button>
                                <button class="action-btn delete-btn" onclick="userManager.openDeleteModal({{ $u->id }}, '{{ addslashes($u->name) }}')">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:60px; color:rgba(255,255,255,0.6);">No users found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="userModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">Add New User</h2>
            <button class="close-btn" onclick="userManager.closeModal()">&times;</button>
        </div>
        <form id="userForm">
            @csrf
            <input type="hidden" id="userId" name="id">
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" id="userName" name="name" class="form-input" placeholder="Enter full name" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" id="userEmail" name="email" class="form-input" placeholder="Enter email address" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Gender</label>
                    <div class="option-group">
                        <div class="option-item" data-value="male">
                            <input type="radio" name="gender" id="genderMale" value="male">
                            <label for="genderMale">Male</label>
                        </div>
                        <div class="option-item" data-value="female">
                            <input type="radio" name="gender" id="genderFemale" value="female">
                            <label for="genderFemale">Female</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <div class="option-group">
                        <div class="option-item" data-value="admin">
                            <input type="radio" name="role" id="roleAdmin" value="admin">
                            <label for="roleAdmin">Admin</label>
                        </div>
                        <div class="option-item" data-value="user">
                            <input type="radio" name="role" id="roleUser" value="user">
                            <label for="roleUser">User</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <div class="option-group">
                    <div class="option-item" data-value="active">
                        <input type="radio" name="status" id="statusActive" value="active">
                        <label for="statusActive">Active</label>
                    </div>
                    <div class="option-item" data-value="inactive">
                        <input type="radio" name="status" id="statusInactive" value="inactive">
                        <label for="statusInactive">Inactive</label>
                    </div>
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="userManager.closeModal()">Cancel</button>
                <button type="submit" class="btn btn-primary" id="submitBtn">Save User</button>
            </div>
        </form>
    </div>
</div>

<div id="deleteModal" class="delete-modal">
    <div class="delete-modal-content">
        <div class="modal-header" style="margin-bottom:16px;">
            <h2 class="modal-title">Delete User</h2>
            <button class="close-btn" onclick="userManager.closeDeleteModal()">&times;</button>
        </div>
        <p id="deleteConfirmText">Are you sure you want to delete this user? This action cannot be undone.</p>
        <div class="delete-modal-buttons">
            <button class="cancel-delete" onclick="userManager.closeDeleteModal()">Cancel</button>
            <button class="confirm-delete" id="confirmDeleteBtn" style="flex:1; min-width:130px;">Delete User</button>
        </div>
    </div>
</div>

<script>
// ✅ FIX: Inline onerror handles broken avatar images without a separate JS loop
class UserManager {
    constructor() {
        this.modal          = document.getElementById('userModal');
        this.deleteModal    = document.getElementById('deleteModal');
        this.form           = document.getElementById('userForm');
        this.submitBtn      = document.getElementById('submitBtn');
        this.sidebar        = document.getElementById('sidebar');
        this.overlay        = document.getElementById('sidebarOverlay');
        this.sidebarToggle  = document.getElementById('sidebarToggle');
        this.mobileHamburger= document.getElementById('mobileHamburger');
        this.deleteUserId   = null;
        this.isMobile       = () => window.innerWidth <= 768;
        this.init();
    }

    init() {
        this.setupSidebar();
        this.setupEventListeners();
        this.setupOptionSelections();
        this.hideToasts();
    }

    setupSidebar() {
        this.sidebarToggle.addEventListener('click', () => {
            if (this.isMobile()) return;
            this.sidebar.classList.toggle('collapsed');
            document.body.classList.toggle('sidebar-collapsed');
        });
        this.mobileHamburger.addEventListener('click', () => {
            this.sidebar.classList.toggle('mobile-open');
            this.overlay.classList.toggle('active');
            document.body.style.overflow = this.sidebar.classList.contains('mobile-open') ? 'hidden' : '';
        });
        this.overlay.addEventListener('click', () => {
            this.sidebar.classList.remove('mobile-open');
            this.overlay.classList.remove('active');
            document.body.style.overflow = '';
        });
        window.addEventListener('resize', () => {
            if (!this.isMobile()) {
                this.sidebar.classList.remove('mobile-open');
                this.overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }

    setupEventListeners() {
        this.form.addEventListener('submit', (e) => this.handleFormSubmit(e));

        // ✅ FIX: Delete is now a plain button (no nested form) to avoid PUT/DELETE method issues
        document.getElementById('confirmDeleteBtn').addEventListener('click', () => this.handleDeleteSubmit());

        document.querySelectorAll('.modal, .delete-modal').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) { this.closeModal(); this.closeDeleteModal(); }
            });
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') { this.closeModal(); this.closeDeleteModal(); }
        });
    }

    setupOptionSelections() {
        document.querySelectorAll('.option-item').forEach(item => {
            item.addEventListener('click', () => {
                const group = item.closest('.form-group');
                group.querySelectorAll('.option-item').forEach(el => el.classList.remove('active'));
                item.classList.add('active');
                const radio = item.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;
            });
        });
    }

    openAddModal() {
        this.form.reset();
        document.getElementById('userId').value = '';
        document.getElementById('modalTitle').textContent = 'Add New User';
        document.querySelectorAll('.option-item').forEach(el => el.classList.remove('active'));
        this.modal.classList.add('active');
    }

    openEditModal(userId) {
        fetch(`/api/users/${userId}`)
            .then(res => res.ok ? res.json() : Promise.reject('Failed to fetch user'))
            .then(user => {
                document.getElementById('userId').value    = user.id;
                document.getElementById('userName').value  = user.name;
                document.getElementById('userEmail').value = user.email;
                document.querySelectorAll('.option-item').forEach(el => el.classList.remove('active'));
                ['gender', 'role', 'status'].forEach(field => {
                    const input = document.querySelector(`input[name="${field}"][value="${user[field]}"]`);
                    if (input) { input.checked = true; input.closest('.option-item').classList.add('active'); }
                });
                document.getElementById('modalTitle').textContent = 'Edit User';
                this.modal.classList.add('active');
            })
            .catch(() => this.showToast('Failed to load user data', 'error'));
    }

    closeModal() {
        this.modal.classList.remove('active');
        this.form.reset();
        document.querySelectorAll('.option-item').forEach(el => el.classList.remove('active'));
    }

    openDeleteModal(userId, userName) {
        this.deleteUserId = userId;
        document.getElementById('deleteConfirmText').textContent =
            `Are you sure you want to delete "${userName}"? This action cannot be undone.`;
        this.deleteModal.classList.add('active');
    }

    closeDeleteModal() {
        this.deleteModal.classList.remove('active');
        this.deleteUserId = null;
    }

    async handleFormSubmit(e) {
        e.preventDefault();
        const formData = new FormData(this.form);
        const isEdit   = !!formData.get('id');
        const url      = isEdit ? `/users/${formData.get('id')}` : '/users';
        if (isEdit) formData.append('_method', 'PUT');

        this.submitBtn.disabled    = true;
        this.submitBtn.textContent = 'Saving...';
        this.form.classList.add('loading');

        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            });
            const data = await response.json().catch(() => ({}));
            if (!response.ok) throw new Error(data.message || 'Something went wrong!');
            this.showToast(isEdit ? 'User updated successfully!' : 'User added successfully!', 'success');
            this.closeModal();
            setTimeout(() => window.location.reload(), 800);
        } catch (err) {
            this.showToast(err.message || 'Network error', 'error');
        } finally {
            this.submitBtn.disabled    = false;
            this.submitBtn.textContent = 'Save User';
            this.form.classList.remove('loading');
        }
    }

    async handleDeleteSubmit() {
        if (!this.deleteUserId) return;
        const btn = document.getElementById('confirmDeleteBtn');
        btn.disabled    = true;
        btn.textContent = 'Deleting...';

        try {
            const res = await fetch(`/users/${this.deleteUserId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            });
            if (!res.ok) throw new Error('Delete failed');
            this.showToast('User deleted successfully!', 'success');
            this.closeDeleteModal();
            setTimeout(() => window.location.reload(), 800);
        } catch (err) {
            this.showToast(err.message || 'Delete failed', 'error');
        } finally {
            btn.disabled    = false;
            btn.textContent = 'Delete User';
        }
    }

    showToast(message, type = 'success') {
        document.querySelectorAll('.toast').forEach(t => t.remove());
        const toast = document.createElement('div');
        toast.className = `toast ${type}-toast show`;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 400); }, 4000);
    }

    hideToasts() {
        setTimeout(() => {
            document.querySelectorAll('.toast.show').forEach(t => {
                t.classList.remove('show'); setTimeout(() => t.remove(), 400);
            });
        }, 4000);
    }
}

const userManager = new UserManager();
</script>

@endsection