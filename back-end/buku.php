<?php
include 'koneksi.php';

header("Content-Type: application/json");
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // 🔹 Ambil semua data buku
    $result = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id_buku DESC");
    $books = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }
    echo json_encode($books);
}

elseif ($method === 'POST') {
    // 🔹 Tambah buku baru
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['nama'], $data['jenis'], $data['tanggal'])) {
        $nama = mysqli_real_escape_string($conn, $data['nama']);
        $jenis = mysqli_real_escape_string($conn, $data['jenis']);
        $tanggal = mysqli_real_escape_string($conn, $data['tanggal']);
        $gambar = isset($data['gambar']) ? mysqli_real_escape_string($conn, $data['gambar']) : '';
        $status = isset($data['status']) ? mysqli_real_escape_string($conn, $data['status']) : 'Tersedia';

        $query = "INSERT INTO buku (nama, jenis, tanggal, gambar, status) 
                  VALUES ('$nama', '$jenis', '$tanggal', '$gambar', '$status')";

        if (mysqli_query($conn, $query)) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["status" => "invalid_data"]);
    }
}

elseif ($method === 'PUT') {
    // 🔹 Edit data buku
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id'], $data['nama'], $data['jenis'], $data['tanggal'])) {
        $id = intval($data['id']);
        $nama = mysqli_real_escape_string($conn, $data['nama']);
        $jenis = mysqli_real_escape_string($conn, $data['jenis']);
        $tanggal = mysqli_real_escape_string($conn, $data['tanggal']);
        $gambar = isset($data['gambar']) ? mysqli_real_escape_string($conn, $data['gambar']) : '';
        $status = isset($data['status']) ? mysqli_real_escape_string($conn, $data['status']) : 'Tersedia';

        $query = "UPDATE buku 
                  SET nama='$nama', jenis='$jenis', tanggal='$tanggal', gambar='$gambar', status='$status' 
                  WHERE id=$id";

        if (mysqli_query($conn, $query)) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["status" => "invalid_data"]);
    }
}

elseif ($method === 'DELETE') {
    // 🔹 Hapus data buku
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id'])) {
        $id = intval($data['id']);
        $query = "DELETE FROM buku WHERE id=$id";

        if (mysqli_query($conn, $query)) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["status" => "invalid_data"]);
    }
}

else {
    echo json_encode(["status" => "unsupported_method"]);
}
?>
