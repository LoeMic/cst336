<?php

SESSION_START();

include "dbConnection.php";

$conn = getDatabaseConnection("cst336final");

if(!isset ($_SESSION['adminName'])) {
    
    header("Location:login.php");
}

function displayAllProducts() {
    
    global $conn;
    
    $sql = "SELECT * FROM product ORDER BY ProductID";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $records;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title> E-Shop Marketplace </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
        
    </head>
    <body>
        
        <h1> E-Shop Market Place </h1>
        
        <h3> Welcome <?=$_SESSION['adminName']?>!</h3><br />
        
       
        
        <form action="logout.php">
            <input type= "submit" class = 'btn btn-secondary' id = 'beginning' value = "Logout"/>
            
        </form><br/>
        
        <?php
        
            $records = displayAllProducts();
            
            echo "<table class= 'table table-hover'>";
            echo "<thead>
                <tr>
                    <th scope='col'>Name</th>
                    <th scope='col'>Description</th>
                    <th scope='col'>Price</th>
                    
                </tr>
                </thead>";
                echo "<tbody>";
                foreach($records as $record) {
                    
                    echo "<tr>";
                    echo "<td>" . $record['Name'] . "</td>";
                    echo "<td>" . $record['Description'] . "</td>";
                    echo "<td>" . $record['BasePrice'] . "</td>";
                    
                    echo "</form>";
                }
                
                echo "</tbody>";
                echo "</table>";
        
        ?>

    </body>
</html>