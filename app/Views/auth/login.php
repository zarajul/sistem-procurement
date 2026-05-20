<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Procurement HIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fdfbfb 0%, #f3ece8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-glass { 
            background: #ffffff; 
            border: 1px solid rgba(77, 26, 17, 0.08); 
            border-radius: 20px; 
            box-shadow: 0 15px 35px rgba(77, 26, 17, 0.06);
            padding: 45px 35px; 
            width: 100%;
            max-width: 400px;
        }
        .text-brown { color: #4d1a11; }
        .title-section {
            margin-bottom: 2.5rem !important;
        }
        .btn-custom-primary {
            background: linear-gradient(135deg, #4d1a11, #702619);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px;
            border-radius: 10px;
            transition: all 0.3s ease;
            margin-top: 10px; 
        }
        .btn-custom-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(77, 26, 17, 0.25);
            color: white;
        }
        .form-control { 
            border-radius: 10px;
            padding: 12px 15px; 
            font-size: 0.9rem;
            background-color: #fafafa;
            border: 1px solid #eaeaec;
        }
        .form-control:focus {
            background-color: #ffffff;
            border-color: #4d1a11;
            box-shadow: 0 0 0 0.25rem rgba(77, 26, 17, 0.1);
        }
    </style>
</head>
<body>

    <div class="card-glass">
        <div class="text-center title-section">
            <h2 class="fw-bold text-brown">Login</h2>
            <p class="text-secondary small">Masuk ke akun anda</p>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger rounded-3 small px-3 py-2"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success rounded-3 small px-3 py-2"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('auth/processLogin') ?>" method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-custom-primary w-100 mb-3">Login</button>
        </form>
        <div class="text-center mt-3">
            <a href="<?= base_url() ?>" class="text-decoration-none text-secondary small">← Kembali ke Beranda</a>
        </div>
    </div>

</body>
</html>