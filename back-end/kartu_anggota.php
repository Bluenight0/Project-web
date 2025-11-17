<?php
require('../library_fpdf/fpdf.php');
include '../back-end/koneksi.php';

if (!isset($_GET['id'])) {
    die('ID anggota tidak ditemukan.');
}

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM anggota_perpus WHERE id_anggota = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die('Data anggota tidak ditemukan.');
}

// Lokasi foto
$fotoPath = "../back-end/uploads/foto_anggota/" . ($data['foto'] ?? 'default.png');
if (!file_exists($fotoPath)) {
    $fotoPath = "../uploads/foto_anggota/default.png";
}

// Membuat PDF ukuran kartu (90x60mm)
$pdf = new FPDF('L', 'mm', array(90, 60));
$pdf->AddPage();

// Warna background
$pdf->SetFillColor(0, 100, 200);
$pdf->Rect(0, 0, 90, 60, 'F');

// Judul
$pdf->SetFont('Arial', 'B', 13);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(0, 10, 'Kartu Anggota Perpustakaan', 0, 1, 'C');

// Garis putih pemisah
$pdf->SetDrawColor(255,255,255);
$pdf->Line(10, 18, 80, 18);

// Foto anggota (pastikan path benar)
$pdf->Image($fotoPath, 10, 20, 22, 25);

// Teks identitas
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(255,255,255);
$pdf->SetXY(36, 20);
$pdf->Cell(50, 6, 'ID       : '.$data['id_anggota'], 0, 2);
$pdf->Cell(50, 6, 'Nama : '.$data['nama'], 0, 2);
$pdf->Cell(50, 6, 'Email  : '.$data['email'], 0, 2);
$pdf->Cell(50, 6, 'No HP : '.$data['no_hp'], 0, 2);
$pdf->Cell(50, 6, 'Tgl Daftar : '.$data['tanggal_daftar'], 0, 2);

// Output PDF
$pdf->Output('I', 'Kartu_'.$data['id_anggota'].'.pdf'); // gunakan 'I' dulu untuk cek
?>
