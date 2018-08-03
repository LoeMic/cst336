<?php

include 'functions.php';

// check for filter form submit
function BuildReportDisplay()
{
    $totalSale = 0;
    $totalItem = 0;
    $totalDiscount = 0;
    $totalTax = 0;
    $totalShip = 0;
    $transDateMin = NULL;
    $transDateMax = NULL;

    // the filter elements
    if (isset($_GET['transDateMin']) AND !empty($_GET['transDateMin']))
    {
        $transDateMin = new DateTime($_GET['transDateMin']);
    }
    if (isset($_GET['transDateMax']) AND !empty($_GET['transDateMax']))
    {
        $transDateMax = new DateTime($_GET['transDateMax']);
    }
    
    $records = GetTransactionsByDates($transDateMin, $transDateMax);
    
    // use for avg
    $totalRecords = count($records);
    $minTrans = 0;
    $maxTrans = 0;
    $firstItem = true;
    
    echo "<table class= 'table table-hover'>";
    echo "<thead>
        <tr>
            <th scope='col'>Transaction ID</th>
            <th scope='col'>Customer Email</th>
            <th scope='col'>Ship State</th>
            <th scope='col'>Ship PostalCode</th>
            <th scope='col'>Sale Date</th>
            <th scope='col'>Delivery Date</th>
            <th scope='col'>Sale Total</th>
            <th scope='col'>Item Total</th>
            <th scope='col'>Tax</th>
            <th scope='col'>Shipping</th>
            <th scope='col'>Discount Total</th>
            <th scope='col'>Tender Type</th>
        </tr>
        </thead>";
    echo "<tbody>";
    
    if ($totalRecords == 0)
    {
        echo "<tr><td colspan=11>No records were found.</td><tr>";
        echo "</tbody></table>";
        return;
    }
    
    /*
        TransactionID
        CustomerID
        SaleDate
        DeliveryDate
        TotalAmount
        ItemTotal
        DiscountAmount
        ShippingTotal
        TaxTotal
        TenderType
        
        <th scope='col'>Transaction ID</th>
            <th scope='col'>Customer Email</th>
            <th scope='col'>Ship State</th>
            <th scope='col'>Ship PostalCode</th>
            <th scope='col'>Sale Date</th>
            <th scope='col'>Delivery Date</th>
            <th scope='col'>Sale Total</th>
            <th scope='col'>Item Total</th>
            <th scope='col'>Discount Total</th>
            <th scope='col'>Tax</th>
            <th scope='col'>Shipping</th>
            <th scope='col'>Tender Type</th>
    */
    foreach ($records as $record)
    {
        echo "<tr>";
        echo "<td>" . $record['TransactionID'] . "</td>";
        echo "<td>" . $record['EmailAddress'] . "</td>";
        echo "<td>" . $record['State'] . "</td>";
        echo "<td>" . $record['ZipCode'] . "</td>";
        echo "<td>" . $record['SaleDate'] . "</td>";
        echo "<td>" . $record['DeliveryDate'] . "</td>";
        echo "<td>" . $record['TotalAmount'] . "</td>";
        echo "<td>" . $record['ItemTotal'] . "</td>";
        echo "<td>" . $record['TaxTotal'] . "</td>";
        echo "<td>" . $record['ShippingTotal'] . "</td>";
        echo "<td>" . $record['DiscountAmount'] . "</td>";
        echo "<td>" . $record['TenderType'] . "</td>";
        echo "</tr>";
        
        // add to totals
        $totalSale += $record['TotalAmount'];
        $totalItem += ($record['TotalAmount']-$record['DiscountAmount']);
        $totalDiscount += $record['DiscountAmount'];
        $totalTax += $record['TaxTotal'];
        $totalShip += $record['ShippingTotal'];
        
        // min/max
        if ($firstItem == true)
        {
            $minTrans = $totalSale;
            $maxTrans = $totalSale;
        }
        else
        {
            if ($minTrans > $totalSale)
            {
                $minTrans = $totalSale;
            }
            if ($maxTrans < $totalSale)
            {
                $maxTrans = $totalSale;
            }
        }
    }
    // add the totals
    echo "<tr><td colspan=5></td>";
    echo "<td style='font-weight:bold;'>Totals:</td>";
    echo "<td style='font-weight:bold;'>" . number_format($totalSale,2,'.','') . "</td>";
    echo "<td style='font-weight:bold;'>" . number_format($totalItem,2,'.','') . "</td>";
    echo "<td style='font-weight:bold;'>" . number_format($totalDiscount,2,'.','') . "</td>";
    echo "<td style='font-weight:bold;'>" . number_format($totalTax,2,'.','') . "</td>";
    echo "<td style='font-weight:bold;'>" . number_format($totalShip,2,'.','') . "</td>";
    echo "<td></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<tr><td colspan=5></td>";
    echo "<td colspan=6 style='font-weight:bold;'>";
    echo "Total Transactions: $totalRecords<br />";
    echo "Average Sale: " . number_format($totalSale / $totalRecords,2, '.', '') . "<br />";
    echo "Min Transaction: " . number_format($minTrans,2,'.','') . "<br />";
    echo "Max Transaction: " . number_format($maxTrans,2,'.','') . "<br />";
    echo "</td>";
    echo "<td></td>";
    echo "</tr>";
    echo "</tbody>";
    echo "</table>";
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title> Admin - Transaction Report </title>
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </head>
    <body>
        <h1> Admin Page </h1>
        
        <h3> Welcome <?=$_SESSION['adminName']?>!</h3>
        
        <h3>Transaction Report</h3>

        <div>
            <?=showAdminNav() ?>
        </div>
        <br />
    
        <form enctype="text/plain">
            <div class="form-group">
                <label for="transDateMin">Transaction Date Range (YYYY/MM/DD): </label>
                <input type="text" class="form-horizontal" name="transDateMin" id="transDateMin" placeholder="Min" value="<?=$_GET['transDateMin']?>">
                &nbsp;&nbsp;
                <input type="text" class="form-horizontal" name="transDateMax" id="transDateMax" placeholder="Max" value="<?=$_GET['transDateMax']?>">
                &nbsp;&nbsp;
                <input type= 'submit' class='btn btn-success' value='Filter'>
            </div>
        </form>
        <br />
    
        <?php BuildReportDisplay(); ?>
    
    </body>
</html>