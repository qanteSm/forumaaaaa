
<?php
session_start();

if (isset($_SESSION['entered']) && $_SESSION['entered'] === true) {
    header("Location: main.php");
    exit(); 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Giriş Yap - Forum</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
    body {
        margin-top: 20px;
        background: #eee;
        color: #708090;
    }
</style>
</head>
<body>
<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">

<!-- Üst Menü Başlangıcı -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="main.html">Forum</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link"  href="main.php">Ana Sayfa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="giris.php">Giriş</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="kaydol.php">Kaydol</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- Üst Menü Sonu -->

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card mt-5">
        <div class="card-body">
          <h3 class="card-title text-center">Giriş Yap</h3>
          <?php if(isset($_GET['error']) && $_GET['error'] == 'empty'): ?>
            <div class="alert alert-danger" role="alert">
              Kullanıcı adın veya şifren boş olamaz eşşek.
            </div>
          <?php endif; ?>
          <?php if(isset($_GET['error']) && $_GET['error'] == 'error'): ?>
            <div class="alert alert-danger" role="alert">
              Bir hata oluştu daha sonra tekrar deneyiniz.
            </div>
          <?php endif; ?>
          <?php if(isset($_GET['error']) && $_GET['error'] == 'nouser'): ?>
            <div class="alert alert-danger" role="alert">
              Böyle bir kullanıcı bulunamadı adam gibi username gir eşşek.
            </div>
          <?php endif; ?>
          <?php if(isset($_GET['error']) && $_GET['error'] == 'wrongpass'): ?>
            <div class="alert alert-danger" role="alert">
              Şifren yanlış yoksa hesap mı çalmaya çalışıyon küçük eşşek?
            </div>
          <?php endif; ?>


          <?php if(isset($_GET['error']) && $_GET['error'] == 'needaccount'): ?>
            <div class="alert alert-danger" role="alert">
              Giriş yapman gerek!
            </div>
          <?php endif; ?>

          <?php if(isset($_GET['success']) && $_GET['success'] == 'true'): ?>
          <div class="alert alert-success" role="alert">
            Giriş başarılı yönlendiriliyorsun...
          </div>
          <?php endif; ?>
          <form action="giriscodes.php" method="POST">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Username giriniz">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Şifre</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Şifrenizi giriniz">
            </div>
            <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>