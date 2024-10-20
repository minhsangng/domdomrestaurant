<?php

class mPromotions
{
    public function showPromotions()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM promotion";
        
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    
    public function mGetAllPromotion() {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM promotion";
        
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    
    public function mGetPromotionNotStatus($status) {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM promotion WHERE status != $status GROUP BY status";
        
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    
    public function mGetPromotionById($proID) {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM promotion WHERE promotionID = $proID";
        
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    
    public function mInsertPromotion($proName, $des, $percent, $start, $end, $image, $status) {
        $db = new Database;
        $conn = $db->connect();
        $sql = "INSERT INTO promotion(promotionName, description, discountPercentage, startDate, endDate, image, status) VALUES ('$proName', '$des', $percent, '$start', '$end', '$image', '$status')";
        
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    
    public function mUpdatePromotion($proName, $des, $percent, $start, $end, $image, $status) {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE promotion SET promotionName = '$proName', description = '$des', discountPercentage = $percent, startDate = '$start', endDate = '$end', image = '$image', status = '$status'";
        
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    
    public function mLockPromotion($proID) {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE promotion SET status = 0 WHERE promotionID = $proID";
        
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
}