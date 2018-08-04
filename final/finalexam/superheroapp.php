<?php

session_start();
include 'dbConnection.php';

$conn = getDatabaseConnection('final');

//{"action": "checkname", hero: superhero, realname: realname}

if (is_ajax()) {
    if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
        $action = $_POST["action"];
        
        switch($action) { //Switch case for value of action
            case "checkname":
                
                //echo "in checkname";
                
                $hero = $_POST["hero"];
                $realname = $_POST["realname"];
                
                checkName($hero, $realname);
                break;
        }
    }
}

//Function to check if the request is an AJAX request
function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function checkName($hero, $realname)
{
    global $conn;
    
    $valid = false;
    $correct = false;
    
    // query the name
    $sql = "select distinct name, firstName, lastName from superhero where name = :name";
    
    //echo 'hero = ' . $hero . '\n';
    
    $namedParameters = array();
    $namedParameters[":name"] = $hero;
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($namedParameters);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //echo 'firstName = ' . $record['firstName'] . '\n';
    //echo 'lastName = ' . $record['lastName'] . '\n';
    
    // test the name
    if (strtolower($record['firstName'] . " " . $record['lastName']) == strtolower($realname))
    {
        $correct = true;
    }
    
    // update stats
    $sql = "update guesses set ";
    
    if ($correct)
    {
        $sql .= " correct = correct+1 ";
    }
    else
    {
        $sql .= " incorrect = incorrect+1 ";
    }
    
    $sql .= " where superhero = '" . $hero . "'";
    
    // should have a transaction
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // get the correct and incorrect answers
    $sql = "select superhero, correct, incorrect from guesses where superhero = :name";
    $namedParameters = array();
    $namedParameters[":name"] = $hero;
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($namedParameters);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //echo "sql = " . $sql;
    
    // send results
    $return = $_POST;
    
    if ($correct)
    {
        $return["testresult"] = "1";
    }
    else
    {
        $return["testresult"] = "0";
    }
    
    $return["correct"] = $record["correct"];
    $return["incorrect"] = $record["incorrect"];
    $return["json"] = json_encode($return);
    
    //echo json_encode($return["testresult"]);
    //echo json_encode($return["correct"]);
    echo json_encode($return["json"]);
    return true;
}

?>