<!DOCTYPE html>
<html>
    <head>
        <title> </title>
    </head>
    <body>
        <?php
        
        $n = 20943;
        $n = number_format($n,2); 
        echo $n  . "<br><br>";
        
        $n = rand(5,15);   
        echo $n  . "<br><br>";
        
        $n = "hElLo WoRlD!";
        echo strtoupper($n)  .  "<br><br>";

        $i = 0;
        while ($i <= 5) {
            echo $i . "\n<br/>";
            $i++; //MUST increment this value as part of the while loop
        }

        ?>
    </body>
</html>