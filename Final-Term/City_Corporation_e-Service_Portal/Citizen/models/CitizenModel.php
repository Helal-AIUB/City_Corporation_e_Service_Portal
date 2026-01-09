<?php
class CitizenModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // Fetch user details for the dashboard
    public function getProfile($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update user details
    public function updateInfo($id, $nid, $phone, $address, $photo) {
        // If a new photo is uploaded, update it. If not, keep the old one.
        if ($photo) {
            $sql = "UPDATE users SET nid=?, phone=?, address=?, profile_pic=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$nid, $phone, $address, $photo, $id]);
        } else {
            $sql = "UPDATE users SET nid=?, phone=?, address=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$nid, $phone, $address, $id]);
        }
    }

    // Insert new Trade License Application
    public function createTradeLicense($userId, $bName, $bType, $bAddress, $capital) {
        $sql = "INSERT INTO trade_licenses (user_id, business_name, business_type, business_address, trade_capital) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$userId, $bName, $bType, $bAddress, $capital]);
    }



    // Fetch all trade license applications for a specific user
    public function getMyTradeLicenses($userId) {
        $sql = "SELECT * FROM trade_licenses WHERE user_id = ? ORDER BY applied_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>