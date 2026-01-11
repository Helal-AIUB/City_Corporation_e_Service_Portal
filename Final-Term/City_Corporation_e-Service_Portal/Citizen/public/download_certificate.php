<?php
session_start();
require_once('../config/db.php');
// Ensure you have the fpdf.php file and font directory in 'Citizen/public/fpdf/'
require('fpdf/fpdf.php'); 

// 1. Security and Data Fetching (Same as before)
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    die("Access Denied");
}
$licenseId = $_GET['id'];
$userId = $_SESSION['user_id'];

$sql = "SELECT t.*, u.name, u.nid, u.address as owner_address 
        FROM trade_licenses t 
        JOIN users u ON t.user_id = u.id 
        WHERE t.id = ? AND t.user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$licenseId, $userId]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data || strtolower($data['status']) !== 'approved' || $data['payment_status'] !== 'Paid') {
    die("Certificate is not available. Please ensure the application is Approved and Paid.");
}

// 2. Date Calculations
$issueDate = date("d F, Y", strtotime($data['applied_at']));
$expiryDate = date("d F, Y", strtotime($data['applied_at'] . " + 1 year"));
$licenseNo = date("Y") . str_pad($data['id'], 6, '0', STR_PAD_LEFT);

// --- START PROFESSIONAL PDF GENERATION ---
class PDF extends FPDF {
    function Header() {
        // 1. Official Logo
        // Make sure 'logo.png' is in 'Citizen/public/uploads/'
        if(file_exists('uploads/logo.png')) {
            $this->Image('uploads/logo.png', 15, 17, 25);
        }
        
        // 2. Government Header Text
        $this->SetFont('Times', 'B', 16);
        $this->SetTextColor(0, 100, 0); // Dark Green for Government
        $this->Cell(0, 8, 'GOVERNMENT OF THE PEOPLE\'S REPUBLIC OF BANGLADESH', 0, 1, 'C');
        
        $this->SetFont('Times', 'B', 15);
        $this->SetTextColor(0, 0, 128); // Navy Blue for City Corp
        $this->Cell(0, 8, 'CITY CORPORATION', 0, 1, 'C');
        
        $this->SetFont('Times', 'I', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 5, 'Official e-Service Portal', 0, 1, 'C');
        $this->Ln(15);

        // 3. Certificate Title with Border
        $this->SetFont('Times', 'B', 20);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 14, 'TRADE LICENSE CERTIFICATE', 1, 1, 'C');
        $this->Ln(12);
    }

    function Footer() {
        $this->SetY(-25);
        $this->SetFont('Times', '', 8);
        $this->SetTextColor(100);
        $this->Cell(0, 5, 'This is a system-generated valid certificate. Verify authenticity at citycorp.gov.bd/verify.', 0, 1, 'C');
        $this->Cell(0, 5, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 25);

// 3. Draw Formal Double Border
$pdf->SetDrawColor(0, 0, 128); // Navy Blue Border
$pdf->Rect(5, 5, 200, 287, 'D');
$pdf->SetDrawColor(0, 0, 0); // Black Inner Border
$pdf->Rect(8, 8, 194, 281, 'D');

// 4. Key Details Section (Top Right)
$pdf->SetFont('Times', '', 10);
$pdf->SetXY(130, 65);
$pdf->Cell(65, 6, 'License No: ' . $licenseNo, 0, 1, 'R');
$pdf->SetXY(130, 71);
$pdf->Cell(65, 6, 'Issue Date: ' . $issueDate, 0, 1, 'R');
$pdf->SetFont('Times', 'B', 10);
$pdf->SetTextColor(192, 57, 43); // Red for Expiry
$pdf->SetXY(130, 77);
$pdf->Cell(65, 6, 'Valid Till: ' . $expiryDate, 0, 1, 'R');
$pdf->SetTextColor(0); // Reset color

$pdf->SetY(95); // Move cursor down for main content

// 5. Formal Introduction
$pdf->SetFont('Times', '', 12);
$pdf->Write(6, 'Pursuant to the authority vested under the Municipal Administration Ordinance, this Trade License is hereby granted to operate the business described below.');
$pdf->Ln(12);

// 6. Details Sections with Header Bars
$pdf->SetFillColor(230, 230, 250); // Light Lavender fill

// --- Licensee Details ---
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 8, '  LICENSEE INFORMATION', 1, 1, 'L', true);
$pdf->SetFont('Times', '', 11);

$pdf->Cell(50, 8, 'Name of Licensee:', 'L', 0);
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 8, strtoupper($data['name']), 'R', 1);
$pdf->SetFont('Times', '', 11);

$pdf->Cell(50, 8, 'National ID No:', 'L', 0);
$pdf->Cell(0, 8, $data['nid'], 'R', 1);

$pdf->Cell(50, 8, 'Registered Address:', 'LB', 0);
$pdf->Cell(0, 8, $data['owner_address'], 'RB', 1);
$pdf->Ln(8);

// --- Business Particulars ---
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 8, '  BUSINESS PARTICULARS', 1, 1, 'L', true);
$pdf->SetFont('Times', '', 11);

$pdf->Cell(50, 8, 'Trade Name:', 'L', 0);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 8, strtoupper($data['business_name']), 'R', 1);
$pdf->SetFont('Times', '', 11);

$pdf->Cell(50, 8, 'Business Type:', 'L', 0);
$pdf->Cell(0, 8, $data['business_type'], 'R', 1);

$pdf->Cell(50, 8, 'Business Address:', 'L', 0);
$pdf->Cell(0, 8, $data['business_address'], 'R', 1);

$pdf->Cell(50, 8, 'Authorized Capital:', 'LB', 0);
$pdf->Cell(0, 8, number_format($data['trade_capital'], 2) . ' BDT', 'RB', 1);
$pdf->Ln(15);

// 7. Legal Conditions & Signature Section
$pdf->SetFont('Times', 'I', 9);
$pdf->MultiCell(0, 5, "Conditions: This license must be displayed conspicuously at the business premises. It is non-transferable without prior approval. The licensee must abide by all city corporation rules and regulations. Failure to renew by the expiry date will incur penalties.");
$pdf->Ln(25);

// Official Signatures
$pdf->SetFont('Times', '', 11);
$pdf->Cell(110, 6, '', 0, 0); // Spacing
$pdf->Cell(70, 6, '__________________________', 0, 1, 'C');
$pdf->Cell(110, 6, '', 0, 0);
$pdf->Cell(70, 6, 'Authorized Licensing Officer', 0, 1, 'C');
$pdf->Cell(110, 6, '', 0, 0);
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(70, 6, 'City Corporation', 0, 1, 'C');

// Official Seal Placeholder (Visual touch)
$pdf->SetXY(135, 235);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(100, 100, 100);
$pdf->MultiCell(40, 10, "OFFICIAL\nSEAL", 1, 'C');

// Output the PDF
$pdf->Output('I', 'Trade_License_' . $licenseNo . '.pdf'); // 'I' displays in browser first
?>