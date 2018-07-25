<?php

SESSION_START();

include "dbConnection.php";

$conn = getDatabaseConnection("cst336final");

$username = $_POST['username'];
$password = sha1($_POST['password']);

$sql = "SELECT * FROM user WHERE username = :username AND password = :password"; 

$np = array();

$np[":username"] = $username;
$np[":password"] = $password;

$stmt = $conn->prepare($sql);
$stmt->execute($np);
$record = $stmt->fetch(PDO::FETCH_ASSOC);

if(empty($record)) {
    $_SESSION['incorrect'] = true;
    header("Location:index.php");
} else {
    if(strtolower($record['admin']) == 'yes'  || strtolower($record['role']) == 'a')        // don't know which is correct
    {
        //go to admin page
        $_SESSION['incorrect'] = false;
        $_SESSION['adminName'] = $record['firstName'] . " " . $record['lastName'];
        
        // update the last login value
        $sql = "UPDATE user
                    set LastLogin = now()
                WHERE UserID=" . $record['UserID']; 
        
        try
        {
            if ($conn->query($sql) === true)
            {
                // query successful
            }
            else
            {
                // not successful - log an error
            }
        }
        catch (Exception $e)
        {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        

        header("Location:admin.php");
    }
    
    else {//go to user page
        $_SESSION['incorrect'] = false;
        $_SESSION['adminName'] = $record['firstName'] . " " . $record['lastName'];
        header("Location:user.php");
    }
}
 
?>

<DOCTYPE html>

<html> 
    <head>
    
        <title> </title>
    
    </head>
    
    <body>
        
    </body>
</html>