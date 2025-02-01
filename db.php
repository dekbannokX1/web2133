<?php
session_start(); // เริ่มต้น session

$host = "localhost";  // หรือใส่ชื่อเซิร์ฟเวอร์
$user = "root";       // ชื่อผู้ใช้ MySQL
$pass = "";           // รหัสผ่าน MySQL (เว้นว่างถ้าใช้ XAMPP)
$dbname = "preorder"; // ชื่อฐานข้อมูล

$conn = new mysqli($host, $user, $pass, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>