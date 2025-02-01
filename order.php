<?php
session_start();

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// เชื่อมต่อกับฐานข้อมูล MySQL
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "preorder"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// เช็คการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ราคาเสื้อ
$pricePerShirt = 550;

$orderConfirmed = false;

// หากมีการส่งคำสั่งซื้อ (submit_order)
if (isset($_POST['submit_order'])) {
    // รับข้อมูลจากฟอร์ม
    $userId = $_SESSION['user_id'];
    $size = $_POST['size'];
    $color = $_POST['color'];
    $quantity = $_POST['quantity'];
    $address = $_POST['address'];
    $fullName = $_POST['full_name'];
    $phone = $_POST['phone'];
    
    // คำนวณราคาทั้งหมด
    $totalPrice = $pricePerShirt * $quantity;

    // เตรียมการแทรกข้อมูลไปยังฐานข้อมูล
    $orderQuery = "INSERT INTO orders (user_id, size, color, quantity, total_price, address, full_name, phone, payment_status)
                   VALUES ('$userId', '$size', '$color', '$quantity', '$totalPrice', '$address', '$fullName', '$phone', 'pending')";

    // รันคำสั่ง SQL
    if ($conn->query($orderQuery) === TRUE) {
        $orderId = $conn->insert_id; 
        $orderConfirmed = true;
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกคำสั่งซื้อ: " . $conn->error;
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>พรีออเดอร์เสื้อ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // ฟังก์ชันเพื่อเปลี่ยนภาพทุกๆ 5 วินาที
        function changeShirtImage() {
            const shirtImages = [
                "https://cdn.discordapp.com/attachments/1334530893276123292/1334852846444744714/544714405636473057.jpg?ex=679eb2d6&is=679d6156&hm=b0a860e565231a2b114e8b4c73e1d53bbd39aebabe4ad246b3bad82dee7ea51b&", // รูปที่ 1
                "https://cdn.discordapp.com/attachments/1334530893276123292/1335059198467248200/back2.jpg?ex=679eca45&is=679d78c5&hm=3b7a7af170e652bd6bdf19b911c4ee6637fc712cfb9057acd42963d29ed6c5ab&g", // รูปที่ 2
                "https://cdn.discordapp.com/attachments/1334530893276123292/1335059198807117967/back3.jpg?ex=679eca45&is=679d78c5&hm=c88e85c2bf267ad8e16b732082a154266975509c587bcd55887fd4e880d9963f&" // รูปที่ 3
            ];

            let currentIndex = 0;

            // เปลี่ยนภาพแรกทันทีที่โหลดหน้า
            document.getElementById("shirtImage").src = shirtImages[currentIndex];

            // ฟังก์ชันที่จะเปลี่ยนภาพทุกๆ 5 วินาที
            setInterval(function() {
                currentIndex = (currentIndex + 1) % shirtImages.length;  // เปลี่ยนไปที่รูปถัดไปในลิสต์
                document.getElementById("shirtImage").src = shirtImages[currentIndex]; // เปลี่ยนแหล่งของรูปภาพ
            }, 5000); // 5000 มิลลิวินาที = 5 วินาที
        }

        // ฟังก์ชันแสดงป็อปอัพ
        function showPopup() {
            const popup = document.getElementById('popup');
            popup.classList.remove('hidden');
            setTimeout(() => {
                popup.classList.add('hidden');
                localStorage.clear(); // เคลียร์ข้อมูลที่เก็บไว้ใน localStorage หลังจากแสดงป็อปอัพ
                window.location.reload(); // รีเฟรชหน้าใหม่เพื่อให้ข้อมูลหายไป
            }, 5000); // ซ่อนหลังจาก 5 วินาที
        }

        window.onload = () => {
            changeShirtImage();
            loadFormValues(); // โหลดค่าจาก localStorage
        };

        // ฟังก์ชันเพื่อเก็บข้อมูลใน localStorage
        function storeFormValues() {
            localStorage.setItem('size', document.querySelector('[name="size"]').value);
            localStorage.setItem('color', document.querySelector('[name="color"]').value);
            localStorage.setItem('quantity', document.querySelector('[name="quantity"]').value);
            localStorage.setItem('address', document.querySelector('[name="address"]').value);
            localStorage.setItem('full_name', document.querySelector('[name="full_name"]').value);
            localStorage.setItem('phone', document.querySelector('[name="phone"]').value);
        }

        // ฟังก์ชันเพื่อโหลดข้อมูลจาก localStorage (ถ้ามี)
        function loadFormValues() {
            if (localStorage.getItem('size')) {
                document.querySelector('[name="size"]').value = localStorage.getItem('size');
            }
            if (localStorage.getItem('color')) {
                document.querySelector('[name="color"]').value = localStorage.getItem('color');
            }
            if (localStorage.getItem('quantity')) {
                document.querySelector('[name="quantity"]').value = localStorage.getItem('quantity');
            }
            if (localStorage.getItem('address')) {
                document.querySelector('[name="address"]').value = localStorage.getItem('address');
            }
            if (localStorage.getItem('full_name')) {
                document.querySelector('[name="full_name"]').value = localStorage.getItem('full_name');
            }
            if (localStorage.getItem('phone')) {
                document.querySelector('[name="phone"]').value = localStorage.getItem('phone');
            }
        }
    </script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <!-- ป็อปอัพ -->
    <?php if (isset($orderConfirmed) && $orderConfirmed): ?>
        <div id="popup" class="fixed top-1/4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white p-4 rounded-lg shadow-lg transition-all duration-300 hidden">
            คำสั่งซื้อของคุณได้รับการยืนยัน! กรุณาสแกน QR Code เพื่อทำการชำระเงิน
        </div>
        <script>
            showPopup(); // เรียกฟังก์ชันแสดงป็อปอัพเมื่อคำสั่งซื้อสำเร็จ
        </script>
    <?php endif; ?>

    <div class="bg-white p-6 rounded-xl shadow-lg w-96">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">พรีออเดอร์เสื้อ</h1>

        <!-- รูปภาพเสื้อ -->
        <img id="shirtImage" src="https://cdn.discordapp.com/attachments/1334530893276123292/1334852846444744714/544714405636473057.jpg" alt="เสื้อ" class="w-full my-4 rounded-md">

        <!-- ฟอร์มกรอกข้อมูล -->
        <form method="POST" action="" enctype="multipart/form-data" onsubmit="storeFormValues()">
            <!-- เลือกไซส์ -->
            <div class="mb-4">
                <label class="block text-gray-600">เลือกไซส์:</label>
                <select name="size" class="w-full p-2 border rounded mt-1" required>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                </select>
            </div>

            <!-- เลือกสี -->
            <div class="mb-4">
                <label class="block text-gray-600">เลือกสี:</label>
                <select name="color" class="w-full p-2 border rounded mt-1" required>
                    <option value="black">ดำ</option>
                </select>
            </div>

            <!-- จำนวนเสื้อ -->
            <div class="mb-4">
                <label class="block text-gray-600">จำนวน:</label>
                <input type="number" id="quantity" name="quantity" value="1" min="1" class="w-full p-2 border rounded mt-1" required onchange="calculateTotalPrice()">
            </div>

            <!-- ราคา -->
            <div class="mb-4">
                <span id="totalPrice" class="text-lg font-bold text-gray-700">ราคา: 550 บาท</span>
            </div>

            <!-- ที่อยู่ -->
            <div class="mb-4">
                <label class="block text-gray-600">ที่อยู่:</label>
                <textarea name="address" rows="3" class="w-full p-2 border rounded mt-1" placeholder="กรอกที่อยู่ของคุณ" required></textarea>
            </div>

            <!-- ชื่อ-นามสกุล -->
            <div class="mb-4">
                <label class="block text-gray-600">ชื่อ-นามสกุล:</label>
                <input type="text" name="full_name" class="w-full p-2 border rounded mt-1" placeholder="กรอกชื่อและนามสกุล" required>
            </div>

            <!-- เบอร์โทรศัพท์ -->
            <div class="mb-4">
                <label class="block text-gray-600">เบอร์โทรศัพท์:</label>
                <input type="tel" name="phone" class="w-full p-2 border rounded mt-1" placeholder="กรอกเบอร์โทรศัพท์" required>
            </div>

            <!-- ปุ่มสั่งซื้อ -->
            <button type="submit" name="submit_order" class="bg-blue-500 text-white py-2 px-4 rounded-lg w-full hover:bg-blue-600">
                สั่งซื้อ
            </button>
        </form>

        <!-- ปุ่มกลับไปหน้า index.html -->
        <a href="index.html" class="mt-4 inline-block bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600">
            กลับสู่หน้าแรก
        </a>

        <!-- QR Code สำหรับการชำระเงิน -->
        <?php if (isset($orderId)): ?>
            <div id="qrCodeDiv" class="mt-4">
                <p>กรุณาสแกน QR Code นี้เพื่อทำการชำระเงิน</p>
                <img src="https://cdn.discordapp.com/attachments/1334530893276123292/1334863420696170638/image.png?ex=679e13f0&is=679cc270&hm=0a93aff1bc826704808bd56edb84cc2d7eccc76f9745d08124f4acde6f298dfb&=<?php echo $orderId; ?>" alt="QR Code" class="w-full">
            </div>

            <!-- ฟอร์มอัปโหลดสลิป -->
            <div class="mt-4">
                <form method="POST" action="upload_slip.php" enctype="multipart/form-data">
                    <label class="block text-gray-600">อัปโหลดสลิปการโอนเงิน:</label>
                    <input type="file" name="slip" class="w-full p-2 border rounded mt-1" required>
                    <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-lg w-full mt-2">อัปโหลดสลิป</button>
                </form>
            </div>
        <?php endif; ?>

    </div>

</body>
</html>