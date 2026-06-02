<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Task Organizo</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: #fff;

            min-height: 100vh;

            background:
                linear-gradient(
                    135deg,
                    rgba(15,15,25,0.55),
                    rgba(25,25,45,0.55)
                ),
                url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');

            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            isolation: isolate;
            overflow-x: hidden;
        }

        /* Grain overlay */
        .hero-grain {
            position: fixed;
            inset: 0;
            z-index: -9;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.025'%3E%3Ccircle cx='30' cy='30' r='1'/%3E%3Ccircle cx='10' cy='10' r='0.5'/%3E%3Ccircle cx='50' cy='50' r='0.8'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            animation: grain 8s steps(10) infinite;
        }

        @keyframes grain {
            0%,100%{transform:translate(0,0)}
            10%{transform:translate(-5%,5%)}
            20%{transform:translate(-10%,5%)}
            30%{transform:translate(5%,-5%)}
            40%{transform:translate(-5%,15%)}
            50%{transform:translate(-10%,5%)}
            60%{transform:translate(15%,0)}
            70%{transform:translate(0,10%)}
            80%{transform:translate(-15%,0)}
            90%{transform:translate(10%,5%)}
        }

        /* ===== TOAST ===== */
        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            background: rgba(0,0,0,0.85);
            backdrop-filter: blur(12px);
            color: #fff;
            padding: 14px 18px;
            border-radius: 12px;
            margin-top: 10px;
            border: 1px solid rgba(255,255,255,0.15);
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

    </style>
</head>

<body>

    <div class="hero-grain"></div>

    {{-- Toast system --}}
    <div class="toast-container" id="toastContainer"></div>

    @yield('content')

    <script>
        function showToast(message, type = "success") {
            const container = document.getElementById("toastContainer");

            const toast = document.createElement("div");
            toast.classList.add("toast");

            toast.innerText = message;

            if (type === "error") {
                toast.style.borderColor = "#ff4d4d";
            } else if (type === "success") {
                toast.style.borderColor = "#ffc107";
            }

            container.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    </script>

</body>
</html>