<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard Procurement' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8fafc; color: #1e293b; overflow-x: hidden; }
        
        /* Wrapper & Layout */
        .wrapper { display: flex; width: 100%; align-items: stretch; min-height: 100vh; }
        
        /* Sidebar */
        .sidebar { 
            min-width: 250px; max-width: 250px; 
            background: #ffffff; border-right: 1px solid rgba(77, 26, 17, 0.1); 
            box-shadow: 2px 0 15px rgba(0,0,0,0.02); transition: all 0.3s; z-index: 1000;
        }
        .sidebar.collapsed { min-width: 0; max-width: 0; overflow: hidden; border: none; }
        
        .brand-container { padding: 18px 25px; border-bottom: 2px solid rgba(77, 26, 17, 0.15); text-align: center; }
        .brand { font-weight: 800; color: #4d1a11; font-size: 1.3rem; letter-spacing: 0.5px; line-height: 1.2; }
        .subtitle { color: #64748b; font-size: 0.65rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-top: 2px; }
        
        /* Menu Berjarak */
        .nav-item { margin-bottom: 8px; } 
        .nav-link { 
            color: #64748b; font-weight: 500; font-size: 0.85rem; padding: 10px 25px; 
            transition: all 0.3s; border-left: 4px solid transparent; display: flex; align-items: center; gap: 12px; 
        }
        .nav-link i { font-size: 1.1rem; width: 22px; text-align: center; }
        .nav-link:hover, .nav-link.active { color: #4d1a11; background-color: rgba(77, 26, 17, 0.05); border-left-color: #4d1a11; }

        /* Main Panel & Topbar (Diperkecil) */
        .main-panel { width: 100%; display: flex; flex-direction: column; transition: all 0.3s; }
        .topbar { 
            background: #ffffff; 
            height: 55px;
            display: flex; align-items: center; justify-content: space-between; 
            padding: 0 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border-bottom: 1px solid #f1f5f9;
        }
        .btn-toggle { background: transparent; border: none; font-size: 1.1rem; color: #4d1a11; cursor: pointer; padding: 5px; }
        .content-area { padding: 25px; flex-grow: 1; }

        /* General UI */
        .card-custom { border: none; border-radius: 12px; background: #ffffff; box-shadow: 0 4px 15px rgba(77, 26, 17, 0.05); }
        .btn-custom-primary { background: linear-gradient(135deg, #4d1a11, #702619); color: white; border: none; border-radius: 8px; }
        .btn-custom-primary:hover { color: white; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(77, 26, 17, 0.2); }
    </style>
</head>
<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar">
            <div class="brand-container">
                <div class="brand">HIS STEEL</div>
                <div class="subtitle">Pre-Fabricated Specialist</div>
            </div>
            <ul class="nav flex-column mt-4">
                <li class="nav-item">
                    <a class="nav-link <?= (url_is('dashboard')) ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
                        <i class="fa-solid fa-chart-pie"></i> DASHBOARD
                    </a>
                </li>
                <?php if(session()->get('role') == 'admin1'): ?>
                <li class="nav-item">
                    <a class="nav-link <?= (url_is('supplier*')) ? 'active' : '' ?>" href="<?= base_url('supplier') ?>">
                        <i class="fa-solid fa-users-viewfinder"></i> MANAJEMEN SUPPLIER
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (url_is('saw*')) ? 'active' : '' ?>" href="<?= base_url('saw') ?>">
                        <i class="fa-solid fa-magnifying-glass-chart"></i> ANALISIS SUPPLIER
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (url_is('pembelian*')) ? 'active' : '' ?>" href="<?= base_url('pembelian') ?>">
                        <i class="fa-solid fa-file-invoice-dollar"></i> TRANSAKSI PEMBELIAN
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (url_is('penjadwalan*')) ? 'active' : '' ?>" href="<?= base_url('penjadwalan') ?>">
                        <i class="fa-solid fa-truck-fast"></i> JADWAL PENGIRIMAN
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        
        <div class="main-panel">
            <div class="topbar">
                <button type="button" id="sidebarToggle" class="btn-toggle">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none text-dark dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="text-end me-2 d-none d-md-block">
                            <span class="d-block fw-bold" style="font-size: 0.80rem; color: #4d1a11; line-height: 1.1;"><?= session()->get('nama') ?></span>
                            <span class="d-block text-secondary" style="font-size: 0.65rem;">@<?= session()->get('username') ?></span>
                        </div>
                        <img src="https://ui-avatars.com/api/?name=<?= session()->get('nama') ?>&background=4d1a11&color=fff&bold=true" alt="Avatar" width="32" height="32" class="rounded-circle shadow-sm">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-2 rounded-3" aria-labelledby="dropdownUser">
                        <li><a class="dropdown-item py-2 small" href="<?= base_url('profil') ?>"><i class="fa-solid fa-user-gear me-2 text-secondary"></i> Kelola Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2 small text-danger fw-bold" href="<?= base_url('auth/logout') ?>"><i class="fa-solid fa-power-off me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>

            <div class="content-area">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script untuk Sembunyikan/Tampilkan Sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        });

        // Auto-hide Alert
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = "0";
                setTimeout(function() { alert.remove(); }, 500);
            });
        }, 3000);
    </script>
</body>
</html>