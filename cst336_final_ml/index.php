<?php
    // link the functions
    include 'functions.php';
    
    session_start();
    
    // initialize the session array
    if (!isset($_SESSION['cart']))
    {
        $_SESSION['cart'] = array();
    }

    if (isset($_GET['pName']) OR isset($_GET['pCat']) 
        OR isset($_GET['basepriceMin']) OR isset($_GET['basepriceMax'])
        OR isset($_GET['salepriceMin']) OR isset($_GET['salepriceMax']))
    {
        $name = $_GET['pName'];
        $categoryID = $_GET['pCat'];
        $salePrice = $_GET['saleprice'];
        $basePrice = $_GET['baseprice'];
        
        $items = getProducts($_GET['pName'], $_GET['pCat'], 
                    $_GET['salepriceMin'], $_GET['salepriceMax'],
                    $_GET['basepriceMin'], $_GET['basepriceMax']);
    }
    else
    {
        // pull without a name or category
        $items = getProducts(null, null, null, null, null, null);
    }
    
    // check to see if an item has been added to the cart
    if (isset($_POST['itemName']))
    {
        // create an array to hold an item's properties
        $newItem = array();
        $newItem['name'] = $_POST['itemName'];
        $newItem['id'] = $_POST['itemId'];
        $newItem['price'] = $_POST['itemPrice'];
        $newItem['image'] = $_POST['itemImage'];

        // Check to see if other items with this id are in the array
        //  If so, this item isn't new.  Only update quantity
        //  Must be passed by reference so that each item can be updated! -- nice note
        foreach ($_SESSION['cart'] as &$item)
        {
            if ($newItem['id'] == $item['id'])
            {
                $item['quantity'] += 1;
                $found = true;
            }
        }
        
        // else add it to the array
        if ($found != true)
        {
            $newItem['quantity'] = 1;
            array_push($_SESSION['cart'], $newItem);
        }
    }

?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            @import "css/styles.css";
        </style>
        
        <title> E-Shop Site </title>
    </head>
    <body>
        <div class='container'>
            <div class="text-center">
                <!-- cart image -->
                <!-- number of items in cart -->
                <!-- Bootstrap Navagation Bar -->
                <nav class='navbar navbar-default - navbar-right'>
                    <ul class='nav navbar-nav'>
                        <li><a href='index.php'>Home</a></li>
                        <li><a href='cart.php'>
                            <span class='glyphicon glyphicon-shopping-cart' aria-hidden='true'></span>
                            Cart: <span id='cartCount'><?php displayCartCount(); ?></span> </a></li>
                        <li><a href='login.php'>Login</a></li>
                    </ul>
                </nav>
                <br /><br />
                <div class="page-header"><h1> E-Shop Site </h1></div>
                <!-- display the list of items and the search controls -->
                <!-- Search Form -->
                
                <form enctype="text/plain">
                    <div class="form-group">
                        <label for="pName">Product Name: </label>
                        <input type="text" class="form-horizontal" name="pName" id="pName" placeholder="Name">
                        &nbsp;&nbsp;
                        <label for="pCat">Product Category: </label>
                        <select class="form-horizontal" name="pCat" id="pCat">
                            <option value=""> -- Select -- </option>
                            <?php getCategories() ?>
                        </select>
                        <br/>
                        <label for="salepriceMin">Sale Price: </label>
                        <input type="text" class="form-horizontal" name="salepriceMin" id="salepriceMin" placeholder="Min">
                        &nbsp;&nbsp;
                        <input type="text" class="form-horizontal" name="salepriceMax" id="salepriceMax" placeholder="Max">
                        <br />
                        <label for="basepriceMin">Base Price: </label>
                        <input type="text" class="form-horizontal" name="basepriceMin" id="basepriceMin" placeholder="Min">
                        &nbsp;&nbsp;
                        <input type="text" class="form-horizontal" name="basepriceMax" id="basepriceMax" placeholder="Max">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Submit" class="btn btn-default">
                    </div>
                </form>
                <br /><br />
                
                <!-- Display Search Results -->
                <div class='productlist'>
                <?php displayResults(); ?>
                </div>
                
            </div>
        </div>
        
        <?php displayFooter(); ?>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="js/prodFunctions.js"></script>
    </body>
<html>