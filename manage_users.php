<?php
// เชื่อมต่อฐานข้อมูล
include('db_connection.php');

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการผู้ใช้</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- เมนูแอดมิน -->
    <div class="bg-blue-500 text-white p-4">
        <h1 class="text-3xl font-bold">จัดการผู้ใช้</h1>
    </div>

    <div class="flex justify-center mt-10">
        <div class="w-4/5 bg-white p-6 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold mb-4">รายการผู้ใช้ทั้งหมด</h2>

            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="border px-4 py-2">User ID</th>
                        <th class="border px-4 py-2">ชื่อผู้ใช้</th>
                        <th class="border px-4 py-2">อีเมล</th>
                        <th class="border px-4 py-2">วันที่สมัคร</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // แสดงรายการผู้ใช้
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='border px-4 py-2'>{$row['user_id']}</td>";
                            echo "<td class='border px-4 py-2'>{$row['username']}</td>";
                            echo "<td class='border px-4 py-2'>{$row['email']}</td>";
                            echo "<td class='border px-4 py-2'>{$row['created_at']}</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='border px-4 py-2 text-center'>ไม่มีข้อมูลผู้ใช้</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>