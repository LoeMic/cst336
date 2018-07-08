<?php

    include 'dbConnection.php';

    $conn = getDatabaseConnection("ottermart");

    $productId = $_GET['productId'];
    
    $sql = "SELECT * 
            FROM om_product 
                NATURAL JOIN om_purchase 
            WHERE productId = :pId";
    
    $np = array();
    $np[":pId"] = $productId;
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($np);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    /*
    // test - display records
    echo "productId = " . $productId . "<br />";
    print_r($records);
    echo "<br />";
    */
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Purchase History</title>
        <link rel="stylesheet" href="css/styles.css" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet">
    </head>
    <body>
        <h1> Purchase History </h1>
        <br />
<?php

    if (isset($records) AND count($records) > 0)
    {
        echo $records[0]['productName'] . "<br />";
        echo "<img src='" . $records[0]['productImage'] . "' width='200'/><br />";
        
        foreach ($records as $record)
        {
            echo "Purchase Date: " . $record["purchaseDate"] . "<br />";
            echo "Unit Price: " . $record["unitPrice"] . "<br />";
            echo "Quantity: " . $record["quantity"] . "<br />";
        }        
    }
    else
    {
        echo "No records found...<br />";
    }

?>
    <br />
    <a href="index.php" alt="search form">Search Form</a>
    </body>
</html>