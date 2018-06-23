<!DOCTYPE html>
<html>
    <head>
        <title> 777 Slot Machine </title>
        <style>
            @import url("css/styles.css");
        </style>
    </head>
    <body>
        
        <div id="main">
            <?php
                include 'inc/functions.php';
            
                // play the game
                play();
                
                /*
                // show the points display
                $total = $total + displayPoints($randomValue1, $randomValue2, $randomValue3);
    
                echo "<br/><br/>Total Points: " . $total;
                */
            ?>
            
            <form>
                <input type="submit" value="Spin!"/>
            </form>
        </div>
    </body>
</html>