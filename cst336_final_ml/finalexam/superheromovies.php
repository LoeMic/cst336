<?php
session_start();
    
include 'dbConnection.php';

$conn = getDatabaseConnection("final");

$sql = "select distinct name, firstname, lastname, image, pob from superhero ORDER BY firstname";
$statement = $conn->prepare($sql);
$statement->execute();
$records = $statement->fetchAll(PDO::FETCH_ASSOC);

// find a randon superhero
$superCount = count($records);
$displayRecord = rand ( 0 , $superCount-1 );

// grab that superhero record
$record = $records[$displayRecord];

//https://www.omdbapi.com/?s=thor&apikey=12215ee6

if (!isset($_SESSION["searchHistory"]))
{
    $_SESSION["searchHistory"] = "";
}
?>

<html>
    <head>
        <title> Superhero Movies </title>
        <meta charset="utf-8" />

        <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet">
        
        <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script language="javascript">
            
            $(document).ready(function() {
                $("#searchMoviesBtn").click(function() {
                    // make an ajax call to get the session data
                    
                    $("#resultDisplay").html("");
                    
                    var hero = $("#heroselect option:selected").val();
                    
                    // check for a value
                    if (hero == null || hero == "")
                    {
                        $("#resultDisplay").html("<span style='color:red;'>Please select a superhero</span>");
                        return;
                    }
                    
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "superheromoviesapp.php",
                        data: {"action": "searchmovies", "hero": hero},
                        
                        success: function(data) {
                            // "{\"action\":\"checkname\",\"hero\":\"The Hulk\",\"realname\":\"Bruce Banner\",\"testresult\":\"1\",\"correct\":\"1\",\"incorrect\":\"0\"}"
                            
                            //alert(JSON.stringify(data));
                            //var response = JSON.parse(data["json"]);
                            
                            //alert(JSON.stringify(response));

                            // display the search results
                            $("#resultDisplay").html("movie history data updated");
                            
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status);
                            alert(thrownError);
                        },
                        complete: function () {
                            //alert('complete');
                        }
                    });
                });
                
                $("#showDetailsBtn").click(function() {
                    $("#resultDisplay").html("");
                });
                
                $("#showHistoryBtn").click(function() {
                    
                    $("#resultDisplay").html("<iframe src='superheromoviesiframe.php' name='searchhistory' height='200' width='400'></iframe>");
                    
                });
            });
        </script>
        <style>
            html {
                margin: 0 auto;
                text-align: center;
            }
            
            table {
                margin-left: auto;
                margin-right: auto;
            }
        </style>
    </head>
    <body>
        
        <header><h1>Select Superhero:</h1></header>
        <br />
        
        <div class="superhero">
            
            <select name="heroselect" id="heroselect">
                <option value="">Select One</option>
            <?php
            
            foreach ($records as $hero)
            {
                echo "  <option value=\"". $hero['name'] . "\">". $hero['name'] . "</option>";
            }
            
            ?>
            
            </select>
            <br><br>
            <button id="searchMoviesBtn" name="searchmoviesBtn">Search Movies</button>
            <br><br>
            <button id="showDetailsBtn" name="showDetailsBtn">Superhero Details</button>
            <br><br>
            <button id="showHistoryBtn" name="showHistoryBtn">Show Search History</button>
        </div>
        <br />
        
        <div id="resultDisplay"></div>

        <br /><br />

 
   <table border="1" width="600" cellpadding="10">
    <tbody><tr><th>#</th><th>Task Description</th><th>Points</th></tr>
    <tr style="background-color:#99E999">
      <td>1</td>
      <td>The list of the superheroes in the dropdown menu is retrieved from the database (ordered alphabetically, no duplicates)<br></td>
      <td width="20" align="center">10</td>
    </tr> 
    <tr style="background-color:#FFC0C0">
      <td>2</td>
      <td>When clicking on the "Search Movies" button, the OMDB API is used to display the list of movies (<strong>poster</strong> and <strong>title</strong>) for the superhero selected<br></td>
      <td width="20" align="center">15</td>
    </tr>  
     <tr style="background-color:#99E999">
      <td>3</td>
      <td> When clicking on the "Search Movies" button, the superhero selected is stored in a Session variable using AJAX<br></td>
      <td width="20" align="center">15</td>
    </tr>
     <tr style="background-color:#99E999">
      <td>4</td>
      <td> When clicking on the "See Search History" link, the superheroes whose movies have been searched are displayed within an iFrame</td>
      <td width="20" align="center">15</td>
    </tr>   
     <tr style="background-color:#FFC0C0">
      <td>5</td>
      <td> When clicking on the "Superhero Details" button, an AJAX call is made to display all corresponding info (name, image, and pob)<br></td>
      <td width="20" align="center">15</td>
    </tr>  
     <tr style="background-color:#FFC0C0">
      <td>6</td>
      <td>When clicking on the "Superhero Details" button, the name and images of the superhero's enemies are displayed<br></td>
      <td width="20" align="center">10</td>
    </tr>
    <tr style="background-color:#99E999">
      <td>7</td>
      <td>This rubric is properly included AND UPDATED</td>
      <td width="20" align="center">2</td>
    </tr>       
     <tr>
      <td></td>
      <td>T O T A L </td>
      <td width="20" align="center">&nbsp;</td>
    </tr> 
  </tbody></table>
  

    </body>
</html>