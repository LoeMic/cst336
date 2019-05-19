<?php

SESSION_START();

//include "dbConnection.php";
include "functions.php";

$conn = getDatabaseConnection("cst336final");

function displayAllProducts() {
    
    global $conn;
    
    $sql = "SELECT p.*, pc.Name as CategoryName 
                FROM product as p
                    Join productcategory as pc
                        on p.CategoryID = pc.CategoryID
                ORDER BY p.ProductID";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $records;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title> Admin </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        
        <script>
            function confirmDelete() {
                
                return confirm("Are you sure you want to delete the product? ")
                
            }
        
        
        </script>
    </head>
    <body>
        <h1> Admin Page </h1>
        
        <h3> Welcome <?=$_SESSION['adminName']?>!</h3>

        <div>
            <?=showAdminNav() ?>
        </div>
        <br />
        
        <?php
        
            $records = displayAllProducts();
            
            echo "<table class= 'table table-hover'>";
            echo "<thead>
                <tr>
                    <th scope='col'>ID</th>
                    <th scope='col'>Name</th>
                    <th scope='col'>Description</th>
                    <th scope='col'>Base Price</th>
                    <th scope='col'>Sale Price</th>
                    <th scope='col'>Product Category</th>
                    <th scope='col'>Update</th>
                    <th scope='col'>Remove</th>
                </tr>
                </thead>";
                echo "<tbody>";
                foreach($records as $record) {
                    
                    echo "<tr>";
                    echo "<td>" . $record['ProductID'] . "</td>";
                    echo "<td>" . $record['Name'] . "</td>";
                    echo "<td>" . $record['Description'] . "</td>";
                    echo "<td>" . $record['BasePrice'] . "</td>";
                    echo "<td>" . $record['SalePrice'] . "</td>";
                    echo "<td>" . $record['CategoryName'] . "</td>";
                    echo "<td><a class='btn btn-primary' href='updateProduct.php?ProductID=" . $record['ProductID'] . "'> Update</a></td>";
                    
                    echo "<form action='deleteProduct.php' onsubmit = 'return confirmDelete()'>";
                    echo "<input type='hidden'; name='ProductID' value = " . $record['ProductID'] . " />";
                    echo "<td><input type= 'submit' class= 'btn btn-danger' value = 'Remove'></td>";
                    echo "</form>";
                    echo "</tr>";
                }
                
                echo "</tbody>";
                echo "</table>";
        
        ?>
    </body>
</html>