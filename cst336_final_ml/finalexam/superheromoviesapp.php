<?php

session_start();
include 'dbConnection.php';

$conn = getDatabaseConnection('final');

//{"action": "checkname", hero: superhero, realname: realname}

if (is_ajax()) {
    if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
        $action = $_POST["action"];
        
        switch($action) { //Switch case for value of action
            case "searchmovies":
                
                //echo "in searchmovies";
                
                $hero = $_POST["hero"];
                
                searchMovies($hero, $realname);
                break;
                
            case "getdetails":
                
                // echo "in getdetails...";
                
                $hero = $_POST["hero"];
                
                getDetails($hero);
                break;
        }
    }
}

function searchMovies($hero)
{
    $return = $_POST;
    
    $_SESSION["searchHistory"] .= " " . $hero . " ";
    
    // update the session value
    $return["searchhistory"] = $_SESSION["searchHistory"];
    
    
    // do the api search
    
    $return["json"] = json_encode($return);
    
    echo json_encode($return["json"]);
    return true;
}

function getDetails($hero)
{
    global $conn;
    
    // retrieve the details from db
    
    // return the info in json
    
    echo json_encode($return["json"]);
    return true;
}

//Function to check if the request is an AJAX request
function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

?>