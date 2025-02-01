<?php
session_start(); // เริ่มต้นเซสชัน

// ตรวจสอบว่า role หรือ user_id มีอยู่หรือไม่
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'user'; // กำหนด default เป็น 'user' หากไม่พบเซสชัน
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // กำหนด default เป็น null หากไม่พบเซสชัน
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าแรก - พรีออเดอร์เสื้อ</title>
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

        /* กำหนดภาพพื้นหลัง */
        .background {
            background-size: contain;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            transition: background-image 1s ease-in-out;
        }

        /* กำหนดกรอบสำหรับข้อความและปุ่ม */
        .content-box {
            background: rgb(255, 255, 255); /* สีขาวโปร่งแสง */
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0px 4px 10px rgb(255, 255, 255);
        }
    </style>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="background absolute inset-0" id="backgroundContainer"></div>

    <!-- โลโก้ -->
    <div class="absolute top-24 left-1/2 transform -translate-x-1/2 logo">
        <img src="real.png" alt="โลโก้ร้าน" class="w-80 h-80 object-cover rounded-full">
    </div>

    <!-- กรอบข้อความและปุ่ม -->
    <div class="relative content-box text-center z-10">
        <h1 class="text-2xl font-bold text-white-700 mb-4">ยินดีต้อนรับสู่ DEKBANNOK CLOTHING 😁</h1>
        <p class="text-white-600 mb-6">กดปุ่มด้านล่างเพื่อไปหน้าพรีออเดอร์เสื้อ</p>

        <a href="order.html" class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600">
            ไปหน้าพรีออเดอร์เสื้อ
        </a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="mt-6 block bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">
                ออกจากระบบ
            </a>
        <?php endif; ?>

        <?php if ($user_id == 1): ?>
            <a href="admin.php" class="mt-4 block bg-green-500 text-white py-2 px-6 rounded-lg hover:bg-green-600">
                เข้าสู่ระบบผู้ดูแล
            </a>
        <?php endif; ?>
    </div>

    <script>
        const backgrounds = [
            'url("back1.jpg")',
            'url("back2.jpg")',
        ];

        let currentIndex = 0;
        const backgroundContainer = document.getElementById('backgroundContainer');

        // ตั้งค่าภาพพื้นหลังเริ่มต้น
        backgroundContainer.style.backgroundImage = backgrounds[currentIndex];

        setInterval(() => {
            currentIndex = (currentIndex + 1) % backgrounds.length;
            backgroundContainer.style.backgroundImage = backgrounds[currentIndex];
        }, 2000); // เปลี่ยนทุก 0.5 วินาที
    </script>

</body>
</html>