<?php
require("../library_fpdf/fpdf.php");
include "koneksi.php";

$id = $_GET['id'];

// Ambil data anggota
$q = mysqli_query($koneksi, "SELECT * FROM anggota_perpus WHERE id_anggota='$id'");
$data = mysqli_fetch_assoc($q);

// Cek foto profil
$folder = "uploads/foto_anggota/";
$fotoDefault = "../assets/profile-default.png";
$foto = $fotoDefault;

foreach (['jpg','jpeg','png','webp'] as $ext) {
    $path = $folder . $id . "." . $ext;
    if (file_exists($path)) {
        $foto = $path;
        break;
    }
}

$pdf = new FPDF("L", "mm", array(54, 86)); 
$pdf->AddPage();

// Background putih
$pdf->SetFillColor(255, 255, 255);
$pdf->Rect(0, 0, 86, 54, "F");

// Border tipis hitam
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.5);
$pdf->Rect(1, 1, 84, 52);

// Foto kiri
$pdf->Image($foto, 5, 10, 20, 25);

// Judul
$pdf->SetFont("Arial", "B", 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetXY(30, 5);
$pdf->Cell(50, 6, "Kartu Anggota", 0, 1);

// Nama
$pdf->SetFont("Arial", "B", 10);
$pdf->SetXY(30, 18);
$pdf->Cell(50, 5, strtoupper($data['nama']), 0, 1);

// ID
$pdf->SetFont("Arial", "", 9);
$pdf->SetXY(30, 26);
$pdf->Cell(50, 5, "ID: " . $data['id_anggota'], 0, 1);



$pdf->Output("D", "Kartu_Anggota_".$id.".pdf");
?>
