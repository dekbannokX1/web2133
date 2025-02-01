<?php
// เริ่มต้นการใช้งาน session
session_start();

// ตรวจสอบว่าแอดมินล็อกอินหรือไม่ (ในกรณีนี้ให้แอดมินใช้ user_id = 1)
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    // ถ้ายังไม่ล็อคอินหรือไม่ใช่แอดมิน ให้ไปที่หน้า login
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เมนูแอดมิน</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- เมนูแอดมิน -->
    <div class="bg-blue-500 text-white p-4">
        <h1 class="text-3xl font-bold">เมนูแอดมิน</h1>
    </div>

    <div class="flex justify-center mt-10">
        <div class="w-2/3 bg-white p-6 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold mb-4">จัดการเว็บไซต์</h2>
            <ul class="space-y-4">
                <li>
                    <a href="manage_orders.php" class="text-blue-500 hover:underline text-lg">จัดการคำสั่งซื้อ</a>
                </li>
                <li>
                    <a href="manage_users.php" class="text-blue-500 hover:underline text-lg">จัดการผู้ใช้</a>
                </li>
                <li>
                    <a href="logout.php" class="text-red-500 hover:underline text-lg">ออกจากระบบ</a>
                </li>
            </ul>
        </div>
    </div>

</body>
</html>