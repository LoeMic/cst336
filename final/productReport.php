<?php

include 'functions.php';

// check for filter form submit
function BuildReportDisplay()
{
    $lastDays = 0;
    $totalQuantity = 0;
    
    // the filter elements
    if (isset($_GET['lastDays']) AND !empty($_GET['lastDays']))
    {
        $lastDays = $_GET['lastDays'];
    }

    $records = GetProductSalesByDates($lastDays);
    
    // use for avg
    $totalRecords = count($records);
    
    echo "<h4>Product Sales in Last " . abs($lastDays) . " Days</h4>";
    echo "<br /><br />";
    echo "<table class= 'table table-hover'>";
    echo "<thead>
        <tr>
            <th scope='col'>Product ID</th>
            <th scope='col'>Name</th>
            <th scope='col'>Quantity Sold</th>
            <th scope='col'>Image</th>
        </tr>
        </thead>";
    echo "<tbody>";
    
    if ($totalRecords == 0)
    {
        echo "<tr><td colspan=4>No records were found.</td><tr>";
        echo "</tbody></table>";
        return;
    }
    
    foreach ($records as $record)
    {
        echo "<tr>";
        echo "<td>" . $record['ProductID'] . "</td>";
        echo "<td>" . $record['Name'] . "</td>";
        echo "<td>" . $record['SaleQuantity'] . "</td>";
        echo "<td>";
        echo empty($record['ImageUrl']) || $record['ImageUrl'] == NULL ? "&nbsp;" : "<img class='productImage' src='" . $record['ImageUrl'] . "' width=50>";
        echo "</td>";
        echo "</tr>";
        
        $totalQuantity += $record['SaleQuantity'];
    }
    
    // add the total
    echo "<tr>";
    echo "<td colspan=2></td>";
    echo "<td style='font-weight:bold;'>";
    echo "Total Quantity: $totalQuantity";
    echo "</td>";
    echo "<td></td>";
    echo "</tbody></table>";
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title> Admin - Product Sale Report </title>
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </head>
    <body>
        <h1> Admin Page </h1>
        
        <h3> Welcome <?=$_SESSION['adminName']?>!</h3>
        
        <h3>Product Sale Report</h3>

        <div>
            <?=showAdminNav() ?>
        </div>
        <br />
    
        <form enctype="text/plain">
            <div class="form-group">
                <label for="lastDays">Select Lookback Period (from today): </label>
                <select name="lastDays" id="lastDays">
                    <option value="">No Filter</option>
                    <option value="-1">1 Day</option>
                    <option value="-2">2 Days</option>
                    <option value="-7">7 Days</option>
                    <option value="-30">30 Days</option>
                    <option value="-60">60 Days</option>
                    <option value="-90">90 Days</option>
                    <option value="-180">180 Days</option>
                </select>
                &nbsp;&nbsp;
                <input type= 'submit' class='btn btn-success' value='Filter'>
            </div>
        </form>
        <br />
    
        <?php BuildReportDisplay(); ?>
    
    </body>
</html>