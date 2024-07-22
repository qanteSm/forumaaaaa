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
                <a class="nav-link" href="profil.php">' . $username . '</a>
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
<?php echo $statusbar; ?>

<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">

<!-- Üst Menü Başlangıcı -->
<div class="container mt-3">
  <div class="row">
    <div class="col-lg-12 mb-3"> 
      <div class="d-flex align-items-end justify-content-between"> 
        <a href="tumpostlar.php" class="btn btn-primary">Tüm Postlar</a>
        <p class="text-muted mb-0">En son gönderilen 5 post listelendi</p>
      </div>
    </div>
  </div>
</div>

<!-- Üst Menü Sonu -->

<div class="container">
  <div class="row">
    <div class="col-lg-9">
      <div class="row">
  <?php
        require_once "modules/mysqlconn.php";
        $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 5";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                $ilkPost = true; 
                while ($row = $result->fetch_assoc()) {
                    $gecikenSaniye = round(time() - ($row["tarih"] / 1000));
                    $dakika = round($gecikenSaniye / 60);
                    $saat = round($dakika / 60);
                    $gun = round($saat / 24);
                    $ay = round($gun / 30);
                    $yil = round($ay / 12);

                    if ($gecikenSaniye < 60) {
                        $yayinlanmaZamani = "$gecikenSaniye saniye önce";
                    } elseif ($dakika < 60) {
                        $yayinlanmaZamani = "$dakika dakika önce";
                    } elseif ($saat < 24) {
                        $yayinlanmaZamani = "$saat saat önce";
                    } elseif ($gun < 30) {
                        $yayinlanmaZamani = "$gun gün önce";
                    } elseif ($ay < 12) {
                        $yayinlanmaZamani = "$ay ay önce";
                    } else {
                        $yayinlanmaZamani = "$yil yıl önce";
                    }
                    
                    // Kullanıcı adı sorgulaması
                    $yazarId = $row["yazar"]; // Post'un yazar ID'sini al
                    $sqlKullaniciAdi = "SELECT username FROM accounts WHERE id = ?";
                    $stmtKullaniciAdi = $conn->prepare($sqlKullaniciAdi);
                    $stmtKullaniciAdi->bind_param("i", $yazarId);
                    $stmtKullaniciAdi->execute();
                    $resultKullaniciAdi = $stmtKullaniciAdi->get_result();

                    if ($resultKullaniciAdi->num_rows > 0) {
                        $rowKullaniciAdi = $resultKullaniciAdi->fetch_assoc();
                        $username = $rowKullaniciAdi['username']; // Kullanıcı adını al
                    } else {
                        $username = "Bilinmeyen Kullanıcı"; // Kullanıcı bulunamadıysa
                    }

                    $stmtKullaniciAdi->close();

                    if ($ilkPost) {
                        echo '<div class="col-lg-12"> 
                                <div class="card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                                    <div class="row align-items-center">
                                        <div class="col-md-8 mb-3 mb-sm-0">
                                            <h5>
                                                <a href="post.php?post='.$row["id"].'" class="text-primary">' . $row["baslik"] . '</a>
                                            </h5>
                                            <div class="text-sm op-5"><a class="text-black" href="#">' . $row["icerik"] . '</a></div>
                                            <p class="text-sm"><span class="op-6">Posted</span> <a class="text-black" href="#">' . $yayinlanmaZamani . '</a> <span class="op-6">ago by</span> <a class="text-black" href="#">' . $username . '</a></p>
                                            <div class="text-sm op-5">';
                        $etiketler = explode(',', $row["etiketler"]);
                        foreach ($etiketler as $etiket) {
                            echo '<a class="text-black mr-2" href="#">  #' . trim($etiket) . '</a>';
                        }

                        echo '</div>
                                        </div>
                                        <div class="col-md-4 op-7">
                                            <div class="row text-center op-7">
                                                <div class="col px-1"> <i class="ion-connection-bars icon-1x"></i> <span class="d-block text-sm">' . $row["begeniler"] . ' Votes</span> </div>
                                                <div class="col px-1"> <i class="ion-ios-chatboxes-outline icon-1x"></i> <span class="d-block text-sm">' . $row["yorumlar"] . ' Replys</span> </div>
                                                <div class="col px-1"> <i class="ion-ios-eye-outline icon-1x"></i> <span class="d-block text-sm">' . $row["goruntulemeler"] . ' Views</span> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        $ilkPost = false; 
                    } else {
                        echo '<div class="col-lg-6">
                                <div class="card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                                    <div class="row align-items-center">
                                        <div class="col-md-8 mb-3 mb-sm-0">
                                            <h5>
                                                <a href="post.php?post='.$row["id"].'" class="text-primary">' . $row["baslik"] . '</a>
                                            </h5>
                                            <div class="text-sm op-5"><a class="text-black" href="#">' . $row["icerik"] . '</a></div>
                                            <p class="text-sm"><span class="op-6">Posted</span> <a class="text-black" href="#">' . $yayinlanmaZamani . '</a> <span class="op-6">ago by</span> <a class="text-black" href="#">' . $username . '</a></p>
                                            <div class="text-sm op-5">';
                        $etiketler = explode(',', $row["etiketler"]);
                        foreach ($etiketler as $etiket) {
                            echo '<a class="text-black mr-2" href="#">  #' . trim($etiket) . '</a>';
                        }

                        echo '</div>
                                        </div>
                                        <div class="col-md-4 op-7">
                                            <div class="row text-center op-7">
                                                <div class="col px-1"> <i class="ion-connection-bars icon-1x"></i> <span class="d-block text-sm">' . $row["begeniler"] . ' Votes</span> </div>
                                                <div class="col px-1"> <i class="ion-ios-chatboxes-outline icon-1x"></i> <span class="d-block text-sm">' . $row["yorumlar"] . ' Replys</span> </div>
                                                <div class="col px-1"> <i class="ion-ios-eye-outline icon-1x"></i> <span class="d-block text-sm">' . $row["goruntulemeler"] . ' Views</span> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }
                }
            } else {
                echo "Henüz hiç post yok.";
            }
        } else {
            echo "Hata: " . $conn->error;
        }

        $conn->close();
        ?>
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
            <div class="item">
                <div class="card mb-2">
                  <div class="card-body">
                    <h5 class="card-title">Create Post</h5>
                  <a href="postolustur.php" class="btn btn-primary w-100">Yeni Post Oluştur</a>
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