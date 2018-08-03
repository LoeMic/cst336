<?php
    // link the functions
    include 'functions.php';
    
    session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <style>
            @import "css/style.css";
        </style>
        
        <title> E-Shop Site </title>
    </head>
    <body>
        <h1> E-Shop Site </h1>

        <form method="POST" action="loginProcess.php">
            Username: <input type="text" name="username" /> <br/>
            Password: <input type="password" name="password"/><br/>
        
            <input type="submit" hame="submitForm" value="Login!"/>
            
            <?php
            
            if($_SESSION['incorrect'])
            {
                echo "<p class='err' id ='error' style='color: red;'>";
                echo "<strong>Incorrect username or password. </strong></p>";
            }
            ?>
            
        </form>
    </body>
</html>