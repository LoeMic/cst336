<?php

    session_start();
    include 'dbConnection.php';
    
    $conn = getDatabaseConnection();
    
    if(!isset($_SESSION['adminName']))
    {
        header("Location:index.php");
    }
    
    function displayAllProducts()
    {
        global $conn;
        
        $sql = "SELECT * FROM om_product ORDER BY productId";
        
        $statement = $conn->prepare($sql);
        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $records;
    }
?>

<html>
    <head>
        <script language="javascript">
            function confirmDelete()
            {
                return confirm("Are you sure you want to delete the product?");
            }
        </script>
        <title>Admin - Product Management</title>
        <link rel="stylesheet" href="css/styles.css" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet">
    </head>
    <body>
        <div class="user-display">
            <form action="logout.php">Welcome - <?=$_SESSION['adminName']?>&nbsp;&nbsp;
                <input type="submit" class="btn btn-secondary" id="beginning" name="logout" value="Logout" />
            </form>
        </div>
        <h1>Admin</h1><h2>Product Management</h2>
        <br />
        <form action="addProduct.php">
            <input type="submit" class="btn btn-secondary" id="beginning" name="addproduct" value="Add Product" />
        </form>

<?php

    $records = displayAllProducts();
    
    echo "<table class='table table-hover'>";
    echo "<thead>
            <tr>
                <th scope='col'>ID</th>
                <th scope='col'>Name</th>
                <th scope='col'>Description</th>
                <th scope='col'>Price</th>
                <th scope='col'>Update</th>
                <th scope='col'>Remove</th>
            </tr>
        </thead>";
    echo "<tbody>";

    foreach ($records as $record)
    {
        echo "<tr>";
        echo "<td>".$record['productId']."</td>";
        echo "<td>".$record['productName']."</td>";
        echo "<td>".$record['productDescription']."</td>";
        echo "<td>".$record['price']."</td>";
        echo "<td><a class='btn btn-primary' href='updateProduct.php?productId=".$record['productId']."'><button>Update</button></a></td>";
        
        echo "<form action='deleteProduct.php' onsubmit='return confirmDelete()'>";
        echo "<input type='hidden' name='productId' value='" . $record['productId'] . "'></input>";
        echo "<td><input type='submit' class='btn btn-danger' value='Remove'/></td>";
        echo "</form>";
    }
    
    echo "</tbody>";
    echo "</table>";
    
?>

    </body>
</html>