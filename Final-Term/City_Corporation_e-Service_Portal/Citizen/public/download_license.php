<?php
// File: Citizen/public/download_license.php

// 1. Load Database & FPDF
require_once '../config/db.php';
// Ensure this path to fpdf.php is correct for your setup
require('fpdf/fpdf.php'); 

session_start();

// 2. Security Checks
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    die("Access Denied.");
}

$licenseId = $_GET['id'];
$userId = $_SESSION['user_id'];

// 3. Fetch License Data (Must be Approved and belong to user)
$sql = "SELECT t.*, u.name as owner_name, u.nid 
        FROM trade_licenses t 
        JOIN users u ON t.user_id = u.id 
        WHERE t.id = ? AND t.user_id = ? AND t.status = 'approved'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $licenseId, $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Certificate not found or unavailable.");
}

$data = $result->fetch_assoc();

// Calculate Dates
$issueDate = date('d F, Y');
// Validity: 1 year from today
$validUntil = date('d F, Y', strtotime('+1 year')); 


// 4. Define Custom PDF Class for Header/Footer
class PDF extends FPDF {
    function Header() {
        // -- Borders --
        $this->SetDrawColor(20, 70, 120); // Dark Corporate Blue
        $this->SetLineWidth(3);
        $this->Rect(5, 5, 200, 287); // Outer thick border
        $this->SetLineWidth(0.5);
        $this->Rect(8, 8, 194, 281); // Inner thin border

        // -- LOGOS --
        // IMPORTANT: 'gov_logo.png' and 'dcc_logo.png' must be in Citizen/public/ folder
        if(file_exists('gov_logo.png')) {
             // Image(file, x, y, width)
             $this->Image('gov_logo.png', 15, 15, 22); // Left Logo (Govt)
        }
        if(file_exists('dcc_logo.png')) {
             $this->Image('dcc_logo.png', 173, 15, 22); // Right Logo (DCC)
        }

        // -- Header Text Center --
        $this->SetY(18);
        $this->SetFont('Times', '', 10);
        $this->Cell(0, 5, "Government of the People's Republic of Bangladesh", 0, 1, 'C');
        
        $this->Ln(2);
        $this->SetFont('Arial', 'B', 24);
        $this->SetTextColor(20, 70, 120); // Dark Blue
        $this->Cell(0, 10, 'DHAKA CITY CORPORATION', 0, 1, 'C');
        
        $this->Ln(2);
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(100, 100, 100); // Dark Gray
        $this->Cell(0, 10, 'TRADE LICENSE CERTIFICATE', 0, 1, 'C');
        
        // Decorative line below header
        $this->Ln(10);
        $this->SetDrawColor(20, 70, 120);
        $this->SetLineWidth(1);
        $this->Line(30, $this->GetY(), 180, $this->GetY());
        $this->Ln(10);
    }

    function Footer() {
        // Move up higher to fit the signature box
        $this->SetY(-65);
        
        // --- SIGNATURE SECTION ---
        $this->SetTextColor(0); // Reset to black
        
        // 1. The "Sign" (Using Times Italic to simulate a signature)
        $this->SetFont('Times', 'I', 26); // Large Italic font
        $this->Cell(110); // Indent right
        $this->Cell(70, 15, 'Helal', 0, 1, 'C'); // The simulated signature text

        // 2. The Signature Line
        $this->Cell(110);
        $this->Cell(70, 0, '', 'T', 1, 'C'); // 'T' draws Top border acting as line

        // 3. The Titles
        $this->SetFont('Arial', 'B', 12); // Bold for title
        $this->Cell(110);
        $this->Cell(70, 8, 'Chairman', 0, 1, 'C');

        $this->SetFont('Arial', '', 11); // Normal for organization
        $this->Cell(110);
        $this->Cell(70, 5, 'Dhaka City Corporation', 0, 1, 'C');

        // Bottom Disclaimer
        $this->SetY(-20);
        $this->SetFont('Arial', 'I', 9);
        $this->SetTextColor(150);
        $this->Cell(0, 10, 'This is a digitally generated certificate. Verify authenticity at dcc.gov.bd', 0, 0, 'C');
    }
}

// 5. Instantiate and Build Page
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetTextColor(0);

// --- SECTION: Key License Information (3-Column Layout) ---
$pdf->SetY(75); // Adjusted Y position slightly down
$pdf->SetFillColor(240, 245, 255); // Very pale blue bg for headers

// Row 1: Headers
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(15); // indent
$pdf->Cell(55, 8, 'License ID No.', 1, 0, 'C', true);
$pdf->Cell(55, 8, 'Issue Date', 1, 0, 'C', true);
$pdf->Cell(55, 8, 'Valid Until', 1, 1, 'C', true);

// Row 2: Data
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(15); // indent
// Pad ID with zeros (e.g., DCC-000045)
$licenseNum = 'DCC-' . str_pad($data['id'], 6, '0', STR_PAD_LEFT);
$pdf->Cell(55, 12, $licenseNum, 1, 0, 'C');
$pdf->Cell(55, 12, $issueDate, 1, 0, 'C');
$pdf->Cell(55, 12, $validUntil, 1, 1, 'C');

$pdf->Ln(15);

// --- SECTION: Main Business Details Box ---
// Introduction text
$pdf->SetFont('Times', '', 12);
$pdf->Write(6, "This is to certify that the following business has been granted permission to operate within the jurisdiction of Dhaka City Corporation, subject to the laws and regulations currently in force.");
$pdf->Ln(15);

// Details Box styling
$pdf->SetFillColor(252, 250, 245); // Off-white paper look
$pdf->SetDrawColor(200); // Light gray border
$boxX = 20;
$boxY = $pdf->GetY();
$pdf->Rect($boxX, $boxY, 170, 85, 'DF');

$pdf->SetXY($boxX + 5, $boxY + 5);

// Label width standard
$labelW = 45;

// 1. Business Name
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell($labelW, 10, 'Business Name:', 0, 0);
$pdf->SetFont('Arial', 'B', 14); // Larger font for name
$pdf->Cell(0, 10, $data['business_name'], 0, 1);

// 2. Owner Name
$pdf->SetX($boxX + 5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell($labelW, 10, 'Proprietor Name:', 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $data['owner_name'], 0, 1);

// 3. NID
$pdf->SetX($boxX + 5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell($labelW, 10, 'Owner NID:', 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $data['nid'], 0, 1);

// 4. Business Type
$pdf->SetX($boxX + 5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell($labelW, 10, 'Nature of Business:', 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $data['business_type'], 0, 1);

// 5. Address (MultiCell for wrapping)
$pdf->SetX($boxX + 5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell($labelW, 10, 'Registered Address:', 0, 0);
$pdf->SetFont('Arial', '', 12);
$currentY = $pdf->GetY();
$pdf->SetXY($boxX + 5 + $labelW, $currentY + 2); 
$pdf->MultiCell(115, 6, $data['business_address']);

// --- Final Status Seal ---
// Moved slightly higher to avoid clashing with signature
$pdf->SetY(225); 
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(39, 174, 96); // Green Color
// Draw a rounded box for status
// $pdf->SetDrawColor(39, 174, 96);
// $pdf->SetLineWidth(2);
// $pdf->Rect(75, 222, 60, 15, 'D');
// $pdf->Cell(0, 10, 'APPROVED', 0, 1, 'C');


// 6. Output File
$filename = 'TradeLicense_' . $licenseNum . '.pdf';
$pdf->Output('D', $filename); // Force download
?>