<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INTEGRADES - Platform Aksi Lingkungan</title>
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#74A740',
                        dark: '#121a0f',
                        gray: '#545454',
                        light: '#fafafa',
                        green: '#ebf2e8'
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
            html, body {
            font-family: 'Poppins', Arial, Helvetica, sans-serif;
            }
              .hero-outer-shadow {
            width: 900px;
            height: 180px;
            border-radius: 50%;
            background: radial-gradient(ellipse at center, rgba(129,0,0,0.13) 0%, rgba(129,0,0,0.07) 60%, rgba(129,0,0,0.01) 100%);
            filter: blur(48px);
            opacity: 0.7;
            animation: shadowFloat 8s ease-in-out infinite;
            transition: opacity 0.3s;
        }
        .hero-shadow-animate {
            width: 80%;
            height: 80%;
            border-radius: 50%;
            background: radial-gradient(ellipse at center, rgba(129,0,0,0.12) 0%, rgba(129,0,0,0.08) 60%, rgba(129,0,0,0.04) 100%);
            filter: blur(48px);
            opacity: 0.85;
            animation: shadowFloat 8s ease-in-out infinite;
            transition: opacity 0.3s;
        }
        @keyframes shadowFloat {
            0%, 100% { transform: scale(1) translateY(0); opacity: 0.85; }
            50% { transform: scale(1.08) translateY(18px); opacity: 1; }
        }
                .hero-img-animate {
            animation: heroZoomFloat 12s ease-in-out infinite;
            will-change: transform;
        }
        @keyframes heroZoomFloat {
            0%, 100% {
                transform: scale(1) translateY(0px);
            }
            20% {
                transform: scale(1.04) translateY(-6px);
            }
            50% {
                transform: scale(1.07) translateY(8px);
            }
            80% {
                transform: scale(1.04) translateY(-6px);
            }
        }
        /* Animated Gradient Background */
                    .animated-gradient-bg {
            position: fixed;
            inset: 0;
            z-index: -10;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            /* Warna lebih soft dan trust */
            background: linear-gradient(120deg, #ebf2e8 0%, #f7fafc 40%, #b7e4c7 70%, #e3f6f5 100%);
            background-size: 200% 200%; /* Lebih kecil, area warna lebih fokus */
            background-position: var(--bg-x, 50%) var(--bg-y, 50%);
            transition: background-position 0.3s cubic-bezier(.4,2,.6,1);
            opacity: 0.22; /* Cukup jelas tapi tetap nyaman */
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        /* Keyframe Animations */
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes bounce-subtle {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* Animation Classes */
        .animate-fade-in {
            animation: fade-in 0.8s ease-out;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-bounce-subtle {
            animation: bounce-subtle 2s ease-in-out infinite;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Enhanced button hover effects */
        .btn-hover-effect {
            position: relative;
            overflow: hidden;
        }

        .btn-hover-effect::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-hover-effect:hover::before {
            left: 100%;
        }

        /* Card shimmer effect */
        .card-shimmer {
            position: relative;
            overflow: hidden;
        }

        .card-shimmer::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s;
            z-index: 1;
        }

        .card-shimmer:hover::before {
            left: 100%;
        }

        /* Shining Text Effect untuk card titles */
    .group:hover .group-hover\:text-shine {
        background: linear-gradient(
            to right,
            #74A740 20%,
            #ff1a1a 30%,
            #74A740 70%,
            #660000 80%
        );
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        background-size: 200% auto;
        animation: textShine 3s ease-in-out infinite;
    }

    @keyframes textShine {
        0% { background-position: 0% 50%; }
        100% { background-position: 100% 50%; }
    }
    </style>
</head>
<body class="relative bg-light animate-fade-in mb-20">
    <div class="animated-gradient-bg"></div>
    @include('components.navbar')
    <!-- ...konten lain... -->

    <!-- Hero Section -->
    <section class="relative z-10"> <!-- Hapus padding atas yang berlebihan -->
          <!-- OUTER SHADOW -->
        <div class="absolute left-1/2 top-[220px] -translate-x-1/2 -z-10 pointer-events-none"> <!-- Sesuaikan top dari 420px ke 220px -->
            <div class="hero-outer-shadow"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 pt-12 pb-8"> <!-- Ubah py-8 menjadi pt-4 pb-8 -->
            <div class="relative rounded-2xl overflow-hidden h-[500px] bg-gradient-to-r from-black/60 to-black/40">
                <!-- Dynamic Shadow (z-0, di bawah gambar) -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-0">
                    <div class="hero-shadow-animate"></div>
                </div>
                <!-- Hero Image (z-10) -->
                <img src="https://images.unsplash.com/photo-1661405001746-264a95ad6fea?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="People cleaning beach"
                    class="absolute inset-0 w-full h-full object-cover z-10 hero-img-animate">
                <!-- Overlay (z-20) -->
                <div class="absolute inset-0 bg-black/40 z-20"></div>
                <!-- Konten Hero (z-20) --> <!-- Turunkan dari z-30 ke z-20 -->
                <div class="relative z-20 flex flex-col items-center justify-center h-full text-center text-white px-8 animate-fade-in">
                    <!-- ...konten hero... -->
                <h1 class="text-4xl md:text-5xl font-bold mb-6 max-w-4xl">
                    Cara termudah untuk aksi <br>peduli desa nyata.</br>
                </h1>
                <p class="text-lg md:text-xl mb-8 max-w-2xl opacity-90">
                    Temukan dan ikuti campaign peduli desa di area kamu. Kontribusi sesuai dengan kemuampuan kamu untuk desa yang lebih sejahtra
                    dan masyarakat yang lebih baik.
                </p>
                <a href="{{ route('register') }}">
                    <button class="bg-[#74A740] hover:bg-[#a507834] text-white px-8 py-3 text-lg font-semibold rounded-md transition-all duration-300 hover:scale-110 hover:shadow-xl animate-pulse hover:animate-none btn-hover-effect">
                        Mulai Sekarang!
                    </button>
                </a>
            </div>
        </div>
    </div>
    </section>

    <!-- Environmental Actions Section -->
    <section class="py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-dark mb-12 animate-fade-in hover:animate-bounce-subtle transition-all duration-300">
                Pilihan Aksi Peduli Desa
            </h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Action Card 1 -->
                <div class="overflow-hidden border border-gray-200 rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-xl hover:-translate-y-2 cursor-pointer group card-shimmer stagger-animation animate-fade-in bg-white">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=200&q=80"
                             alt="Beach cleaning action"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-dark mb-3 group-hover:text-shine transition-all duration-300">
                            Campaign Peduli UMKM
                        </h3>
                        <p class="text-gray leading-relaxed">
                            Ikuti aksi peduli UMKM untuk masyarakat yang lebih sejahtera. Dibutuhkan volunteer yang berkopetensi di bidang ekonomi dan bisnis untuk membantu mengembangkan usaha kecil di desa.
                        </p>
                    </div>
                </div>

                <!-- Action Card 2 -->
                <div class="overflow-hidden border border-gray-200 rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-xl hover:-translate-y-2 cursor-pointer group card-shimmer stagger-animation animate-fade-in bg-white">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1547036967-23d11aacaee0?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=200&q=80"
                             alt="River cleaning action"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-dark mb-3 group-hover:text-shine transition-all duration-300">
                            Campaign Masyarakat Pesisir Sejahtera
                        </h3>
                        <p class="text-gray leading-relaxed">
                            Pengadaan budidaya dan hasil laut di pesisir untuk meningkatkan kesejahteraan masyarakat.
                        </p>
                    </div>
                </div>

                <!-- Action Card 3 -->
                <div class="overflow-hidden border border-gray-200 rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-xl hover:-translate-y-2 cursor-pointer group card-shimmer stagger-animation animate-fade-in bg-white">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=200&q=80"
                             alt="Forest cleaning action"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-dark mb-3 group-hover:text-shine transition-all duration-300">
                            Campaign Pemanfaatan Hasil Hutan
                        </h3>
                        <p class="text-gray leading-relaxed">
                            Jaga kelestarian hutan kita agar kembali bermanfaat bagi masyarakat melalui partisipasi aktif dalam aksi pemanfaatan hasil hutan yang berkelanjutan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-dark text-center mb-12">Siap Membuat Perubahan?</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="text-center transition-all duration-300 hover:scale-105 hover:shadow-lg hover:bg-light p-6 rounded-lg cursor-pointer group stagger-animation animate-fade-in">
                    <div class="w-16 h-16 bg-green rounded-full mx-auto mb-4 flex items-center justify-center transition-all duration-300 group-hover:bg-primary/10 group-hover:scale-110">
                         <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Rina Puspita" class="w-12 h-12 rounded-full object-cover">
                    </div>
                    <h4 class="font-bold text-dark mb-1 group-hover:text-shine transition-all duration-300">
                        Rina Puspita
                    </h4>
                    <p class="text-gray text-sm mb-4">Volunteer</p>
                    <p class="text-gray text-sm leading-relaxed">
                        "INTEGRADES mempermudah saya menemukan aksi peduli desa yang relevan. Prosesnya cepat dan dampaknya langsung terasa bagi pribadi dan masyarakat sekitar."
                    </p>
                </div>

                <!-- Testimonial 2 -->
                <div class="text-center transition-all duration-300 hover:scale-105 hover:shadow-lg hover:bg-light p-6 rounded-lg cursor-pointer group stagger-animation animate-fade-in">
                    <div class="w-16 h-16 bg-green rounded-full mx-auto mb-4 flex items-center justify-center transition-all duration-300 group-hover:bg-primary/10 group-hover:scale-110">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Agus Salim" class="w-12 h-12 rounded-full object-cover">
                    </div>
                    <h4 class="font-bold text-dark mb-1 group-hover:text-shine transition-all duration-300">
                        Agus Salim
                    </h4>
                    <p class="text-gray text-sm mb-4">Volunteer</p>
                    <p class="text-gray text-sm leading-relaxed">
                        "Platform yang efektif untuk menyalurkan keinginan berkontribusi nyata. INTEGRADES membantu mengorganisir aksi jadi lebih terstruktur."
                    </p>
                </div>

                <!-- Testimonial 3 -->
                <div class="text-center transition-all duration-300 hover:scale-105 hover:shadow-lg hover:bg-light p-6 rounded-lg cursor-pointer group stagger-animation animate-fade-in">
                    <div class="w-16 h-16 bg-green rounded-full mx-auto mb-4 flex items-center justify-center transition-all duration-300 group-hover:bg-primary/10 group-hover:scale-110">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Dewi Lestari" class="w-12 h-12 rounded-full object-cover">
                    </div>
                    <h4 class="font-bold text-dark mb-1 group-hover:text-shine transition-all duration-300">
                        Dewi Lestari
                    </h4>
                    <p class="text-gray text-sm mb-4">Masyarakat Desa</p>
                    <p class="text-gray text-sm leading-relaxed">
                        "Dengan INTEGRADES, melakukan pengaduan permasalahan di masyarakat jadi lebih mudah. Sangat membantu untuk mencapai tujuan masyrakat yang sejahtera."
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 px-4 bg-light border-t border-gray-200">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-gray text-sm">@2025 INTEGRADES. Hak cipta dilindungi.</p>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Intersection Observer for scroll animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: "0px 0px -50px 0px",
            }

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("animate-fade-in")
                    }
                })
            }, observerOptions)

            // Observe all elements that should animate on scroll
            const animateElements = document.querySelectorAll(".stagger-animation")
            animateElements.forEach((el) => observer.observe(el))

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
                anchor.addEventListener("click", function (e) {
                    e.preventDefault()
                    const target = document.querySelector(this.getAttribute("href"))
                    if (target) {
                        target.scrollIntoView({
                            behavior: "smooth",
                            block: "start",
                        })
                    }
                })
            })

            // Add loading state to buttons
            document.querySelectorAll('button').forEach((button) => {
                button.addEventListener("click", function () {
                    if (!this.classList.contains("loading")) {
                        this.classList.add("loading")
                        setTimeout(() => {
                            this.classList.remove("loading")
                        }, 2000)
                    }
                })
            })

            // Parallax effect for hero section
            window.addEventListener("scroll", () => {
                const scrolled = window.pageYOffset
                const parallax = document.querySelector(".hero-bg")
                if (parallax) {
                    const speed = scrolled * 0.5
                    parallax.style.transform = `translateY(${speed}px)`
                }
            })

            // Add click handlers for action cards
            document.querySelectorAll('.card-shimmer').forEach((card) => {
                card.addEventListener('click', function() {
                    const title = this.querySelector('h3').textContent
                    showNotification(`Tertarik dengan ${title}? Fitur ini akan segera hadir!`, 'success')
                })
            })

        })

        // Utility functions
        function showNotification(message, type = "success") {
            const notification = document.createElement("div")
            notification.className = `fixed top-4 right-4 p-4 rounded-lg text-white z-50 animate-fade-in ${
                type === "success" ? "bg-green-500" : "bg-red-500"
            }`
            notification.textContent = message
            document.body.appendChild(notification)

            setTimeout(() => {
                notification.remove()
            }, 3000)
        }

        function toggleLoading(element, isLoading) {
            if (isLoading) {
                element.classList.add("loading")
                element.disabled = true
            } else {
                element.classList.remove("loading")
                element.disabled = false
            }
        }

        // Add some interactive features
        document.addEventListener('mousemove', (e) => {
            const cards = document.querySelectorAll('.card-shimmer')
            cards.forEach(card => {
                const rect = card.getBoundingClientRect()
                const x = e.clientX - rect.left
                const y = e.clientY - rect.top

                if (x >= 0 && x <= rect.width && y >= 0 && y <= rect.height) {
                    card.style.transform = `perspective(1000px) rotateX(${(y - rect.height / 2) / 10}deg) rotateY(${(x - rect.width / 2) / 10}deg) scale3d(1.05, 1.05, 1.05)`
                } else {
                    card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)'
                }
            })
        })

        // Reset card transforms when mouse leaves
        document.addEventListener('mouseleave', () => {
            const cards = document.querySelectorAll('.card-shimmer')
            cards.forEach(card => {
                card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)'
            })
        })

        document.addEventListener('mousemove', function(e) {
        const x = Math.round((e.clientX / window.innerWidth) * 100);
        const y = Math.round((e.clientY / window.innerHeight) * 100);
        document.querySelector('.animated-gradient-bg').style.setProperty('--bg-x', `${x}%`);
        document.querySelector('.animated-gradient-bg').style.setProperty('--bg-y', `${y}%`);
    });
     // Daftar foto untuk slideshow
    const heroImages = [
        "https://images.unsplash.com/photo-1661405001746-264a95ad6fea?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        "https://images.unsplash.com/photo-1625314563148-572c6af9e9d5?q=80&w=2046&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        "https://images.unsplash.com/photo-1643213379811-17f8c9ec7b66?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        "https://images.unsplash.com/photo-1650234856233-63058d00ba52?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        "https://images.unsplash.com/photo-1661335910388-1fb03c1d8700?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
    ];
    let heroIndex = 0;
    setInterval(() => {
        heroIndex = (heroIndex + 1) % heroImages.length;
        const heroImg = document.querySelector('.hero-img-animate');
        if (heroImg) {
            heroImg.src = heroImages[heroIndex];
        }
    }, 4000); // Ganti foto setiap 4 detik
    </script>
</body>
</html>
