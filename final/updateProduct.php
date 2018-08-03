<?php

include "dbConnection.php";

$conn = getDatabaseConnection("cst336final");

if(isset($_GET['ProductID'])) {
    $product = getProductInfo();
}

function getProductInfo() {
    
    global $conn;
    
    $sql = "SELECT * FROM product WHERE ProductID = " . $_GET['ProductID'];
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $record;
}

/*
function getCategories($catId) {
    
    global $conn;
    
    $sql = "SELECT catId, catName FROM om_category ORDER BY catName";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($records as $record) {
        
        echo "<option ";
        echo ($records['catId'] == $catId)?"selected": "";
        echo " value='" . $record['catId'] . "'>" . $record['catName'] . " </option>";
    }
    
}
*/
    if(isset($_GET['updateProduct'])) {
        
        $sql = "UPDATE product SET Name = :Name, Description = :Description, ImageUrl = :ImageUrl, BasePrice = :BasePrice, SalePrice = :SalePrice WHERE ProductID = :ProductID";
        
        $np = array();
        $np[':Name'] = $_GET['Name'];
        $np[':Description'] = $_GET['Description'];
        $np[':ImageUrl'] = $_GET['ImageUrl'];
        $np[':BasePrice'] = $_GET['BasePrice'];
        $np[':SalePrice'] = $_GET['SalePrice'];
        //$np[':catId'] = $_GET['catId'];
        $np[':ProductID'] = $_GET['ProductID'];
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($np);
        echo "Product has been updated. ";
        
        header("Location: admin.php");
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title> Update Product </title>
    </head>
    <body>
         <form>
            <input type="hidden" name="ProductID" value = "<?=$product['ProductID']?>"/>
            <strong>Product Name</strong> <input type= "text" class = "form-control" name = "Name" value = "<?=$product['Name']?>"><br> 
            <strong>Desctription</strong> <textarea name = "Description" class = "form-control" cols = 50 rows = 4> <?=$product['Description']?> </textarea><br>
            <strong>Price</strong> <input type="text" class = "form-control" name = "BasePrice" value = "<?=$product['BasePrice']?>"><br>
            <strong>Sale Price</strong> <input type="text" class = "form-control" name = "SalePrice" value = "<?=$product['SalePrice']?>"><br>
            
            <!--<strong>Category</strong> <select name="catId" class="form-control">
                <option value = "">Select One</option> 
                    <?php //getCategories($product['catId'])?>-->
            </select><br>
            <strong> Set Image Url </strong> <input type = "text" name = "ImageUrl" value = "<?=$product['ImageUrl']?>" class="form-control"><br>
            <input type = "submit" name = "updateProduct" class = "btn btn-primary" value="Update Product">
        </form>
    </body>
</html>