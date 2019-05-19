<?php

session_start();
include 'dbConnection.php';

$conn = getDatabaseConnection();

if (is_ajax()) {
    if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
        $action = $_POST["action"];
        
        switch($action) { //Switch case for value of action
            case "searchproducts":
                
                $name = $_POST["productName"];
                $catId = $_POST["categoryId"];
                
                productSearch($name, $catId);
                break;
                
            case "addtocart":
                //echo "in addtocart\n";
                
                $id = $_POST["id"];
                $name = $_POST["name"];
                $basePrice = $_POST["basePrice"];
                $salePrice = $_POST["salePrice"];
                $imageUrl = $_POST["imageUrl"];
                $desc = $_POST["desc"];
                
                addItemToCart($id, $name, $basePrice, $salePrice, $imageUrl, $desc);
                break;
                
            case "test":
                test_function();
                break;
        }
    }
}

//Function to check if the request is an AJAX request
function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function addItemToCart($id, $name, $basePrice, $salePrice, $imageUrl, $desc)
{
    //echo "id = " . $id;
    
    $found = false;
    $quantity = 0;
    
    // update the cart
    foreach ($_SESSION['cart'] as &$item)
    {
        if ($item['id'] == $id)
        {
            $item['quantity'] += 1;
            $found = true;
            $quantity = $item['quantity'];
            break;
        }
    }
    
    // if not in cart, add to cart
    if (!$found)
    {
        $newItem = array();
        $newItem['id'] = $id;
        $newItem['quantity'] = 1;
        $newItem['name'] = $name;
        $newItem['basePrice'] = $basePrice;
        $newItem['salePrice'] = $salePrice;
        $newItem['imageUrl'] = $imageUrl;
        $newItem['desc'] = $desc;
        
        array_push($_SESSION['cart'], $newItem);
        
        $quantity = $newItem['quantity'];
    }
    
    // testing
    //echo "found = " . $found;
    //echo "quantity = " . $quantity;
    
    // return the total items in cart
    $return = $_POST;
    $return['itemCount'] = count($_SESSION['cart']);

    $return['json'] = json_encode($return);

    //return count($_SESSION['cart']);
    echo $return['json'];
}

// query the db based on the provided values and return the product list
function productSearch($name, $catId)
{
    
}

// update the quantity for the matching id item in shopping cart
function updateCartQuantity($id, $quantity)
{
    
}

function test_function()
{
    $return = $_POST;
    //$return["favorite_beverage"] = "Coke";
    //$return["favorite_restaurant"] = "McDonald's";
    $return["json"] = json_encode($return);
    echo json_encode($return);
}

?>