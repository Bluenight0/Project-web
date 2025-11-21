<?php
header("Content-Type: application/json");
session_start();
include "koneksi.php";

// Pastikan user login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status"=>"error","message"=>"User belum login"]);
    exit;
}

$user_id = intval($_SESSION['user_id']);
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);

switch($method){
    case 'POST':
        $event_id = intval($input['event_id']);

        // Cek apakah user sudah ikut event
        $cek = $conn->query("SELECT id FROM peserta_event WHERE event_id=$event_id AND user_id=$user_id");
        if($cek && $cek->num_rows > 0){
            echo json_encode(["status"=>"exists"]);
            exit;
        }

        $sql = "INSERT INTO peserta_event (event_id, user_id) VALUES ($event_id, $user_id)";
        if($conn->query($sql)){
            echo json_encode(["status"=>"success"]);
        } else {
            echo json_encode(["status"=>"error","message"=>$conn->error]);
        }
    break;

    case 'DELETE':
        $event_id = intval($input['event_id']);
        $sql = "DELETE FROM peserta_event WHERE event_id=$event_id AND user_id=$user_id";
        if($conn->query($sql)){
            echo json_encode(["status"=>"success"]);
        } else {
            echo json_encode(["status"=>"error","message"=>$conn->error]);
        }
    break;

    default:
        echo json_encode(["status"=>"error","message"=>"Method not allowed"]);
    break;
}
?>
