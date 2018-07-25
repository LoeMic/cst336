<?php
    include 'dbConnection.php';

    $conn = getDatabaseConnection();

    // search for matching products
    function searchProducts($query='')
    {
        // search by name or by category
        
    }

    // retrieve the list of categories
    function getCategories($categoryID)
    {
        global $conn;
        
        $sql = "SELECT CategoryID, Name FROM productcategory ORDER BY Name";
        
        $statement = $conn->prepare($sql);
        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($records as $record)
        {
            
            echo "<option value='" .$record['CategoryID']."' ";
            echo $record['CategoryID'] == $categoryID ? " selected " : "";
            echo ">".$record['Name']."</option>";
        }
    }
    
    // search for products matching the name or category
    function getProducts($name, $categoryID)
    {
        global $conn;
        
        $sql = "SELECT * FROM product ";
        
        // name - no category
        if (isset($name) AND !empty($name) AND (!isset($categoryID) OR empty($categoryID)))
        {
            $sql .= " WHERE Name like '%" . $name . "%' ";
        }
        // category - no name
        elseif (isset($categoryID) AND !empty($categoryID) AND (!isset($name) OR empty($name)))
        {
            $sql .= " WHERE CategoryID=" . $categoryID . " ";
        }
        // both
        elseif (isset($name) AND !empty($name) AND isset($categoryID) AND !empty($categoryID))
        {
            $sql .= " WHERE Name like '%" . $name . "%' AND CategoryID=" . $categoryID . " ";
        }
        
        $sql .= " ORDER BY Name";
        
        // test
        echo $sql;
        
        $statement = $conn->prepare($sql);
        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($records as $record)
        {
            echo "<option value='" .$record['CategoryID']."' ";
            echo $record['CategoryID'] == $categoryID ? " selected " : "";
            echo ">".$record['Name']."</option>";
        }
    }

    function displayResults()
    {
        global $items;      // work with the global results array

        if (!isset($items))
        {
            return;
        }
        
        foreach($items as $item)
        {
            $itemName = $item['name'];
            $itemPrice = $item['salePrice'];
            $itemImage = $item['thumbnailImage'];
            $itemId = $item['itemId'];
            
            // Display item as table row
            echo '<tr>';
            echo "<td><img src='$itemImage'></td>";
            echo "<td><h4>$itemName</h4></td>";
            echo "<td><h4>$itemPrice</h4></td>";
            
            // Hidden input element containing the item name
            echo "<form method='post'>";
            echo "<input type='hidden' name='itemName' value='$itemName'>";
            echo "<input type='hidden' name='itemId' value='$itemId'>";
            echo "<input type='hidden' name='itemImage' value='$itemImage'>";
            echo "<input type='hidden' name='itemPrice' value='$itemPrice'>";
            
            // Check to see if the most recent POST request has the same itemId
            //  If so, this item was just added to the cart.  Display the ADDED button.
            if ($_POST['itemId'] == $itemId)
            {
                echo '<td><button class="btn btn-success">Added</button></td>';
            }
            else
            {
                echo '<td><button class="btn btn-warning">Add</button></td>';
            }
            echo "</form>";
            
            echo "</tr>";
        }
        echo "</table>";
    }


    function displayCart()
    {
        // check for an active cart
        if (isset($_SESSION['cart']))
        {
            echo "<table class='table'>";
            foreach ($_SESSION['cart'] as $item)
            {
                // grab the data from the array
                $itemName = $item['name'];
                $itemPrice = $item['price'];
                $itemImage = $item['image'];
                $itemId = $item['id'];
                $itemQuant = $item['quantity'];
                
                // display the item as a table row
                echo "<tr>";
                echo "<td><img src='$itemImage'></td>";
                echo "<td><h4>$itemName</h4></td>";
                echo "<td><h4>$itemPrice</h4></td>";
                echo "<td><h4>$itemQuant</h4></td>";
                
                // handle the updates for quantity
                echo '<form method="post">';
                echo "<input type='hidden' name='itemId' value='$itemId'>";
                echo "<td><input type='text' name='update' class='form-control' placeHolder='$itemQuant'></td>";
                echo '<td><button class="btn btn-danger">Update</button></td>';
                echo '</form>';
                
                // handle the deletes
                echo "<form method='post'>";
                echo "<input type='hidden' name='removeId' value='$itemId'>";
                echo "<td><button class='btn btn-danger'>Remove</button></td>";
                echo "</form>";
                
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    
    // return the count item items in the cart
    function displayCartCount()
    {
        echo count($_SESSION['cart']);
    }
?>