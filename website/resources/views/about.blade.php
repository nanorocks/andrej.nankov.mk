<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        canvas {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 0;
            background: #232323;
            opacity: 0.2;
            pointer-events: none;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var canvas = document.getElementById("canvas"),
                ctx = canvas.getContext('2d');

            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            var stars = [],
                FPS = 60,
                x = 100,
                mouse = {
                    x: 0,
                    y: 0
                };

            for (var i = 0; i < x; i++) {
                stars.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    radius: Math.random() * 1 + 1,
                    vx: Math.floor(Math.random() * 50) - 25,
                    vy: Math.floor(Math.random() * 50) - 25
                });
            }

            function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.globalCompositeOperation = "lighter";

                // Draw stars
                for (var i = 0; i < stars.length; i++) {
                    var s = stars[i];
                    ctx.fillStyle = "#fff";
                    ctx.beginPath();
                    ctx.arc(s.x, s.y, s.radius, 0, 2 * Math.PI);
                    ctx.fill();
                    ctx.strokeStyle = 'black';
                    ctx.stroke();
                }

                // Draw lines between close stars
                for (var i = 0; i < stars.length; i++) {
                    for (var j = i + 1; j < stars.length; j++) {
                        var starI = stars[i];
                        var starJ = stars[j];
                        var dist = distance(starI, starJ);
                        if (dist < 120) {
                            ctx.beginPath();
                            ctx.moveTo(starI.x, starI.y);
                            ctx.lineTo(starJ.x, starJ.y);
                            ctx.strokeStyle = "rgba(255,255,255," + (1 - dist / 120) + ")";
                            ctx.lineWidth = 0.7;
                            ctx.stroke();
                        }
                    }
                }

                // Draw lines from mouse to close stars
                for (var i = 0; i < stars.length; i++) {
                    var starI = stars[i];
                    var dist = distance(mouse, starI);
                    if (dist < 150) {
                        ctx.beginPath();
                        ctx.moveTo(starI.x, starI.y);
                        ctx.lineTo(mouse.x, mouse.y);
                        ctx.strokeStyle = "rgba(255,255,255,0.3)";
                        ctx.lineWidth = 0.7;
                        ctx.stroke();
                    }
                }
            }

            function distance(point1, point2) {
                var xs = point2.x - point1.x;
                var ys = point2.y - point1.y;
                return Math.sqrt(xs * xs + ys * ys);
            }

            function update() {
                for (var i = 0; i < stars.length; i++) {
                    var s = stars[i];
                    s.x += s.vx / FPS;
                    s.y += s.vy / FPS;
                    if (s.x < 0 || s.x > canvas.width) s.vx = -s.vx;
                    if (s.y < 0 || s.y > canvas.height) s.vy = -s.vy;
                }
            }

            canvas.addEventListener('mousemove', function(e) {
                mouse.x = e.clientX;
                mouse.y = e.clientY;
            });

            function tick() {
                draw();
                update();
                requestAnimationFrame(tick);
            }

            tick();
        });
    </script>
</head>

<body class="antialiased font-sans">
    <canvas id="canvas"></canvas>
    <!-- The rest of your content overlays the canvas -->
    <div class="bg-dark-50 text-black/50 bg-black text-white/50">
        <img id="background" class="absolute left-0 top-0 w-auto h-auto max-w-full max-h-full pointer-events-none z-0"
            src="https://laravel.com/assets/img/welcome/background.svg" style="object-fit: contain;" />
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="flex justify-center py-10">
                    <div class="flex items-center space-x-2">
                        @if (Route::has('login'))
                            <livewire:welcome.navigation class="menu menu-horizontal" />
                        @endif
                    </div>
                </header>
                <div class="w-full p-6">
                    <!-- Card -->
                    <div class="card">
                        <div class="card-body items-center text-center">

                            <!-- Profile Image -->
                            <div class="avatar mb-6">
                                <div class="w-28 rounded-full ring ring-red-500 ring-offset-0">
                                    <img src="https://avatars.githubusercontent.com/u/18250654?v=4" alt="Profile Photo">
                                </div>
                            </div>

                            <h2 class="text-2xl font-semibold mb-2">Andrej Nankov</h2>
                            <p class="text-lg text-gray-400 mb-4">Software Engineer | M.Sc. | YOE +7</p>

                            <div class="space-y-6 text-base leading-relaxed text-left max-w-2xl mx-auto text-justify">
                                <ul class="list list-inside mb-4">
                                    <li>
                                        My work is guided by <span class="font-semibold text-red-400">Discipline</span>,
                                        <span class="font-semibold text-red-400">Passion</span>, and
                                        <span class="font-semibold text-red-400">Focus</span>.
                                    </li>
                                </ul>

                                <p>
                                    I partner with startups and companies to turn complex ideas into reliable, scalable
                                    software solutions.
                                    With over 7 years of hands-on experience in <span class="font-semibold">FinTech,
                                        E-commerce, Telecommunications,
                                        and Digital Transformation</span>, I bring a mix of technical expertise and
                                    strategic guidance to every project.
                                </p>

                                <p>
                                    I specialize in <span class="font-semibold">technical consulting, system
                                        architecture, and hands-on development</span>.
                                    From planning and design to deployment and optimization, I help teams make the right
                                    decisions early,
                                    avoid costly mistakes, and deliver software that truly works for their business.
                                </p>

                                <p>
                                    My expertise spans both frontend and backend development, with experience across the
                                    JavaScript, PHP, and Java ecosystems. I enjoy creating clean, efficient code,
                                    implementing best practices like SOLID principles and design patterns, and mentoring
                                    teams to grow.
                                </p>

                                <p>
                                    Beyond client work, I share knowledge through writing, blogging, and content
                                    creation
                                    about software engineering, finance, and technology trends. I’m also passionate
                                    about
                                    exploring new places and documenting my travels through video content.
                                </p>

                                <div class="mt-8 text-lg font-medium text-red-400 flex items-center gap-2">
                                    🚀 If you’re looking for a fractional CTO,
                                    project consultant, or a senior engineer,
                                    I’d love to collaborate on turning your vision into reality.
                                </div>

                                <!-- CV Button -->
                                <div class="mt-10 flex justify-center">
                                    <a href="https://bit.ly/4lJ7bJG" target="_blank"
                                        class="inline-flex items-center px-6 py-3 bg-red-500 text-white font-semibold rounded-lg shadow hover:bg-red-600 transition-colors duration-200">
                                        <i data-feather="download" class="mr-2"></i>
                                        Grab My CV
                                    </a>
                                </div>
                            </div>

                        </div>

                        <footer class="py-16 text-center text-sm text-grey dark:text-white/70">
                            Release v{{ Illuminate\Foundation\Application::VERSION }} -
                            Environment v{{ PHP_VERSION }}
                            <br />

                            <!-- Social Icons -->
                            <div class="flex gap-4 mt-4 justify-center">
                                <a target="_blank" href="https://www.linkedin.com/in/nanorocks/"
                                    class="btn btn-circle btn-outline btn-sm transition-all duration-200 hover:text-white text-gray-400 border-gray-400 hover:border-white"
                                    title="LinkedIn">
                                    <i data-feather="linkedin" class="w-5 h-5"></i>
                                </a>
                                <a target="_blank" href="https://medium.com/nanorocks"
                                    class="btn btn-circle btn-outline btn-sm transition-all duration-200 hover:text-white text-gray-400 border-gray-400 hover:border-white"
                                    title="Medium" rel="noopener">
                                    <i data-feather="book-open" class="w-5 h-5"></i>
                                </a>
                                <a target="_blank" href="https://www.youtube.com/@nanorocks"
                                    class="btn btn-circle btn-outline btn-sm transition-all duration-200 hover:text-white text-gray-400 border-gray-400 hover:border-white"
                                    title="YouTube">
                                    <i data-feather="youtube" class="w-5 h-5"></i>
                                </a>
                                <a target="_blank" href="https://github.com/nanorocks"
                                    class="btn btn-circle btn-outline btn-sm transition-all duration-200 hover:text-white text-gray-400 border-gray-400 hover:border-white"
                                    title="GitHub">
                                    <i data-feather="github" class="w-5 h-5"></i>
                                </a>
                                <a target="_blank" href="https://www.facebook.com/nanorocks"
                                    class="btn btn-circle btn-outline btn-sm transition-all duration-200 hover:text-white text-gray-400 border-gray-400 hover:border-white"
                                    title="Facebook">
                                    <i data-feather="facebook" class="w-5 h-5"></i>
                                </a>
                            </div>

                        </footer>
                    </div>
                </div>
            </div>
</body>

</html>
<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();
</script>
