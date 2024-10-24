<?php

class mDishes
{
    public function mGetAllDish()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM dish";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    
    public function mGetDishById($dishID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM dish WHERE dishID = $dishID";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    
    public function mGetDishByCategory($category)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM dish WHERE dishCategory = '$category'";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    
    public function mInsertDish($dishName, $dishCategory, $price, $prepare, $image) {
        $db = new Database;
        $conn = $db->connect();
        $sql = "INSERT INTO dish (dishName, dishCategory, price, preparationProcess, image) VALUES ('$dishName', '$dishCategory', $price, '$prepare', '$image')";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    
    public function mUpdateDish($dishName, $dishCategory, $price, $prepare, $image, $dishID) {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE dish SET dishName = '$dishName', dishCategory = '$dishCategory', price = $price, preparationProcess = '$prepare', image = '$image' WHERE dishID = $dishID";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    
    public function mLockDish($status, $dishID) {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE dish SET businessStatus = $status WHERE dishID = $dishID";
        
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
}