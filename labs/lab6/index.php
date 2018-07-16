<?php
    session_start();
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
        <h1>Admin - Login</h1>
        <br />
        <form method="POST" action="loginProcess.php">
            Username: <input type="text" name="username"/><br />
            Password: <input type="password" name="password"/><br />
            
            <input type="submit" name="submitForm" value="Login!"/>
            
            <br /><br />
            <?php
                if($_SESSION['incorrect'])
                {
                    echo "<p class='lead' id='error' style='color:red;'>";
                    echo "<strong>Incorrect username or password!</strong></p>";
                }
            ?>
        </form>
    </body>
</html>