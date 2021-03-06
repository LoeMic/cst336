<!DOCTYPE html>
<html>
    <head>
        <title> Lab 2a </title>
        <style>
            table {
                padding: 0px;
                margin-left: auto;
                margin-right: auto;
                text-align: center;
            }
            
            td {
                padding: 10px;
                border: 1px solid black;
            }
            
            p {
                text-align: center;
            }
            
            td.head {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <!--
        Adding random numbers in PHP.

        We will create a PHP that generates nine random numbers using a loop.
        The random numbers will be displayed within a table. 
        The program will identify whether each number is odd or even.
        The program will also calculate the sum and average of the random numbers.
        -->
        <p>Lab2a - PHP Random Numbers</p>
        <table>
            <tr>
                <td class="head">iteration</td>
                <td class="head">random number</td>
                <td class="head">even / odd</td>
                <td class="head">calcs</td>
            </tr>
        <?php
        
        $rndNum = 0;
        $totNum = 0;
        
        for ($n=1; $n<=9; $n++)
        {
            $rndNum = rand(1,100);
            
            // test for even or odd
            echo "<tr>";
            // show the number
            echo "<td>";
            echo $n;
            echo "</td>";
            echo "<td>";
            echo $rndNum;
            echo "</td>";
            echo "<td>";
            echo ($rndNum % 2 == 0)?"even":"odd";
            echo "</td>";
            
            echo "<td>";
            // sum the numbers
            $totNum = $totNum + $rndNum;
            
            echo "sum = " . $totNum . "<br />";
            echo "avg = " . number_format($totNum/$n, 2);
            echo "</td>";            
            
            echo "</tr>";
        }
        
        ?>
        </table>
    </body>
</html>