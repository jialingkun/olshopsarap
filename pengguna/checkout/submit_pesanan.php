<?php 
include __DIR__.'/../../database_connect.php';
include __DIR__.'/../../config.php';

$email = $_SESSION["sesi_pengguna"]);
date_default_timezone_set('Asia/Jakarta');
$tanggal_pesanan = date('Y-m-d H:i:s');
$alamat = mysqli_real_escape_string($conn,$_POST["alamat"]);
$nama_penerima = mysqli_real_escape_string($conn,$_POST["nama_penerima"]);
$telepon_penerima = mysqli_real_escape_string($conn,$_POST["telepon_penerima"]);
$total_harga = mysqli_real_escape_string($conn,$_POST["total_harga"]);

$sql = "INSERT INTO pesanan (email, tanggal_pesanan, total_harga, alamat, nama_penerima, telepon_penerima, status) VALUES ('$email', '$tanggal_pesanan', '$total_harga', '$alamat', '$nama_penerima', '$telepon_penerima', 'menunggu pembayaran')";

$berhasil = true;
if (mysqli_query($conn, $sql)) {

	$id_pesanan = mysqli_insert_id($conn);

	if (isset($_SESSION["isi_cart"])) {
		foreach ($_SESSION["isi_cart"] as $kode_barang) {
			$jumlah = $_SESSION["jumlah"][$kode];
			$harga = $_SESSION["harga"][$kode];
			$sql = "INSERT INTO detail_pesanan (id_pesanan, kode_barang, jumlah, harga) VALUES ('$id_pesanan', '$kode_barang', '$jumlah', '$harga')";

			if (mysqli_query($conn, $sql)) {
			} else {
				echo "<div class='alert alert-danger'>Gagal memesan barang: " . $sql . "<br>" . mysqli_error($conn). "</div>";
				$berhasil = false;
			}


		}
	}

} else {
	echo "<div class='alert alert-danger'>Gagal memesan: " . $sql . "<br>" . mysqli_error($conn). "</div>";
	$berhasil = false;
}


if ($berhasil) {
	header("Location: ".$url_website."/pengguna/checkout/nota.php?id=".$id_pesanan);
	die();
}
?>