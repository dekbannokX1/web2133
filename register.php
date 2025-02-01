<?php
// ตรวจสอบว่าได้ทำการ submit ฟอร์มแล้ว
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // เชื่อมต่อฐานข้อมูล
    $servername = "localhost"; // ปรับเป็น host ของคุณ
    $username = "root"; // ปรับเป็น username ของคุณ
    $password = ""; // ปรับเป็น password ของคุณ
    $dbname = "preorder"; // ชื่อฐานข้อมูล

    // สร้างการเชื่อมต่อ
    $conn = new mysqli($servername, $username, $password, $dbname);

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // รับค่าจากฟอร์ม
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirmPassword'];

    // ตรวจสอบการยืนยันรหัสผ่าน
    if ($pass !== $confirm_pass) {
        echo "รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน!";
        exit;
    }

    // เข้ารหัสรหัสผ่าน
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // SQL query สำหรับการเพิ่มผู้ใช้
    $sql = "INSERT INTO users (username, email, password) VALUES ('$user', '$email', '$hashed_password')";

    // ตรวจสอบการดำเนินการ
    if ($conn->query($sql) === TRUE) {
        // สมัครสมาชิกสำเร็จ
        echo "สมัครสมาชิกสำเร็จ!";
        // รีไดเร็กต์ไปที่หน้า loghtml
        header("Location: login.html");
        exit();
    } else {
        echo "เกิดข้อผิดพลาด: " . $sql . "<br>" . $conn->error;
    }

    // ปิดการเชื่อมต่อ
    $conn->close();
}
?>