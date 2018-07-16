<?php

    session_start();
    include 'dbConnection.php';

    // check for login
    if(!isset($_SESSION['adminName']))
    {
        header("Location:login.php");
    }
    
    $conn = getDatabaseConnection();

    // retrieve the list of categories and build display
    function getCategories()
    {
        global $conn;
        
        $sql = "SELECT catId, catName FROM om_category ORDER BY catName";
        
        $statement = $conn->prepare($sql);
        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($records as $record)
        {
            echo "<option value='" .$record['catId']."'>".$record['catName']."</option>";
        }
    }
    
    // check for form submission and insert
    if (isset($_GET['submitProduct']))
    {
        $productName = $_GET['productName'];
        $productDescription = $_GET['productDescription'];
        $productImage = $_GET['productImage'];
        $price = $_GET['price'];
        $catId = $_GET['catId'];
        
        $sql = "INSERT INTO om_product
            (productName, productDescription, productImage, price, catId)
            VALUES
            (:productName, :productDescription, :productImage, :price, :catId)";
            
        $namedParams = array();
        $namedParams[":productName"] = $productName;
        $namedParams[":productDescription"] = $productDescription;
        $namedParams[":productImage"] = $productImage;
        $namedParams[":price"] = $price;
        $namedParams[":catId"] = $catId;

        $statement = $conn->prepare($sql);
        $statement->execute($namedParams);
        
        echo "Product has been created!";
    }
?>

<form>
    <strong>Product Name</strong> <input type="text" class="form-control" name="productName"><br />
    <strong>Description</strong> <textarea name="productDescription" class="form-control" cols="50" rows="4"></textarea><br />
    <strong>Price</strong> <input type="text" class="form-control" name="price" /><br />
    <strong>Category</strong> <select name="catId" class="form-control">
        <option value="">Select One</option>
        <?php getCategories(); ?>
    </select><br />
    
    <strong>Set Image URL</strong> <input type="text" name="productImage" id="productImage" class="form-control"/><br />
    <input type="submit" name="submitProduct" class="btn btn-primary" value="Add Product"/>
</form>