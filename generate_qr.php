<?php
require 'vendor/autoload.php'; // ถ้าคุณใช้ Composer ในการติดตั้ง

use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;

// ตรวจสอบว่ามีการส่งค่าจำนวนเงินมาหรือไม่
if (isset($_GET['amount'])) {
    $amount = $_GET['amount'];

    // กำหนดข้อมูลที่จะแสดงใน QR Code (ในกรณีนี้เป็นข้อมูลสำหรับการชำระเงิน PromptPay)
    $phoneNumber = '0951943403'; // เบอร์ PromptPay หรือหมายเลขบัญชีของเจ้าของเว็บไซต์
    $paymentData = "00020101021129370016A00000067701011126370016" . $phoneNumber . "52040000" . $amount . "6304";  // ข้อมูลการชำระเงิน PromptPay ในรูปแบบของ QR Code

    // สร้าง QR Code สำหรับข้อมูลการชำระเงิน
    $qrCode = new QrCode($paymentData);
    $qrCode->setSize(300);  // กำหนดขนาดของ QR Code
    $qrCode->setMargin(10); // กำหนดขอบของ QR Code
    $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH); // กำหนดระดับการแก้ไขข้อผิดพลาด

    // สร้าง Writer เพื่อเขียน QR Code ออกเป็นรูปภาพ
    $writer = new PngWriter();

    // ส่งออก QR Code ในรูปแบบของ PNG
    header('Content-Type: image/png');
    echo $writer->writeString($qrCode);
} else {
    echo "550";
}
?>