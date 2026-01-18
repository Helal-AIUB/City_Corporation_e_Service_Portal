<?php
// File: models/CitizenModel.php

class CitizenModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    // =========================================================
    // 1. PROFILE MANAGEMENT
    // =========================================================

    public function getProfile($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateInfo($id, $nid, $phone, $address, $photo) {
        if ($photo) {
            $sql = "UPDATE users SET nid=?, phone=?, address=?, profile_pic=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssssi", $nid, $phone, $address, $photo, $id);
        } else {
            $sql = "UPDATE users SET nid=?, phone=?, address=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssi", $nid, $phone, $address, $id);
        }
        return $stmt->execute();
    }

    // =========================================================
    // 2. TRADE LICENSE SECTION
    // =========================================================

    public function createTradeLicense($userId, $bName, $bType, $bAddress, $capital) {
        $sql = "INSERT INTO trade_licenses 
                (user_id, business_name, business_type, business_address, trade_capital, fee_amount, payment_status, status) 
                VALUES (?, ?, ?, ?, ?, 500.00, 'Unpaid', 'pending')";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("issss", $userId, $bName, $bType, $bAddress, $capital);
        
        return $stmt->execute();
    }

    public function getMyTradeLicenses($userId) {
        $sql = "SELECT * FROM trade_licenses WHERE user_id = ? ORDER BY applied_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // =========================================================
    // 3. NID CORRECTION SECTION
    // =========================================================

    public function createNidCorrection($userId, $currentNid, $correctionType, $details) {
        $sql = "INSERT INTO nid_corrections 
                (user_id, current_nid, correction_type, details, fee_amount, payment_status, status) 
                VALUES (?, ?, ?, ?, 200.00, 'Unpaid', 'pending')";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("isss", $userId, $currentNid, $correctionType, $details);
        return $stmt->execute();
    }

    public function getMyNidApplications($userId) {
        $sql = "SELECT * FROM nid_corrections WHERE user_id = ? ORDER BY applied_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // =========================================================
    // 4. BILLING & PAYMENT SECTION (FIXED)
    // =========================================================

    public function getUnpaidBills($userId) {
        $bills = [];

        // 1. Trade License
        $sql1 = "SELECT id, 'Trade License' as service_type, fee_amount, applied_at FROM trade_licenses WHERE user_id = ? AND payment_status = 'Unpaid'";
        $stmt1 = $this->db->prepare($sql1);
        $stmt1->bind_param("i", $userId);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        while ($row = $result1->fetch_assoc()) { $bills[] = $row; }

        // 2. NID Correction
        $sql2 = "SELECT id, 'NID Correction' as service_type, fee_amount, applied_at FROM nid_corrections WHERE user_id = ? AND payment_status = 'Unpaid'";
        $stmt2 = $this->db->prepare($sql2);
        $stmt2->bind_param("i", $userId);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        while ($row = $result2->fetch_assoc()) { $bills[] = $row; }

        // 3. Water Connection (NEW)
        $sql3 = "SELECT id, 'Water Connection' as service_type, fee_amount, applied_at FROM water_connections WHERE user_id = ? AND payment_status = 'Unpaid'";
        $stmt3 = $this->db->prepare($sql3);
        $stmt3->bind_param("i", $userId);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        while ($row = $result3->fetch_assoc()) { $bills[] = $row; }

        return $bills;
    }

    public function processPayment($serviceType, $id, $method, $trxId) {
        if ($serviceType === 'Trade License') {
            $sql = "UPDATE trade_licenses SET payment_status='Paid', payment_method=?, trx_id=? WHERE id=?";
        } elseif ($serviceType === 'NID Correction') {
            $sql = "UPDATE nid_corrections SET payment_status='Paid', payment_method=?, trx_id=? WHERE id=?";
        } elseif ($serviceType === 'Water Connection') { // NEW
            $sql = "UPDATE water_connections SET payment_status='Paid', payment_method=?, trx_id=? WHERE id=?";
        } else {
            return false;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssi", $method, $trxId, $id);
        return $stmt->execute();
    }

    // --- WATER CONNECTION ---
    public function createWaterConnection($userId, $type, $holding, $zone, $pipe, $address, $fee) {
        $sql = "INSERT INTO water_connections 
                (user_id, connection_type, holding_no, zone, pipe_size, address, fee_amount, payment_status, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'Unpaid', 'pending')";
        
        $stmt = $this->db->prepare($sql);
        // "isssssd" -> int, string, string, string, string, string, decimal
        $stmt->bind_param("isssssd", $userId, $type, $holding, $zone, $pipe, $address, $fee);
        return $stmt->execute();
    }

    // --- WATER CONNECTION HISTORY ---
    public function getAllWaterApplications($userId) {
        $sql = "SELECT * FROM water_connections WHERE user_id = ? ORDER BY applied_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>