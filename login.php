<?php
require 'db.php'; // เชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);  // ใช้ชื่อผู้ใช้แทนอีเมล
    $password = $_POST["password"];

    // ตรวจสอบชื่อผู้ใช้ในฐานข้อมูล
    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);  // ค้นหาตามชื่อผู้ใช้
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $usernameFromDb, $hashedPassword);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        // ตรวจสอบรหัสผ่าน
        if (password_verify($password, $hashedPassword)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $usernameFromDb;

            echo "ล็อกอินสำเร็จ! ยินดีต้อนรับ $usernameFromDb";
            
            // ไปที่หน้า index.php หรือหน้าหลัก
            header("Location: index.php");
            exit();
        } else {
            echo "รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        echo "ไม่พบชื่อผู้ใช้นี้ในระบบ";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* กำหนดการเคลื่อนไหวของโลโก้ */
        @keyframes bounceLogo {
            0% {
                transform: translate(-50%, 100px);
            }
            50% {
                transform: translate(-50%, -20px);
            }
            100% {
                transform: translate(-50%, 0);
            }
        }

        .logo {
            animation: bounceLogo 1s ease-out;
        }
    </style>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <!-- โลโก้ -->
    <div class="absolute top-6 left-1/2 transform -translate-x-1/2">
        <img src="logo.png" alt="โลโก้ร้าน" class="w-32 h-32 object-cover rounded-full">
    </div>

    <div class="bg-white p-8 rounded-xl shadow-lg w-96">
        <h1 class="text-3xl font-bold text-center text-gray-700 mb-6">เข้าสู่ระบบ</h1>

        <form action="login.php" method="POST">
            <div class="mb-4">
                <label class="block text-gray-600">ชื่อผู้ใช้:</label>  <!-- เปลี่ยนจากอีเมลเป็นชื่อผู้ใช้ -->
                <input type="text" name="username" required class="w-full p-3 border rounded">  <!-- เปลี่ยนเป็น input สำหรับ username -->
            </div>

            <div class="mb-4">
                <label class="block text-gray-600">รหัสผ่าน:</label>
                <input type="password" name="password" required class="w-full p-3 border rounded">
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600">
                เข้าสู่ระบบ
            </button>
        </form>

        <div class="mt-4 text-center">
            <p class="text-gray-600">ยังไม่มีบัญชี? <a href="register.html" class="text-blue-500 hover:underline">สมัครสมาชิก</a></p>
        </div>
    </div>

</body>
</html>