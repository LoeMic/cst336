<?php
if (is_ajax())
{
    if (isset($_POST["action"]) && !empty($_POST["action"]))
    { //Checks if action value exists
    
        echo "action = " . $_POST["action"] . "\n\n";
        echo "email = " . $_POST["email"] . "\n\n";
        echo "score = " . $_POST["score"] . "\n\n";

        //echo "data = " . $_POST["data"] . "\n\n";
        //echo json_decode($_POST['data'],true);        
        //echo "action = " . $obj.action . "\n";
        //echo "email = " . $obj.email . "\n";
        //echo "score = " . $obj.score . "\n";
        
        $action = $_POST["action"];
        
        //Switch case for value of action
        switch($action)
        {
            case "test":
                test_function();
                break;
            case "savescore":
                //echo "in savescore case\n";
                saveScore($_POST["email"], $_POST["score"]);
                break;
        }
    }
}

//Function to check if the request is an AJAX request
function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function saveScore($email, $score)
{
    //echo "in savescore function\n";
    /*
    $return = array(
                "email" => $email,
                "attempt" => $score,
                "last" => $score,
                "numAttempts" => 199);
    */

    $return = $_POST;
    $return["email"] = $email;
    $return["attempt"] = $score;
    $return["last"] = $score;
    $return["numAttempts"] = 199;

    $return["json"] = json_encode($return);
    
    //$_POST["json"] = json_encode($return);
    //echo json_encode($return);
}

function test_function()
{
    $return = $_POST;

    //Do what you need to do with the info. The following are some examples.
    //if ($return["favorite_beverage"] == "")
    //{
    //  $return["favorite_beverage"] = "Coke";
    //}
    //$return["favorite_restaurant"] = "McDonald's";
    
    $return["favorite_beverage"] = "Coke";
    $return["favorite_restaurant"] = "McDonald's";
    
    $return["json"] = json_encode($return);
    //echo json_encode($return);
}
?>