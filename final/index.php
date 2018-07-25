<?php
    // link the functions
    include 'functions.php';
    
    session_start();
    
    // initialize the session array
    if (!isset($_SESSION['cart']))
    {
        $_SESSION['cart'] = array();
    }

    if (isset($_GET['pName']) OR isset($_GET['pCat']))
    {
        $name = $_GET['pName'];
        $categoryID = $_GET['pCat'];
        
        $items = getProducts($name, $categoryID);
        
        // test prints
        /*
        echo '<br /><br /><br />';
        echo 'Query = ' . $query;
        echo '<br /><br />';
        print_r($items);
        */
        //name, salePrice, thumbnailImage, itemId
    }
    else
    {
        // pull without a name or category
        
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
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
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
                            Cart: <?php displayCartCount(); ?> </a></li>
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
                        <br />
                        <label for="pCat">Product Category: </label>
                        <select class="form-horizontal" name="pCat" id="pCat">
                            <option value=""> -- Select -- </option>
                            <?php getCategories() ?>
                        </select>
                    </div>
                    <input type="submit" value="Submit" class="btn btn-default">
                    <br /><br />
                </form>
                
                <!-- Display Search Results -->
                <?php displayResults(); ?>
            </div>
        </div>
    </body>
<html>