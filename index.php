<?php 
session_start();
include __DIR__.'/config.php';
include __DIR__.'/database_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Dashboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
	<?php 
	if(isset($_POST['submit'])) {
		include __DIR__.'/input_cart.php';
	}


	if(isset($_SESSION["sesi_pengguna"])){
		?>	
		<a href="pengguna/index.php">Dashboard</a>
		<br>
		<a href="pengguna/checkout/index.php">Transaksi</a>
		<br>
		<?php 
	}else{
		?>	
		<a href="pengguna/login/index.php">Login</a>
		<br>
		<a href="pengguna/registrasi/index.php">Registrasi</a>
		<br>
		<?php 
	}
	?>

	<h1>Keranjang Belanja</h1>
	<?php 
	if (isset($_SESSION["isi_cart"])) {
		$total_semua = 0;
		?>
		<form action="index.php?aksi=bersihkan" method="POST">
			<input type="submit" name="submit" value="Bersihkan Keranjang belanja" onclick="return confirm('Membersihkan keranjang belanja?')">
		</form> 
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Nama</th>
					<th>Harga</th>
					<th>Jumlah</th>
					<th>Total</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($_SESSION["isi_cart"] as $kode) {
					$total = $_SESSION["harga"][$kode]*$_SESSION["jumlah"][$kode];
					$total_semua = $total_semua + $total;
					?>
					<tr>
						<td><?php echo $_SESSION["nama_barang"][$kode] ?></td>
						<td><?php echo $_SESSION["harga"][$kode] ?></td>
						<td><?php echo $_SESSION["jumlah"][$kode] ?></td>
						<td><?php echo $total ?></td>
						<td> 
							<form action="index.php?aksi=hapus" method="POST">
								<input type="submit" name="submit" value="Hapus" onclick="return confirm('Menghapus barang ini?')"> 
								<input type="hidden" name="kode_barang" value="<?php echo $kode ?>"> 
							</form> 
						</td>
					</tr>
					<?php
				}
				?>

			</tbody>
		</table>

		<h4>Total Harga: <?php echo $total_semua?></h4>
		<button><a href="pengguna/checkout/index.php">CHECK OUT</a></button>
		<?php 
	} 
	?>


	<h1>Katalog</h1>
	<?php 
	$result = mysqli_query($conn, "SELECT * FROM barang NATURAL JOIN kategori_produk");
	while($row = mysqli_fetch_assoc($result)) {
		?>
		<div>
			<div><?php echo $row['kode_barang'] ?> </div>
			<div><?php echo $row['nama_barang'] ?> </div>
			<div><?php echo $row['nama_kategori'] ?> </div>
			<div><?php echo $row['harga'] ?> </div>
			<div><?php echo $row['stok'] ?> </div>
			<div><img src="<?php echo $url_website ?>/admin/barang/gambar/<?php echo $row['kode_barang'] ?>.png?nocache=<?php echo time(); ?>" width="200px" alt="Tidak ada gambar" /></div>
			<div>
				<form action="index.php?aksi=tambah" method="POST">
					Jumlah: <input type="number" name="jumlah" value="1">
					<input type="submit" name="submit" value="Tambahkan ke Keranjang"> 
					<input type="hidden" name="kode_barang" value="<?php echo $row['kode_barang'] ?>"> 
					<input type="hidden" name="nama_barang" value="<?php echo $row['nama_barang'] ?>"> 
					<input type="hidden" name="harga" value="<?php echo $row['harga'] ?>"> 
				</form>
			</div> 
		</div>
		<?php
	}
	?>


</body>
</html>