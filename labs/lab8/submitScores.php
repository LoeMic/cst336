<?php
session_start();

include 'connect.php';
$connect = getDBConnection();

$score = $_POST['score'];

//Adding new score to database
$sql = "INSERT INTO scores (username, score)
            VALUES (:username, :score)";

$data = array(
            ":username" => $_SESSION['username'],
            ":score" => $score
        );
$stmt = $connect->prepare($sql);
$stmt->execute($data);

//Retrieving total times quiz has been submitted and average score for this user
$sql = "SELECT count(1) times, avg(score) average
        FROM scores
        WHERE username = :username";

$stmt = $connect->prepare($sql);
$stmt->execute(array(":username"=>$_SESSION['username']));
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Encoding data using JSON
echo json_encode($result);

?>