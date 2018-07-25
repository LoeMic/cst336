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
        <title> Admin Page </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
        <script>
            function confirmDelete() {
                
                return confirm("Are you sure you want to delete the product? ")
                
            }
        
        
        </script>
    </head>
    <body>
        
        <h1> Admin Page </h1>
        
        <h3> Welcome <?=$_SESSION['adminName']?>!</h3><br />
        
        <form action = "addProduct.php"> 
            <input type = "submit" class = 'btn btn-secondary' id = "beginning" name = "addProduct" value="Add Product" />
        </form>
        
        <form action = "sum.php"> 
            <input type = "submit" class = 'btn btn-secondary' id = "beginning" name = "sum" value="Get Total Sales" />
        </form>
        
        <form action = "count.php"> 
            <input type = "submit" class = 'btn btn-secondary' id = "beginning" name = "count" value="Get Number Of Products" />
        </form>
        
        <form action = "avg.php"> 
            <input type = "submit" class = 'btn btn-secondary' id = "beginning" name = "avg" value="Get Average Sale Price" />
        </form>
        
        <form action="logout.php">
            <input type= "submit" class = 'btn btn-secondary' id = 'beginning' value = "Logout"/>
            
        </form><br/>
        
        <?php
        
            $records = displayAllProducts();
            
            echo "<table class= 'table table-hover'>";
            echo "<thead>
                <tr>
                    <th scope='col'>ID</th>
                    <th scope='col'>Name</th>
                    <th scope='col'>Description</th>
                    <th scope='col'>Price</th>
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
                    echo "<td><a class='btn btn-primary' href='updateProduct.php?ProductID=" . $record['ProductID'] . "'> Update</a></td>";
                    
                    echo "<form action='deleteProduct.php' onsubmit = 'return confirmDelete()'>";
                    echo "<input type='hidden'; name='ProductID' value = " . $record['ProductID'] . " />";
                    echo "<td><input type= 'submit' class= 'btn btn-danger' value = 'Remove'></td>";
                    echo "</form>";
                }
                
                echo "</tbody>";
                echo "</table>";
        
        ?>

    </body>
</html>