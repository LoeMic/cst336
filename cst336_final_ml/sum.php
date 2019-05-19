<?php

include 'dbConnection.php';

$conn = getDatabaseConnection("cst336final");

    $np = array();
    $np['Total'] = $Total;
    
    $sql = "";
    $sql = "SELECT `TotalAmount`, Sum(`TotalAmount`) AS `Total` FROM `transaction`";
                
    $result = array();
    $stmt = $conn->prepare($sql);
    $stmt->execute($np);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
    <head>
        <title> </title>
    </head>
    <body>
        <h4> Total Sales <h4>
            <?php echo "Total Sales: " . $result[0]['Total']; ?>
            
            <form action = "admin.php"> 
            <input type = "submit" class = 'btn btn-secondary' id = "beginning" name = "return" value="Return" />
        </form>
    </body>
</html>