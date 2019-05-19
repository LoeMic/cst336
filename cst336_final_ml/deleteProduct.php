<?php

    include "dbConnection.php";
    
    $conn = getDatabaseConnection("cst336final");

    $sql = "DELETE FROM product WHERE ProductID = " . $_GET['ProductID'];
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    header("Location:admin.php");
?>