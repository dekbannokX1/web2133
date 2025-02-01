<?php
// เชื่อมต่อกับฐานข้อมูล MySQL
$servername = "localhost";
$username = "root"; // ชื่อผู้ใช้ฐานข้อมูล
$password = ""; // รหัสผ่านฐานข้อมูล
$dbname = "preorder"; // ชื่อฐานข้อมูลของคุณ

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตัวอย่างคำสั่ง SQL
$sql = "SELECT * FROM orders"; // เลือกข้อมูลทั้งหมดจากตาราง orders
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการคำสั่งซื้อ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-center text-gray-800 mb-8">รายการคำสั่งซื้อ</h1>

        <?php
        if ($result->num_rows > 0) {
            // แสดงข้อมูลคำสั่งซื้อ
            while($row = $result->fetch_assoc()) {
        ?>

        <div class="bg-white p-4 rounded-lg shadow-lg mb-4">
            <h2 class="text-xl font-bold text-gray-700">Order ID: <?php echo $row["order_id"]; ?></h2>
            <p class="text-gray-600">Size: <?php echo $row["size"]; ?></p>
            <p class="text-gray-600">Color: <?php echo $row["color"]; ?></p>
            <p class="text-gray-600">Full Name: <?php echo $row["full_name"]; ?></p>
            <p class="text-gray-600">Phone: <?php echo $row["phone"]; ?></p>
            <p class="text-gray-600">Order Time: <?php echo date("Y-m-d H:i:s", strtotime($row["order_time"])); ?></p>
        </div>

        <?php
            }
        } else {
            echo "<p class='text-center text-gray-500'>ไม่มีคำสั่งซื้อ</p>";
        }
        ?>

    </div>

</body>
</html>

<?php
// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>