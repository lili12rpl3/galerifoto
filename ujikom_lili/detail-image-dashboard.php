<?php
// error_reporting(0);
session_start();

// Redirect to login page if user is not logged in
if (!$_SESSION['status_login']) {
    echo '<script>window.location="login.php"</script>';
    exit; // Stop further execution
}
include 'db.php';
                                  
// Fetch contact information of admin
$kontak = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin WHERE admin_id = 2");
$a = mysqli_fetch_object($kontak);

// Fetch product details
$produk = mysqli_query($conn, "SELECT * FROM tb_image WHERE image_id = '".$_GET['id']."' ");
$p = mysqli_fetch_object($produk);

// Fetch comments for the image
$komentar = mysqli_query($conn, "SELECT * FROM komentar_foto WHERE image_id = '".$_GET['id']."' ");
$com = mysqli_fetch_object($komentar);

// Fetch likes for the image
$like = mysqli_query($conn, "SELECT * FROM tb_like WHERE image_id = '".$_GET['id']."' ");
$L = mysqli_fetch_object($like);


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Galeri Foto</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<header>
    <div class="container">
        <h1><a href="dashboard.php">GALERI FOTO</a></h1>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="data-image.php">Data Foto</a></li>
            <li><a href="Keluar.php">Keluar</a></li>
        </ul>
    </div>
</header>

<div class="search">
    <div class="container">
        <form action="galeri-dash.php">
            <input type="text" name="search" placeholder="Cari Foto" value="<?= $_GET['search'] ?? '' ?>" />
            <input type="hidden" name="kat" value="<?= $_GET['kat'] ?? '' ?>" />
            <input type="submit" name="cari" value="Cari Foto" />
        </form>
    </div>
</div>

<div class="section">
    <div class="container">
        <h3>Detail Foto</h3>
        <div class="box">
            <div class="col-2">
                <img src="foto/<?php echo htmlspecialchars($p->image) ?>" width="100%" />
            </div>
            <div class="col-2">
                <h3><?php echo htmlspecialchars($p->image_name) ?></h3>
                <h4>Nama User : <?php echo htmlspecialchars($p->admin_name) ?><br />
                Upload Pada Tanggal : <?php echo htmlspecialchars($p->date_created) ?></h4>
                <p>Deskripsi :<br />
                    <?php echo htmlspecialchars($p->image_description) ?>
                </p>
            </div>
        </div>

        <div class="col-2">
            <!-------suka----->
            <form method="POST" action="">
                <input type="hidden" name="gam" value="<?php echo $p->image_id ?>">
                <input type="hidden" name="adname" value="<?php echo htmlspecialchars($_SESSION['a_global']->admin_name) ?>" required>
                <input type="hidden" name="like" />
                <!-- Like button -->
                <?php
                $qt = mysqli_query($conn, "SELECT SUM(suka) FROM tb_like WHERE image_id = '".$_GET['id']."'");
                if(mysqli_num_rows($qt) > 0){
                    while($q = mysqli_fetch_array($qt)){
                ?>
                    <button type="submit" name="suka" class="like">Like <?php echo $q['SUM(suka)'] ?> </button><br />
                <?php 
                    }
                } else { 
                ?>
                    <p>Tidak ada like</p>
                <?php } ?>
            </form>

            <!-- Comment form -->
            <form action="" method="POST">
                <input type="hidden" name="image" value="<?php echo $p->image_id ?>">
                <input type="hidden" name="adminid" value="<?php echo $_SESSION['a_global']->admin_id ?>" required >
                <input type="hidden" name="adminnm" value="<?php echo htmlspecialchars($_SESSION['a_global']->admin_name) ?>" required>
                <textarea name="komentar" class="input-control" maxlength="80" placeholder="Tulis Komentar..." required></textarea>
                <input type="submit" name="submit" value="Kirim" class="btn">
            </form>
                  
            <!-- Comments section -->
            <div class="">
                <h3>Komentar</h3>
                <div class="">
                    <?php
                    $up = mysqli_query($conn, "SELECT * FROM komentar_foto WHERE image_id = '".$_GET['id']."' ORDER BY tanggal_komentar DESC ");
                    if(mysqli_num_rows($up) > 0){
                        while($u = mysqli_fetch_array($up)){
                    ?>
                            <div class="input"> 
                                <h4><?php echo htmlspecialchars($u['admin_name']) ?><br /></h4> 
                                <h5><?php echo htmlspecialchars($u['isi_komentar']) ?><br /></h5>
                                <h6><?php echo htmlspecialchars($u['tanggal_komentar']) ?></h6>
                            </div>
                    <?php 
                        }
                    } else { 
                    ?>
                        <p>Komentar tidak ada</p>
                    <?php } ?>
                </div>
            </div>
        </div> 
    </div>
</div>
</body>
</html>

