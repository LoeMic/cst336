<?php

include "functions.php";

if(isset($_GET['submitProduct'])) {

    $productName = $_GET['Name'];
    $productDescription = $_GET['Description'];
    $productImage = $_GET['ImageUrl'];
    $price = $_GET['BasePrice'];
    $salePrice = $_GET['SalePrice'];
    $catId= $_GET['catId'];
    
    // moved to functions
    AddProduct($productName, $productDescription, $productImage, $price, $salePrice, $catId);

    header("Location: admin.php");
    
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Admin - Add Product </title>
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </head>
    <body>
        <h1> Admin Page </h1>
        
        <h3> Welcome <?=$_SESSION['adminName']?>!</h3>
        
        <h3>Update Product</h3>

        <div>
            <?=showAdminNav() ?>
        </div>
        <br />
        <div class="form-group">
        <form>
            <label for="Name">Product Name*</label> <input type= "text" class = "form-horizontal" name = "Name" required />
            <br /> 
            <label for="Description">Description</label> <textarea name = "Description" class="form-horizontal" cols = 50 rows = 4></textarea>
            <br />
            <label for="BasePrice">Base Price*</label> <input type="text" class = "form-horizontal" name = "BasePrice" required />
            <br />
            <label for="SalePrice">Sale Price*</label> <input type="text" class="form-horizontal" name="SalePrice" required />
            <br />
            <label for="catId">Product Category*</label>
                <select name="catId" class="form-horizontal" required>
                    <option value = "">Select One</option>
                    <?php getCategories() ?>
                </select>
            <br />
            <label for="ImageUrl">Image Url</label> <input type="text" name="ImageUrl" class="form-horizontal" />
            <br>
            <input type = "submit" name = "submitProduct" class = "btn btn-primary" value="Add Product" />
        </form>
    </body>
</html>