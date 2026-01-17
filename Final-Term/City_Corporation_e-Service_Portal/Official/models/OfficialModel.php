<?php
class OfficialModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    public function getStats() {
        $stats = [];
        
        // Total Applications (Trade + NID)
        $result = $this->db->query("SELECT 
            (SELECT COUNT(*) FROM trade_licenses) + 
            (SELECT COUNT(*) FROM nid_corrections) as total");
        $stats['total_applications'] = $result->fetch_assoc()['total'] ?? 0;

        // Pending Requests
        $result = $this->db->query("SELECT 
            (SELECT COUNT(*) FROM trade_licenses WHERE status='pending') + 
            (SELECT COUNT(*) FROM nid_corrections WHERE status='pending') as pending");
        $stats['pending_requests'] = $result->fetch_assoc()['pending'] ?? 0;

        // Approved Licenses
        $result = $this->db->query("SELECT 
            (SELECT COUNT(*) FROM trade_licenses WHERE status='approved') + 
            (SELECT COUNT(*) FROM nid_corrections WHERE status='approved') as approved");
        $stats['approved_licenses'] = $result->fetch_assoc()['approved'] ?? 0;

        return $stats;
    }

    // --- TRADE LICENSE FUNCTIONS ---
    public function getAllTradeLicenses() {
        // SQL JOIN to get Applicant Name & NID from 'users' table
        $sql = "SELECT t.*, u.name as applicant_name, u.nid as applicant_nid 
                FROM trade_licenses t 
                JOIN users u ON t.user_id = u.id 
                ORDER BY t.applied_at DESC"; // <--- FIXED: Changed created_at to applied_at
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateTradeLicenseStatus($id, $status) {
        $sql = "UPDATE trade_licenses SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    // --- NID CORRECTION FUNCTIONS ---
    public function getAllNidApplications() {
        // SQL JOIN to get Applicant Name & NID from 'users' table
        $sql = "SELECT n.*, u.name as applicant_name, u.nid as applicant_nid 
                FROM nid_corrections n 
                JOIN users u ON n.user_id = u.id 
                ORDER BY n.applied_at DESC"; // <--- FIXED: Changed created_at to applied_at
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateNidStatus($id, $status) {
        $sql = "UPDATE nid_corrections SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }
}
?>