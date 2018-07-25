<?php

include 'dbConnection.php';

$conn = getDatabaseConnection("cst336final");

    $np = array();
    $np['Avg'] = $Avg;
    
    $sql = "";
    $sql = "SELECT Avg(`BasePrice`) AS `Avg` FROM `product`";
                
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
        <h4> Average Base Price <h4>
            <?php echo "Average Base Price: " . $result[0]['Avg']; ?>
            
            <form action = "admin.php"> 
            <input type = "submit" class = 'btn btn-secondary' id = "beginning" name = "return" value="Return" />
        </form>
    </body>
</html>