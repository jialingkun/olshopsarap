<?php 
include __DIR__.'/../redirect_login.php';
include __DIR__.'/../../config.php';
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
		include __DIR__.'/submit_pesanan.php';
	}
	?>	
	<a href="../index.php">Kembali ke Dashboard</a>
	<br>
	<h1>Keranjang Belanja</h1>
	<?php 
	if (isset($_SESSION["isi_cart"])) {
		$total_semua = 0;
		?>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Nama</th>
					<th>Harga</th>
					<th>Jumlah</th>
					<th>Total</th>
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
					</tr>
					<?php
				}
				?>

			</tbody>
		</table>

		<h4>Total Harga: <?php echo $total_semua?></h4>

		
		<form action="" method="POST">
			
			alamat pengiriman: <input type="text" name="alamat">
			<br>
			nama penerima: <input type="text" name="nama_penerima">
			<br>
			telepon penerima: <input type="text" name="telepon_penerima">
			<br>


			<input type="submit" name="submit" value="Pesan Sekarang" onclick="return confirm('Memesan barang-barang ini?')">
			<input type="hidden" name="total_harga" value="<?php echo $total_semua ?>">
		</form>
		<?php 
	} 
	?>
</body>
</html>