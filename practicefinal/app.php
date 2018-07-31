<?php
if (is_ajax())
{
    if (isset($_POST["action"]) && !empty($_POST["action"]))
    { //Checks if action value exists
        $action = $_GET["action"];
        
        echo "action = " . $_GET["action"];
        echo "email = " . $_GET["email"];
        echo "score = " . $_GET["score"];
        
        //Switch case for value of action
        switch($action)
        {
            case "test":
                test_function();
                break;
            case "savescore":
                test_function();
                //saveScore($_GET["email"], $_GET["score"]);
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
    $return = array(
                "email" => $email,
                "attempt" => $score,
                "last" => $score,
                "numAttempts" => 199);
    

    //$return["objData"] = json_encode($return);
    
    $_POST["json"] = json_encode($return);
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
    echo json_encode($return);
}
?>