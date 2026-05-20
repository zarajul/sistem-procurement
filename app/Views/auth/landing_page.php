<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Procurement - PT HIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Variabel Warna, Font Dasar & Smooth Scroll */
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc; /* Terang namun tidak menyilaukan */
            color: #1e293b; /* Teks abu-abu gelap untuk keterbacaan */
            overflow-x: hidden;
        }

        /* Custom Navbar dengan efek Light Glassmorphism */
        .navbar {
            background-color: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(77, 26, 17, 0.1);
            transition: all 0.3s ease-in-out;
        }
        .navbar-brand {
            font-weight: 700;
            color: #4d1a11 !important; /* Aksen Coklat Utama */
            letter-spacing: 1px;
        }
        .nav-link {
            color: #475569 !important;
            font-weight: 500;
            transition: color 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            color: #4d1a11 !important;
        }

        /* Hero Section dengan Gambar Background*/
        .hero-section {
            background: linear-gradient(to right, rgba(248, 250, 252, 0.95) 0%, rgba(248, 250, 252, 0.8) 100%), url('https://images.unsplash.com/photo-1504307651254-35680f356dfd?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 80px; 
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            background: -webkit-linear-gradient(45deg, #4d1a11, #8b3220);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 1.15rem;
            color: #64748b;
            margin-bottom: 2.5rem;
            font-weight: 400;
        }

        /* Custom Buttons dengan Aksen Coklat */
        .btn-custom-outline {
            background: #4d1a11;
            border: 2px solid transparent;
            color: #ffffff;
            font-weight: 600;
            padding: 4px 16px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-custom-outline:hover {
            background: transparent;
            border: 2px solid #4d1a11;
            color: #4d1a11;
            box-shadow: none;
        }         

        .text-brown { color: #4d1a11; }

        /* Footer */
        footer {
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 20px 0;
            color: #64748b;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand">
                <span style="color: #1e293b;">HIS Steel</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <a class="btn btn-custom-outline" href="<?= base_url('auth/login') ?>">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center mx-auto">
                    <span class="badge bg-danger bg-opacity-10 text-brown mb-3 px-3 py-2 rounded-pill border border-danger border-opacity-25">Procurement For Building & Housing</span>
                    <h1 class="hero-title">Pre-Fabricated Specialist</h1>
                    <p class="hero-subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    
                </div>
            </div>
        </div>
    </section>


    <footer class="text-center">
        <div class="container">
            <p class="mb-0">&copy; <?= date('Y') ?> Sistem Procurement - PT Hakiki.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>