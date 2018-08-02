<?php
    session_start();
    
    // link the functions
    include 'functions.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            @import "css/styles.css";
        </style>
        
        <title> E-Shop Site </title>
    </head>
    <body>
        <div class='container'>
            <div class="text-center">
                <!-- cart image -->
                <!-- number of items in cart -->
                <!-- Bootstrap Navagation Bar -->
                <nav class='navbar navbar-default - navbar-right'>
                    <ul class='nav navbar-nav'>
                        <li><a href='index.php'>Home</a></li>
                        <li><a href='cart.php'>
                            <span class='glyphicon glyphicon-shopping-cart' aria-hidden='true'></span>
                            Cart: <span id='cartCount'><?php displayCartCount(); ?></span> </a></li>
                        <li><a href='login.php'>Login</a></li>
                    </ul>
                </nav>
                <br /><br />
                <div class="page-header"><h1> E-Shop Site </h1></div>
                
                <br /><br />
                
                <!-- checkout form -->
                
            </div>
        </div>
        
        <?php displayFooter(); ?>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="js/prodFunctions.js"></script>
    </body>
</html>
