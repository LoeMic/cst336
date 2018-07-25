<?php

include 'dbConnection.php';

$conn = getDatabaseConnection("cst336final");

    $np = array();
    $np['Count'] = $Count;
    
    $sql = "";
    $sql = "SELECT `ProductID`, Count(`ProductID`) AS `Count` FROM `product`";
                
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
        <h4> Total Products <h4>
            <?php echo "Total Products: " . $result[0]['Count']; ?>
            
            <form action = "admin.php"> 
            <input type = "submit" class = 'btn btn-secondary' id = "beginning" name = "return" value="Return" />
        </form>
    </body>
</html>