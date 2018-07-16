<?php

    session_start();
    include 'dbConnection.php';
    
    // check for login
    if(!isset($_SESSION['adminName']))
    {
        header("Location:login.php");
    }
    
    $conn = getDatabaseConnection();

    // get the list of categories and build display.  if param id is found, set selected
    function getCategories($catId)
    {
        global $conn;
        
        $sql = "SELECT catId, catName FROM om_category ORDER BY catName";
        
        $statement = $conn->prepare($sql);
        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($records as $record)
        {
            echo "<option ";
            echo $record['catId'] == $catId ? "selected" : "";
            echo " value='" .$record['catId']."'>".$record['catName']."</option>";
        }
    }
    
    function getProductInfo()
    {
        global $conn;
        
        $sql = "SELECT * FROM om_product WHERE productId = " . $_GET['productId'];
        
        $statement = $conn->prepare($sql);
        $statement->execute();
        $record = $statement->fetch(PDO::FETCH_ASSOC);
        
        return $record;
    }
    
    if (isset($_GET['updateProduct']))
    {
        $sql = "UPDATE om_product
                    SET productName = :productName,
                        productDescription = :productDescription,
                        productImage = :productImage,
                        price = :price,
                        catId = :catId
                WHERE productId = :productId";

        $namedParams = array();
        $namedParams[":productName"] = $_GET['productName'];;
        $namedParams[":productDescription"] = $_GET['productDescription'];
        $namedParams[":productImage"] = $_GET['productImage'];
        $namedParams[":price"] = $_GET['price'];
        $namedParams[":catId"] = $_GET['catId'];
        $namedParams[":productId"] = $_GET['productId'];
        
        $statement = $conn->prepare($sql);
        $statement->execute($namedParams);
        echo "Product has been updated!";
    }
    
    if (isset($_GET['productId']))
    {
        $product = getProductInfo();
    }

?>

<form>
    <input type="hidden" name="productId" value="<?=$product['productId']?>"/>
    <strong>Product Name</strong> <input type="text" class="form-control" name="productName" value="<?=$product['productName']?>"><br />
    <strong>Description</strong> <textarea name="productDescription" class="form-control" cols="50" rows="4"><?=$product['productDescription']?></textarea><br />
    <strong>Price</strong> <input type="text" class="form-control" name="price" value="<?=$product['price']?>"/><br />
    <strong>Category</strong> <select name="catId" class="form-control">
        <option value="">Select One</option>
        <?php getCategories($product['catId']); ?>
    </select><br />
    
    <strong>Set Image URL</strong> <input type="text" id="productImage" name="productImage" class="form-control" value="<?=$product['productImage']?>"/><br />
    <input type="submit" name="updateProduct" class="btn btn-primary" value="Update Product"/>
</form>