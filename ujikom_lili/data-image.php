<?php
    session_start();
	include 'db.php';
	if($_SESSION['status_login'] != true){
		echo '<script>window.location="login.php"</script>';
    }
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
        <h1><a href="dashboard.php">WEB GALERI FOTO</a></h1>
        <ul>
           <li><a href="dashboard.php">Dashboard</a></li>
           <li><a href="profil.php">Profil</a></li>
           <li><a href="data-image.php">Data Foto</a></li>
           <li><a href="Keluar.php">Keluar</a></li>
        </ul>
        </div>
    </header>
    <br>
    <br>
          
    <!-- content -->
    <div class="section">
        <div class="container">
            <h3>Data Galeri Foto</h3>
            <div class="box">
            <button style="background-color: #A52A2A; color: white; padding: 15px 25px; border: none; border-radius: 5px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; cursor: pointer;">
    <a href="tambah-image.php" style="color: inherit; text-decoration: none;">Tambah Data</a>
</button>
                <table border="1" cellspacing="0" class="table">
                    <thead>
                        <tr>
                           <th width="60px">No</th>
                           <th>Kategori</th>
                           <th>Nama User</th>
                           <th>Nama Kategori</th>
                           <th>Deskripsi</th>
                           <th>Gambar</th>
                           <th>Status</th>
                           <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
						    $no = 1;
							$user = $_SESSION['a_global']->admin_id;
                            $foto = mysqli_query($conn, "SELECT * FROM tb_image WHERE admin_id = '$user' ");
							if(mysqli_num_rows($foto) >0 ){
							while($row = mysqli_fetch_array($foto)){
						?>
                        <tr>
                           <td><?php echo $no++ ?></td>
                           <td><?php echo $row['category_name'] ?></td>
                           <td><?php echo $row['admin_name'] ?></td>
                           <td><?php echo $row['image_name'] ?></td>
                           <td><?php echo $row['image_description']?></td>
                           <td><a href="foto/<?php echo $row['image']?>" target="_blank"><img src="foto/<?php echo $row['image']?>" width="50px"></a></td>
                           <td><?php echo ($row['image_status'] == 0)? 'Tidak Aktif':'Aktif'; ?></td>
                           <td>
                           <a href="edit-image.php?id=<?php echo $row['image_id'] ?>" style="background-color: #A52A2A; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Edit</a>
                           <a href="proses-hapus.php?idp=<?php echo $row['image_id'] ?>" onclick="return confirm('Yakin Ingin Hapus ?')" style="background-color: #dc3545; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; display: inline-block;">Hapus</a>
                           </td>
                        </tr>
                        <?php }}else{ ?>
                             <tr>
                                <td colspan="8">Tidak ada data</td>
                             </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>