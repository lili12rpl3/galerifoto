<?php
    error_reporting(0);
    include 'db.php';
	$kontak = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin WHERE admin_id = 2");
	$a = mysqli_fetch_object($kontak);
	
	$produk = mysqli_query($conn, "SELECT * FROM tb_image WHERE image_id = '".$_GET['id']."' ");
	$p = mysqli_fetch_object($produk);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>WEB Galeri Foto</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <!-- header -->
    <header>
        <div class="container">
        <h1><a href="index.php">WEB GALERI FOTO</a></h1>
        <ul>
            <li><a href="galeri.php">Galeri</a></li>
           <li><a href="registrasi.php">Registrasi</a></li>
           <li><a href="login.php">Login</a></li>
        </ul>
        </div>
    </header>
    
    <!-- search -->
    <div class="search">
        <div class="container">
            <form action="galeri.php">
                <input type="text" name="search" placeholder="Cari Foto" value="<?php echo $_GET['search'] ?>" />
                <input type="hidden" name="kat" value="<?php echo $_GET['kat'] ?>" />
                <input type="submit" name="cari" value="Cari Foto" />
            </form>
        </div>
    </div>
    
    <!-- product detail -->
    <div class="section">
        <div class="container">
             <h3>Detail Foto</h3>
            <div class="box">
                <div class="col-2">
                   <img src="foto/<?php echo $p->image ?>" width="100%" /> 
                </div>
                <div class="col-2">
                   <h3><?php echo $p->image_name ?><br />Kategori : <?php echo $p->category_name  ?></h3>
                   <h4>Nama User : <?php echo $p->admin_name ?><br />
                   Upload Pada Tanggal : <?php echo $p->date_created  ?></h4>
                   <p>Deskripsi :<br />
                        <?php echo $p->image_description ?>
                   </p>
                   
                </div>
            </div>
            <div class="col-7"> 
                   <!--suka--> 
                   <form method="POST">
                   <?php
              $qt = mysqli_query($conn, "SELECT SUM(suka) FROM tb_like WHERE image_id = '".$_GET['id']."' ");
			  if(mysqli_num_rows($qt) > 0){
				  while($q = mysqli_fetch_array($qt)){
		  			?>
                   <button name="suka" class="like">Like  <?php echo $q['SUM(suka)'] ?> </button><br />
           			<?php }}else{ ?>
              			<p>tidak ada like</p>
           			<?php } ?>
                   </form>
                   
                     <?php
                   if(isset($_POST['suka'])){
					   include 'db.php';
					   echo '<script>window.location="login.php"</script>';
				   }?><br />
                   
                   <div class="content">
                       <form action="" method="POST">
                       <input type="hidden" name="adminid" value="<?php echo $_SESSION['a_global']->admin_id ?>">
                         <textarea type="text" name="komentar" class="input-control" maxlength="300" placeholder="Tulis Komentar..." required></textarea>
                         <input type="submit" name="submit" value="Kirim" class="btn">
                       </form>
                    <?php
                   if(isset($_POST['submit'])){
					  
												echo '<script>alert("Login Terlebih Dahulu")</script>';
												echo '<script>window.location="login.php"</script>';
						}
						
					   
				   
				   ?>
					   
					   
		<br />			               
       <div class="">
       <h3>Komentar</h3>
       <br />
       <div class="">
          <?php
              $up = mysqli_query($conn, "SELECT * FROM komentar_foto WHERE image_id = '".$_GET['id']."' ORDER BY tanggal_komentar DESC ");
			  if(mysqli_num_rows($up) > 0){
				  while($u = mysqli_fetch_array($up)){
		  ?>
         
          <div class="inpu"> 
            <h4 style="color:#C00;"><?php echo $u['admin_name'] ?><br /></h4> 
              <h5> <?php echo $u['isi_komentar'] ?><br /></h5>
             <h6> <?php echo $u['tanggal_komentar']  ?></h6>
          </div>
          </a>
          <?php }}else{ ?>
              <p>komentar tidak ada</p>
          <?php } ?>
       </div>
    </div>
             
					  
                   </div>
                   
                   
                   
                </div>
				
            </div>
        </div>
    </div>
        </div>
    </div>
</body>
</html>