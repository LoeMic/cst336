<?php

    include 'dbConnection.php';

    $conn = getDatabaseConnection("ottermart");
    
    function displayCategories()
    {
        global $conn;
        
        $sql = "SELECT catID, catName FROM om_category ORDER BY catName";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //print_r($records);
        
        foreach($records as $record)
        {
            echo "<option value='".$record["catID"]."' >" . $record["catName"] . "</option>";
        }
    }
    
    function displaySearchResults()
    {
        global $conn;
        
        if (isset($_GET['searchForm']))
        {
            echo "<h3>Products Found : </h3>";
            
            $sql = "SELECT * FROM om_product WHERE 1 ";
            
            if (!empty($_GET['product']))
            {
                $sql .= " AND productName LIKE :productName";
                $namedParameters[":productName"] = "%" . $_GET['product'] . "%";
            }
            
            if (!empty($_GET['category']))
            {
                $sql .= " AND catID = :categoryId";
                $namedParameters[":categoryId"] = $_GET['category'];
            }
            
            if (!empty($_GET['priceFrom']))
            {
                $sql .= " AND price >= :priceFrom";
                $namedParameters[":priceFrom"] = $_GET['priceFrom'];
            }
            
            if (!empty($_GET['priceTo']))
            {
                $sql .= " AND price <= :priceTo";
                $namedParameters[":priceTo"] = $_GET['priceTo'];
            }
            
            if (isset($_GET['orderBy']))
            {
                if ($_GET['orderBy'] == "price")
                {
                    $sql .= " ORDER BY price";
                }
                elseif ($_GET['orderBy'] == "name")
                {
                    $sql .= " ORDER BY productName";
                }
            }
            
            $stmt = $conn->prepare($sql);
            $stmt->execute($namedParameters);
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($records as $record)
            {
                echo "<a href=\"purchaseHistory.php?productId=" . $record['productId'] . "\"> History </a> ";
                
                echo $record["productName"] . " " . $record["productDescription"] . " $" . $record["price"] . "<br /><br />";
            }
        }
    }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title> OtterMart Product Search </title>
        <link rel="stylesheet" href="css/styles.css" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet">
    </head>
    <body>
        <div>
            <h1> OtterMart Product Search </h1>
            
            <br />
            <form>
                <table>
                    <tr>
                        <td class="key">
                            Product:
                        </td>
                        <td class="value">
                            <input type="text" name="product" />
                        </td>
                    </tr>
                    <tr>
                        <td class="key">
                            Category:
                        </td>
                        <td class="value">
                            <select name="category">
                                <option value="">Select One</option>
                                <?=displayCategories()?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="key">
                            Price - From:
                        </td>
                        <td class="value">
                             <input type="text" name="priceFrom" size="7"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="key">
                            To:
                        </td>
                        <td class="value">
                            <input type="text" name="priceTo" size="7" />
                        </td>
                    </tr>
                    <tr>
                        <td class="key">
                            Order Result By:
                        </td>
                        <td class="value">
                            <input type="radio" name="orderBy" value="price" /> Price <br />
                            <input type="radio" name="orderBy" value="name" /> Name
                        </td>
                    </tr>
                </table>

                <br />
                <input type="submit" value="Search" name="searchForm" />
            </form>
            
            <br />
        </div>
        
        </hr>
        
        <div class="searchResults">
            <?=displaySearchResults()?>
        </div>
    </body>
</html>