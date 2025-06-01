<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendataan | BPKAD</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon1.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
    <div class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="card shadow p-4" style="width: 400px;">
            <div class="text-center">
                <img src="../assets/images/logos/baner-2048x260.jpg" width="300" height="50" alt="Logo">
                <h5 class="mt-3">Silakan Login</h5>
            </div>
            <form action="proses_login.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" required class="form-control" id="username" placeholder="Masukkan username">
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" required class="form-control" id="password" placeholder="Masukkan password">
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100">Sign In</button>
            </form>
            <!-- <div class="text-center mt-3">
                <a href="register_view.php" class="text-primary">Daftar Akun</a>
            </div> -->
        </div>
    </div>

    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>