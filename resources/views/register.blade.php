@extends('layouts.main')

@section('content')
<style>

    
.register-wrapper {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 60px 15px;
}
.register-card {
    width: 100%;
    max-width: 460px;
    background: rgba(10, 10, 15, 0.75);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 24px;
    box-shadow: 0 30px 80px rgba(0, 0, 0, 0.6);
    padding: 40px;
    color: #fff;
    position: relative;
    animation: floatIn 0.8s ease-out forwards;
    opacity: 0;
    transform: translateY(20px);
}
@keyframes floatIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.register-title {
    text-align: center;
    font-size: 30px;
    font-weight: 900;
    margin-bottom: 25px;
    background: linear-gradient(135deg, #ff6b35, #ffc107);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.form-label {
    font-weight: 600;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.9);
}
.form-control, .form-select {
    width: 100%;
    background: #fff;
    border: none;
    border-radius: 14px;
    padding: 12px 15px;
    margin: 6px 0 15px;
    font-weight: 500;
    color: #111;
    outline: none;
}
.form-control::placeholder {
    color: #888;
}
.form-control:focus, .form-select:focus {
    box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.3);
}
.form-control:-webkit-autofill {
    -webkit-box-shadow: 0 0 0 1000px #fff inset !important;
    -webkit-text-fill-color: #111 !important;
}
.password-box {
    position: relative;
}
.toggle-pass {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 1.2rem;
}
.btn-custom {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 14px;
    font-weight: 800;
    background: linear-gradient(135deg, #ff6b35, #ffc107);
    color: #111;
    cursor: pointer;
    transition: all 0.3s ease;
}
.btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}
.small-text {
    text-align: center;
    margin-top: 18px;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.8);
}
.small-text a {
    color: #ffc107;
    font-weight: 700;
    text-decoration: none;
}
.toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #22c55e;
    color: #fff;
    padding: 12px 18px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    z-index: 9999;
    opacity: 0;
    transform: translateY(-20px);
    animation: toastFade 0.5s forwards;
}
.toast.error {
    background: #ef4444;
}
@keyframes toastFade {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

@if(session('success'))
<div id="toast" class="toast">{{ session('success') }}</div>
@endif

@if(session('error'))
<div id="toast" class="toast error">{{ session('error') }}</div>
@endif

<div class="register-wrapper">
    <div class="register-card">
        <div class="register-title">Create Account</div>
        @if ($errors->any())
        <div style="background:#ef4444;color:#fff;padding:10px;border-radius:10px;margin-bottom:15px;">
            @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            <label class="form-label">Password</label>
            <div class="password-box">
                <input type="password" name="password" id="password" class="form-control" required>
                <span class="toggle-pass" onclick="togglePass('password')">👁</span>
            </div>
            <label class="form-label">Confirm Password</label>
            <div class="password-box">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                <span class="toggle-pass" onclick="togglePass('password_confirmation')">👁</span>
            </div>
            <label class="form-label">Gender</label>
            <select name="gender" class="form-select" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            <button type="submit" class="btn-custom">Create Account</button>
            <div class="small-text">
                Already have an account?
                <a href="{{ route('login') }}">Login</a>
            </div>
        </form>
    </div>
</div>
<script>
function togglePass(id) {
    const input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
}
document.addEventListener("DOMContentLoaded", function () {
    const toast = document.getElementById('toast');
    if (toast) {
        setTimeout(() => {
            toast.style.transition = "opacity 0.5s, transform 0.5s";
            toast.style.opacity = "0";
            toast.style.transform = "translateY(-20px)";
            setTimeout(() => toast.remove(), 500);
        }, 2500);
    }
});
</script>
@endsection