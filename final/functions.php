<?php

session_start();
include 'dbConnection.php';

$conn = getDatabaseConnection("cst336final");

// global calc values
$shippingFlatRate = 0.05;
$taxRate = 0.09;
$shippingDays = 5;

// retrieve the list of categories and build display
function getCategories()
{
    global $conn;
    
    $sql = "SELECT CategoryId, Name FROM productcategory ORDER BY Name";
    
    $statement = $conn->prepare($sql);
    $statement->execute();
    $records = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($records as $record)
    {
        echo "<option value='" .$record['CategoryId']."'>".$record['Name']."</option>";
    }
}

// retrieve the products for the search
function getProducts($name, $categoryID)
{
    global $conn;
    
    $sql = "SELECT * FROM product WHERE 1=1 ";
    
    if (!empty($name))
    {
        $sql .= " AND Name LIKE :productName";
        $namedParameters[":productName"] = "%" . $name . "%";
    }
    
    if (!empty($categoryID))
    {
        $sql .= " AND CategoryId = :categoryId";
        $namedParameters[":categoryId"] = $categoryID;
    }
    
    $sql .= " ORDER BY Name";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($namedParameters);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $records;
}

// process the save after customer checkout
function saveTransaction($fname, $lname, $email, $address1, $address2, $city, 
                            $state, $postalcode, $tendertype, $cart)
{
    // test
    //echo "saving transaction...";
    
    $valid = true;
    
    // calculate totals
    global $taxRate;
    global $shippingFlatRate;
    
    $totalBase = 0;
    $totalSale = 0;
    $calcTax = 0;
    $calcShipping = 0;
    $calcTotal = 0;
    
    // loop through the cart and create the totals
    foreach ($cart as $item)
    {
        // grab the data from the array
        //$id = $item['id'];
        $totalBase += ($item['basePrice'] * $item['quantity']);
        $totalSale += ($item['salePrice'] * $item['quantity']);
    }
    
    //$totalSale = number_format($totalSale,2);
    //$totalBase = number_format($totalBase,2);
    
    $calcTax = number_format($totalSale * $taxRate, 2);
    
    $calcShipping = number_format($totalSale * $shippingFlatRate, 2);
    
    // total - sale + tax + shipping
    $calcTotal = ($totalSale + $calcTax + $calcShipping);

    // testing
    //echo 'Starting customer data .. \n';

    // save the customer info    
    $customerId = saveCustomer($fname, $lname, $email, $address1, $address2, $city, $state, $postalcode);
    
    //echo 'Customer ID = ' . $customerId . '\n';
    
    // save the transaction (req's customer id)
    $transId = createTransaction($customerId, $tendertype, $totalSale, 
                                    $totalBase, $calcTax, $calcShipping, $calcTotal);
    
    //echo 'Transaction ID = ' . $transId . '\n';
    
    // save the lineitems (req's txn id)
    createLineItems($customerId, $transId, $cart);
    
    //echo 'LineItems created...\n';
    
    return $valid;
}

function saveCustomer($fname, $lname, $email, $address1, $address2, $city, $state, $postalcode)
{
    $valid = true;
    $customerId = 0;
    
    //echo 'email = ' . $email . '\n';
    
    // check for existing customer - match on email address
    global $conn;
    
    $sql = "SELECT CustomerID FROM customer WHERE EmailAddress = :emailaddress";
    
    $namedParameters[":emailaddress"] = $email;
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($namedParameters);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    $customerId = $record['CustomerID'];
    
    //echo 'customer id = ' . $customerId . '\n';
    
    // test for update
    if ($customerId > 0)
    {
        // this is an insert
        $sql = "UPDATE customer
                    SET FirstName = :fname,
                        LastName = :lname,
                        Address1 = :address1,
                        Address2 = :address2,
                        City = :city,
                        State = :state,
                        ZipCode = :postalcode,
                        LastPurchaseDate = NOW(),
                        UpdatedDate = NOW()
                WHERE EmailAddress = :email";

        $namedParams = array();
        $namedParams[":fname"] = $fname;
        $namedParams[":lname"] = $lname;
        $namedParams[":address1"] = $address1;
        $namedParams[":address2"] = $address2;
        $namedParams[":city"] = $city;
        $namedParams[":state"] = $state;
        $namedParams[":postalcode"] = $postalcode;
        $namedParams[":email"] = $email;
        
        // should have a transaction
        $statement = $conn->prepare($sql);
        $statement->execute($namedParams);
        
        //echo "Customer has been updated!";
    }
    else
    {
        $sql = "INSERT INTO customer
            (EmailAddress, FirstName, LastName, Address1, Address2, City, State, ZipCode, LastPurchaseDate, CreatedDate, UpdatedDate)
            VALUES
            (:email, :fname, :lname, :address1, :address2, :city, :state, :postalcode, NOW(), NOW(), NOW()) ";
            
        $namedParams = array();
        $namedParams[":email"] = $email;
        $namedParams[":fname"] = $fname;
        $namedParams[":lname"] = $lname;
        $namedParams[":address1"] = $address1;
        $namedParams[":address2"] = $address2;
        $namedParams[":city"] = $city;
        $namedParams[":state"] = $state;
        $namedParams[":postalcode"] = $postalcode;

        // should have a transaction
        $statement = $conn->prepare($sql);
        $statement->execute($namedParams);
        //$customerId = $statement->lastInsertId();
        $customerId = $conn->lastInsertId();
    }
    
    if ($valid)
    {
        return $customerId;
    }
    else
    {
        return -1;
    }
}

function createTransaction($customerId, $tendertype, $totalSale, $totalBase, $calcTax, 
                                $calcShipping, $calcTotal)
{
    global $shippingDays;
    
    $valid = true;
    $transId = 0;
    
    global $conn;
    
    // All transactions are inserts - we do not allow for returns or updates
    $sql = "INSERT INTO transaction
            (CustomerID, SaleDate, DeliveryDate, TotalAmount, ItemTotal, DiscountAmount,
                TaxTotal, ShippingTotal, TenderType, CreatedDate, UpdatedDate)
            VALUES
            (:customerId, NOW(), DATE_ADD(NOW(), INTERVAL 10 DAY), :calcTotal, :totalSale, :discountAmount, 
                :calcTax, :calcShipping, :tenderType, NOW(), NOW()) ";
            
    $namedParams = array();
    $namedParams[":customerId"] = $customerId;
    $namedParams[":calcTotal"] = $calcTotal;
    $namedParams[":totalSale"] = $totalSale;
    $namedParams[":discountAmount"] = $totalBase - $totalSale;
    $namedParams[":calcTax"] = $calcTax;
    $namedParams[":calcShipping"] = $calcShipping;
    $namedParams[":tenderType"] = $tendertype;

    // should have a transaction
    $statement = $conn->prepare($sql);
    $statement->execute($namedParams);
    $transId = $conn->lastInsertId();

    return $transId;
}

function createLineItems($customerId, $transId, $cart)
{
    $valid = true;
    
    global $conn;
    
    // All transactions are inserts - we do not allow for returns or updates
    $sql = "INSERT INTO lineitem
            (TransactionID, ProductID, ItemPrice, Quantity, CreatedDate, UpdatedDate)
            VALUES
            (:transId, :productId, :itemPrice, :quantity, NOW(), NOW()) ";

    foreach ($cart as $item)
    {
        $namedParams = array();
        $namedParams[":transId"] = $transId;
        $namedParams[":productId"] = $item['id'];
        $namedParams[":itemPrice"] = $item['salePrice'];
        $namedParams[":quantity"] = $item['quantity'];

        // should have a transaction
        $statement = $conn->prepare($sql);
        $statement->execute($namedParams);
        $lineitemId = $conn->lastInsertId();
    }
    
    return $valid;
}

function displayResults()
{
    global $items;      // work with the global results array

    if (!isset($items))
    {
        return;
    }
    
    // track the item counts per row
    $rowCount = 0;
    $itemsPerRow = 5;
    $rowOpen = false;
    
    echo "<table>";
    foreach($items as $item)
    {
        $id = $item['ProductID'];
        $name = $item['Name'];
        $basePrice = $item['BasePrice'];
        $salePrice = $item['SalePrice'];
        $imageUrl = $item['ImageUrl'];
        $desc = $item['Description'];
        
        // escape the quotes in name and desc
        $name = addslashes($name);
        $desc = addslashes($desc);
        
        // check for new row
        if ($rowCount % $itemsPerRow == 0)
        {
            // create the new row
            echo "<tr>";
        }
        
        // Display item as table row
        echo "<td class='product'>";
        
        // push the display items
        echo empty($imageUrl) || $imageUrl == NULL ? "&nbsp;" : "<img class='productImage' src='$imageUrl' width=100>";
        echo "<br />";
        echo "<span class='productName'>$name</span><br/>";
        echo "<span class='productBasePrice'>\$" . number_format($basePrice, 2) . "</span><br/>";
        echo "<span class='productSalePrice'>\$". number_format($salePrice, 2) . "</span><br/>";
        echo "<span class='productDesc'>$desc</span><br/>";
        echo "<span class='productAction'>";
        
        // Check to see if the most recent POST request has the same itemId
        //  If so, this item was just added to the cart.  Display the ADDED button.
        if ($_POST['itemId'] == $id)
        {
            echo "<input type='button' class='btn btn-success' value='Added'></input>";
        }
        else
        {
            echo "<input type='button' class='btn btn-warning' onclick='addToCartClick(this, $id, \"$name\", $basePrice, $salePrice, \"$imageUrl\", \"$desc\");' value='Add'></input>";
        }
        
        echo "</span><br/>";
        
        $rowCount++;
        
        // check for row end
        if ($rowCount % $itemsPerRow == 0)
        {
            // create the new row
            echo "</tr>";
        }
    }
    echo "</table>";

}

function displayCart()
{
    // check for an active cart
    if (isset($_SESSION['cart']))
    {
        //echo "count = " + count($_SESSION['cart']);
        
        if (count($_SESSION['cart']) == 0)
        {
            echo "<h3>no items in cart</h3>";
            return;
        }
        
        echo "<table>";
        echo "<tr>";
        echo "<th class='cart cartImage'></th>";
        echo "<th class='cart'>Name</th>";
        echo "<th class='cart'>Base Price</th>";
        echo "<th class='cart'>Sale Price</th>";
        echo "<th class='cart'>Quantity</th>";
        echo "<th class='cart'></th>";
        echo "<th class='cart'></th>";
        echo "</tr>";
        
        foreach ($_SESSION['cart'] as $item)
        {
            // grab the data from the array
            $id = $item['id'];
            $quantity = $item['quantity'];
            $name = $item['name'];
            $basePrice = $item['basePrice'];
            $salePrice = $item['salePrice'];
            $imageUrl = $item['imageUrl'];
            $desc = $item['desc'];
            
            // display the item as a table row
            echo "<tr>";
            echo "<td class='cart cartImage'>";
            echo empty($imageUrl) || $imageUrl == NULL ? "&nbsp;" : "<img class='productImage' src='$imageUrl' width=100>";
            echo "</td>";
            echo "<td class='cart cartName'>$name</td>";
            echo "<td class='cart cartBasePrice'>\$" . number_format($basePrice,2) . "</td>";
            echo "<td class='cart cartSalePrice'>\$" . number_format($salePrice,2) . "</td>";
            
            //name='update' class='form-control' placeHolder='$itemQuant'
            
            // form for quantity updates
            echo '<form method="post">';
            echo "<input type='hidden' name='itemId' value='$id'>";
            echo "<td class='cart'><input type='text' class='form-control' name='update' placeholder='$quantity' /></td>";
            echo '<td class="cart"><button class="btn btn-warning">Update</button></td>';
            echo '</form>';
            
            // onclick='alert(\"id : \" $id \\n\"quantity : \" $quantity);'
            
            // handle the deletes
            echo "<form method='post'>";
            echo "<input type='hidden' name='removeId' value='$id'>";
            echo "<td class='cart'><button class='btn btn-danger'>Remove</button></td>";
            echo "</form>";
            
            echo "</tr>";
        }
        
        // build the totals display
        displayCartTotals();
        
        // show the checkout button
        echo "<tr><td colspan=7 class='cartTotals'><br/>--------------------------</td></tr>";
        echo "<tr><td colspan=7 class='cartTotals'><a href='checkout.php' alt='Checkout'><button class='btn btn-danger'>Checkout</button></td></tr>";
        
        echo "</table>";
    }
}

function displayCartTotals()
{
    global $taxRate;
    global $shippingFlatRate;
    
    $totalBase = 0;
    $totalSale = 0;
    $calcTax = 0;
    $calcShipping = 0;
    $calcTotal = 0;
    
    // loop through the cart and create the totals
    foreach ($_SESSION['cart'] as $item)
    {
        // grab the data from the array
        //$id = $item['id'];
        $totalBase += ($item['basePrice'] * $item['quantity']);
        $totalSale += ($item['salePrice'] * $item['quantity']);
    }
    
    //$totalSale = number_format($totalSale,2);
    //$totalBase = number_format($totalBase,2);
    
    $calcTax = $totalSale * $taxRate;
    $calcTax = number_format($calcTax, 2);
    
    $calcShipping = $totalSale * $shippingFlatRate;
    $calcShipping = number_format($calcShipping, 2);
    
    // total - sale + tax + shipping
    $calcTotal = ($totalSale + $calcTax + $calcShipping);
    
    echo "<tr><td colspan=7 class='cartTotals'>&nbsp;</td></tr>";
    echo "<tr><td colspan=7 class='cartTotals'>Total Base: <span class='cartBasePrice'>$" . number_format($totalBase,2) . "</span></td></tr>";
    echo "<tr><td colspan=7 class='cartTotals'>Total Sale: <span class='cartTotal'>$" . number_format($totalSale,2) . "</span></td></tr>";
    echo "<tr><td colspan=7 class='cartTotals'>Total Tax: <span class='cartTotal'>$" . $calcTax . "</span></td></tr>";
    echo "<tr><td colspan=7 class='cartTotals'>Total Shipping: <span class='cartTotal'>$" . $calcShipping . "</span></td></tr>";
    echo "<tr><td colspan=7 class='cartTotals'>--------------------------</td></tr>";
    echo "<tr><td colspan=7 class='cartTotals cartTotalSale'>Total Charge: <span class='cartTotalSale'>$" . $calcTotal . "</span></td></tr>";
}

function displayCheckoutTotals()
{
    global $taxRate;
    global $shippingFlatRate;
    
    // show the purchase total
    $totalBase = 0;
    $totalSale = 0;
    $calcTax = 0;
    $calcShipping = 0;
    $calcTotal = 0;
    
    if (!isset($_SESSION['cart']))
    {
        $_SESSION['cart'] = array();
    }
    
    // loop through the cart and create the totals
    foreach ($_SESSION['cart'] as $item)
    {
        // grab the data from the array
        //$id = $item['id'];
        $totalBase += ($item['basePrice'] * $item['quantity']);
        $totalSale += ($item['salePrice'] * $item['quantity']);
    }
    
    //$totalSale = number_format($totalSale,2);
    //$totalBase = number_format($totalBase,2);
    
    $calcTax = $totalSale * $taxRate;
    $calcTax = number_format($calcTax, 2);
    
    $calcShipping = $totalSale * $shippingFlatRate;
    $calcShipping = number_format($calcShipping, 2);
    
    // total - sale + tax + shipping
    $calcTotal = ($totalSale + $calcTax + $calcShipping);
    
    echo "<table>";
    echo "<tr><td class='cartTotals'>Total Sale: <span class='cartTotal'>$" . number_format($totalSale,2) . "</span></td></tr>";
    echo "<tr><td class='cartTotals'>Total Tax: <span class='cartTotal'>$" . number_format($calcTax,2) . "</span></td></tr>";
    echo "<tr><td class='cartTotals'>Total Shipping: <span class='cartTotal'>$" . $calcShipping . "</span></td></tr>";
    echo "<tr><td class='cartTotals'>--------------------------</td></tr>";
    echo "<tr><td class='cartTotals cartTotalSale'>Total Charge: <span class='cartTotalSale'>$" . $calcTotal . "</span></td></tr>";
    echo "</table>";
}

// return the count item items in the cart
function displayCartCount()
{
    echo count($_SESSION['cart']);
}

function displayFooter()
{
    echo "<!-- The footer goes inside the body but not always -->";
    echo "<footer>";
    echo "<br /><br />";
    echo "<hr id='hr_footer' />";
    //echo "page views: " . rand(100,1000);
    //echo "<br />";
    echo "<p id='footer'>";
    echo "&copy; Group7 - 2018<br>";
    echo "The information provided here is for academic purposes only";
    echo "<br /><br />";
    echo "<a href='http://www.csumb.edu'><img src='img/csumb_icon.png' alt='CSU Monterey Bay'></a>";
    echo "</p>";
    echo "</footer>";
    echo "<!-- closing footer -->";
}

?>