<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AQR - Avicenna Quick Response</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.6s ease-out;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .animated-bg {
            background: linear-gradient(-45deg, #ffffff, #fef7f0, #fff5f0, #ffeee6);
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
        }

        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
        }

        /* Text Animations */
        @keyframes typewriter {
            from { width: 0; }
            to { width: 100%; }
        }

        @keyframes blink {
            50% { border-color: transparent; }
        }

        .typewriter {
            overflow: hidden;
            border-right: 2px solid #f97316;
            white-space: nowrap;
            animation: typewriter 3s steps(40) 1s both, blink 1s step-end infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .floating-text {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(5deg); }
            75% { transform: rotate(-5deg); }
        }

        .wave-text {
            display: inline-block;
            animation: wave 2s ease-in-out infinite;
        }

        .letter-animation {
            display: inline-block;
            animation: float 2s ease-in-out infinite;
        }

        .letter-animation:nth-child(1) { animation-delay: 0s; }
        .letter-animation:nth-child(2) { animation-delay: 0.1s; }
        .letter-animation:nth-child(3) { animation-delay: 0.2s; }
        .letter-animation:nth-child(4) { animation-delay: 0.3s; }
        .letter-animation:nth-child(5) { animation-delay: 0.4s; }
        .letter-animation:nth-child(6) { animation-delay: 0.5s; }
        .letter-animation:nth-child(7) { animation-delay: 0.6s; }
        .letter-animation:nth-child(8) { animation-delay: 0.7s; }
        .letter-animation:nth-child(9) { animation-delay: 0.8s; }
        .letter-animation:nth-child(10) { animation-delay: 0.9s; }

        @keyframes glow {
            0%, 100% { text-shadow: 0 0 5px #f97316, 0 0 10px #f97316; }
            50% { text-shadow: 0 0 20px #f97316, 0 0 30px #fb923c; }
        }

        .glow-text {
            animation: glow 2s ease-in-out infinite;
        }
    </style>
</head>

<body class="animated-bg min-h-screen">
    <div id="particles-js"></div>
    <nav class="fixed top-0 w-full bg-white border-b border-gray-200 z-50 rounded-b-2xl shadow-lg">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="/" class="flex items-center space-x-3">
                <span class="self-center text-2xl font-semibold whitespace-nowrap text-indigo-600">AQR</span>
            </a>
            {{-- <div class="flex items-center md:order-2 space-x-3">

                <!-- Dropdown menu -->
                <div class="flex items-center md:order-2 space-x-3">
                    <a href="/login"
                        class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>

                </div>
            </div> --}}

        </div>
    </nav>

    <div class="mt-8">
        <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        particlesJS('particles-js', {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: ['#f97316', '#fb923c', '#fdba74'] },
                shape: { type: 'circle' },
                opacity: { value: 0.5, random: false },
                size: { value: 3, random: true },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: '#f97316',
                    opacity: 0.4,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 2,
                    direction: 'none',
                    random: false,
                    straight: false,
                    out_mode: 'out',
                    bounce: false
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: { enable: true, mode: 'repulse' },
                    onclick: { enable: true, mode: 'push' },
                    resize: true
                }
            },
            retina_detect: true
        });

        // Text Animation Functions
        function animateLetters(element) {
            const text = element.textContent;
            element.innerHTML = '';

            for (let i = 0; i < text.length; i++) {
                const span = document.createElement('span');
                span.textContent = text[i] === ' ' ? '\u00A0' : text[i];
                span.className = 'letter-animation';
                span.style.animationDelay = `${i * 0.1}s`;
                element.appendChild(span);
            }
        }

        function typewriterEffect(element, text, speed = 100) {
            element.innerHTML = '';
            let i = 0;

            function type() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                }
            }
            type();
        }

        // Initialize text animations when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-animate elements with specific classes
            document.querySelectorAll('.animate-letters').forEach(animateLetters);

            document.querySelectorAll('.typewriter-auto').forEach(element => {
                const text = element.textContent;
                typewriterEffect(element, text);
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
