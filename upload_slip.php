<?php
session_start();

// ตรวจสอบว่าผู้ใช้ได้ล็อกอินหรือไม่
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// ตรวจสอบว่าไฟล์ที่อัปโหลดมาหรือไม่
if (isset($_FILES['slip']) && $_FILES['slip']['error'] == 0) {
    // กำหนดโฟลเดอร์ที่เก็บสลิป
    $uploadDir = 'uploads/';
    $fileName = basename($_FILES['slip']['name']);
    $uploadFilePath = $uploadDir . $fileName;

    // ย้ายไฟล์ไปยังโฟลเดอร์
    if (move_uploaded_file($_FILES['slip']['tmp_name'], $uploadFilePath)) {
        // เรียกใช้ Tesseract OCR เพื่ออ่านข้อความจากภาพ
        $ocrOutput = shell_exec("tesseract $uploadFilePath -");
        
        // ประมวลผลข้อมูลจากสลิป เช่น จำนวนเงิน หรือหมายเลขบัญชี
        $paymentAmount = extractPaymentAmount($ocrOutput); // ฟังก์ชันที่ดึงข้อมูลจำนวนเงิน
        $orderId = $_GET['order_id']; // คำสั่งซื้อที่เกี่ยวข้อง

        // เชื่อมต่อกับฐานข้อมูล
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "preorder";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // ตรวจสอบคำสั่งซื้อจากฐานข้อมูล
        $query = "SELECT total_price FROM orders WHERE order_id = '$orderId'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalPrice = $row['total_price'];

            // ตรวจสอบว่าเงินที่ชำระตรงกับยอดรวม
            if ($paymentAmount == $totalPrice) {
                // อัปเดตสถานะการชำระเงิน
                $updateQuery = "UPDATE orders SET payment_status = 'paid' WHERE order_id = '$orderId'";
                if ($conn->query($updateQuery) === TRUE) {
                    echo "การชำระเงินของคุณได้รับการยืนยันแล้ว!";
                } else {
                    echo "เกิดข้อผิดพลาดในการอัปเดตสถานะคำสั่งซื้อ";
                }
            } else {
                echo "จำนวนเงินไม่ตรงกับยอดที่ต้องชำระ";
            }
        } else {
            echo "ไม่พบคำสั่งซื้อที่เกี่ยวข้อง";
        }

        // ปิดการเชื่อมต่อฐานข้อมูล
        $conn->close();
    } else {
        echo "ไม่สามารถอัปโหลดไฟล์ได้";
    }
} else {
    echo "กรุณาอัปโหลดไฟล์สลิป";
}

// ฟังก์ชันดึงข้อมูลจำนวนเงินจาก OCR output
function extractPaymentAmount($ocrText) {
    // ตัวอย่างการหาจำนวนเงินจาก OCR ขึ้นอยู่กับรูปแบบของสลิป
    if (preg_match('/\d+\.\d{2}/', $ocrText, $matches)) {
        return $matches[0]; // คืนค่าจำนวนเงินที่พบ
    }
    return 0; // ถ้าไม่พบ
}
?>