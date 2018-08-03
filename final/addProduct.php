<?php

    include "dbConnection.php";
    
    $conn = getDatabaseConnection("cst336final");
    
    /*
    function getCategories() {
        
        global $conn;
        
        $sql = "SELECT catId, catName FROM product ORDER BY ProductID";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($records as $record) {
            
            echo "<option value='" . $record['catId'] . "'>" . $record['catName'] . " </option>";
        }
    }
    */
    if(isset($_GET['submitProduct'])) {
        
        $productName = $_GET['Name'];
        $productDescription = $_GET['Description'];
        $productImage = $_GET['ImageUrl'];
        $price = $_GET['BasePrice'];
        $salePrice = $_GET['SalePrice'];
        //catId= $_GET['catId'];
        
        $sql = "INSERT INTO product (Name, Description, ImageUrl, BasePrice, SalePrice) VALUES (:Name, :Description, :ImageUrl, :BasePrice, :SalePrice)";
        
        $np = array();
        $np['Name'] = $productName;
        $np['Description'] = $productDescription;
        $np['ImageUrl'] = $productImage;
        $np['BasePrice'] = $price;
        $np['SalePrice'] = $salePrice;
        //$np['catId'] = $catId;
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($np);
        
        header("Location: admin.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Add Product </title>
    </head>
    <body>
        <form>
            <strong>Product Name</strong> <input type= "text" class = "form-control" name = "Name"><br> 
            <strong>Desctription</strong> <textarea name = "Description" class = "form-control" cols = 50 rows = 4></textarea><br>
            <strong>Base Price</strong> <input type="text" class = "form-control" name = "BasePrice"><br>
            <strong>Sale Price</strong> <input type="text" class = "form-control" name = "SalePrice"><br>
            <!--<strong>Category</strong> <select name="catId" class="form-control">
                <option value = "">Select One</option> -->
                    <?//php getCategories() ?>
            </select><br>
            <strong> Set Image Url </strong> <input type = "text" name = "ImageUrl" class="form-control"><br>
            <input type = "submit" name = "submitProduct" class = "btn btn-primary" value="Add Product">
        </form>
    </body>
</html>