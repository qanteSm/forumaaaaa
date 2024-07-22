
<?php
session_start();

if (isset($_SESSION['entered']) && $_SESSION['entered'] === true) {
    $userId = $_SESSION['id'];

    require_once "modules/mysqlconn.php";
    $sql = "SELECT username FROM accounts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = htmlspecialchars($row['username']);
        $welcomeMessage = "Welcome, " . $username . "!";
        $statusbar = '<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Forum</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
<li class="nav-item">
                <a class="nav-link active" href="main.php">Ana Sayfa</a>
              </li>              <li class="nav-item">
                <a class="nav-link" href="modules/cikis.php">Çıkış Yap</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="kaydol.php">'.$username.'</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>';
    } else {
      session_destroy();
      header("Location: giris.php?error=error"); 
      exit();
    }

    
    
    $stmt->close();
    $conn->close();
} else {
    $statusbar = '<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Forum</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active"  href="main.php">Ana Sayfa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="giris.php">Giriş</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="kaydol.php">Kaydol</a>
        </li>
      </ul>
    </div>
  </div>
</nav>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>bs5 forum list - Bootdey.com</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
    body {
        margin-top: 20px;
        background: #eee;
        color: #708090;
    }
    .icon-1x {
        font-size: 24px !important;
    }
    a {
        text-decoration: none;
    }
    .text-primary, a.text-primary:focus, a.text-primary:hover {
        color: #00ADBB!important;
    }
    .text-black, .text-hover-black:hover {
        color: #000 !important;
    }
    .font-weight-bold {
        font-weight: 700 !important;
    }
</style>
</head>
<body>
<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">

<!-- Üst Menü Başlangıcı -->
<?php echo $statusbar; ?>
<!-- Üst Menü Sonu -->

<div class="container">
<div class="row">

<div class="col-lg-9 mb-3">
<div class="row text-left mb-5">
<div class="col-lg-6 mb-3 mb-sm-0">
<div class="dropdown bootstrap-select form-control form-control-lg bg-white bg-op-9 text-sm w-lg-50" style="width: 100%;">
<select class="form-control form-control-lg bg-white bg-op-9 text-sm w-lg-50" data-toggle="select" tabindex="-98">
<option> Categories </option>
<option> Learn </option>
<option> Share </option>
<option> Build </option>
</select>
</div>
</div>
<div class="col-lg-6 text-lg-right">
<div class="dropdown bootstrap-select form-control form-control-lg bg-white bg-op-9 ml-auto text-sm w-lg-50" style="width: 100%;">
<select class="form-control form-control-lg bg-white bg-op-9 ml-auto text-sm w-lg-50" data-toggle="select" tabindex="-98">
<option> Filter by </option>
<option> Votes </option>
<option> Replys </option>
<option> Views </option>
</select>
</div>
</div>
</div>

<div class="card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
<div class="row align-items-center">
<div class="col-md-8 mb-3 mb-sm-0">
<h5>
<a href="#" class="text-primary">Drupal 8 quick starter guide</a>
</h5>
<p class="text-sm"><span class="op-6">Posted</span> <a class="text-black" href="#">20 minutes</a> <span class="op-6">ago by</span> <a class="text-black" href="#">KenyeW</a></p>
<div class="text-sm op-5"> <a class="text-black mr-2" href="#">#C++</a> <a class="text-black mr-2" href="#">#AppStrap Theme</a> <a class="text-black mr-2" href="#">#Wordpress</a> </div>
</div>
<div class="col-md-4 op-7">
<div class="row text-center op-7">
<div class="col px-1"> <i class="ion-connection-bars icon-1x"></i> <span class="d-block text-sm">141 Votes</span> </div>
<div class="col px-1"> <i class="ion-ios-chatboxes-outline icon-1x"></i> <span class="d-block text-sm">122 Replys</span> </div>
<div class="col px-1"> <i class="ion-ios-eye-outline icon-1x"></i> <span class="d-block text-sm">290 Views</span> </div>
</div>
</div>
</div>
</div>


<div class="card row-hover pos-relative py-3 px-3 mb-3 border-primary border-top-0 border-right-0 border-bottom-0 rounded-0">
<div class="row align-items-center">
<div class="col-md-8 mb-3 mb-sm-0">
<h5>
<a href="#" class="text-primary">HELP! My Windows XP machine is down</a>
</h5>
<p class="text-sm"><span class="op-6">Posted</span> <a class="text-black" href="#">54 minutes</a> <span class="op-6">ago by</span> <a class="text-black" href="#">DanielD</a></p>
<div class="text-sm op-5"> <a class="text-black mr-2" href="#">#Development</a> <a class="text-black mr-2" href="#">#AppStrap Theme</a> </div>
</div>
<div class="col-md-4 op-7">
<div class="row text-center op-7">
<div class="col px-1"> <i class="ion-connection-bars icon-1x"></i> <span class="d-block text-sm">256 Votes</span> </div>
<div class="col px-1"> <i class="ion-ios-chatboxes-outline icon-1x"></i> <span class="d-block text-sm">251 Replys</span> </div>
<div class="col px-1"> <i class="ion-ios-eye-outline icon-1x"></i> <span class="d-block text-sm">223 Views</span> </div>
</div>
</div>
</div>
</div>


<div class="card row-hover pos-relative py-3 px-3 mb-3 border-primary border-top-0 border-right-0 border-bottom-0 rounded-0">
<div class="row align-items-center">
<div class="col-md-8 mb-3 mb-sm-0">
<h5>
<a href="#" class="text-primary">Bootstrap 4 development in record time with AppStrap Bootstrap 4 Theme</a>
</h5>
<p class="text-sm"><span class="op-6">Posted</span> <a class="text-black" href="#">32 minutes</a> <span class="op-6">ago by</span> <a class="text-black" href="#">AppStrapMaster</a></p>
<div class="text-sm op-5"> <a class="text-black mr-2" href="#">#Bootstrap 4</a> <a class="text-black mr-2" href="#">#Wordpress</a> </div>
</div>
<div class="col-md-4 op-7">
<div class="row text-center op-7">
<div class="col px-1"> <i class="ion-connection-bars icon-1x"></i> <span class="d-block text-sm">245 Votes</span> </div>
<div class="col px-1"> <i class="ion-ios-chatboxes-outline icon-1x"></i> <span class="d-block text-sm">116 Replys</span> </div>
<div class="col px-1"> <i class="ion-ios-eye-outline icon-1x"></i> <span class="d-block text-sm">257 Views</span> </div>
</div>
</div>
</div>
</div>


<div class="card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
<div class="row align-items-center">
<div class="col-md-8 mb-3 mb-sm-0">
<h5>
<a href="#" class="text-primary">Bootstrap 4 development in record time with AppStrap Bootstrap 4 Theme</a>
</h5>
<p class="text-sm"><span class="op-6">Posted</span> <a class="text-black" href="#">29 minutes</a> <span class="op-6">ago by</span> <a class="text-black" href="#">Themelize.me</a></p>
<div class="text-sm op-5"> <a class="text-black mr-2" href="#">#Android</a> <a class="text-black mr-2" href="#">#Bootstrap 4</a> <a class="text-black mr-2" href="#">#Wordpress</a> </div>
</div>
<div class="col-md-4 op-7">
<div class="row text-center op-7">
<div class="col px-1"> <i class="ion-connection-bars icon-1x"></i> <span class="d-block text-sm">317 Votes</span> </div>
<div class="col px-1"> <i class="ion-ios-chatboxes-outline icon-1x"></i> <span class="d-block text-sm">258 Replys</span> </div>
<div class="col px-1"> <i class="ion-ios-eye-outline icon-1x"></i> <span class="d-block text-sm">120 Views</span> </div>
</div>
</div>
</div>
</div>

</div>

<div class="col-lg-3 mb-4 mb-lg-0 px-lg-0 mt-lg-0">
<div data-children=".item" class="pl-lg-4">
<div class="item">
<div class="card mb-2">
<div class="card-body">
<h5 class="card-title">About</h5>
<p class="card-text">Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc.</p>
</div>
</div>
</div>
<div class="item">
<div class="card mb-2">
<div class="card-body">
<h5 class="card-title">Related</h5>
<div class="card-text">
<a href="#" class="d-block mb-2">Sapien eget</a> 
<a href="#" class="d-block mb-2">Condimentum</a>
<a href="#" class="d-block mb-2">Etiam rhoncus</a>
<a href="#" class="d-block">Sem quam</a>
</div>
</div>
</div>
</div>
<div class="item">
<div class="card mb-2">
<div class="card-body">
<h5 class="card-title">Stats</h5>
<p class="card-text"><b>Total members:</b> 983,900</p>
<p class="card-text"><b>Posts:</b> 1,290,898</p>
<p class="card-text"><b>Comments:</b> 83,123</p>
</div>
</div>
</div>
</div>
</div>

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
