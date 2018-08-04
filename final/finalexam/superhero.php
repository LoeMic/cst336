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

?>

<html>
    <head>
        <title> Superhero Quiz </title>
        <meta charset="utf-8" />

        <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet">
        
        <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
        <script language="javascript">
            
            $(document).ready(function() {
               
                $("#tryName").click(function() {

                    // update span to show the spinning image
                    $("#response").html("<img src='img/loading.gif'>");

                    var superhero = $("#superhero").val();                    
                    var realname = $("#heroRealName option:selected").val();
                    
                    if (realname == null || realname == "")
                    {
                        $("#response").css("color","red");
                        $("#response").html("Select a name!");
                        return;
                    }
                    
                    /*
                    alert('trying name values\n' +
                            ' hero: ' + superhero + '\n' +
                            ' name: ' + realname);
                    */
                    
                    // do the test
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "superheroapp.php",
                        data: {"action": "checkname", "hero": superhero, "realname": realname},
                        
                        success: function(data) {
                            //alert('handleResponse');
                            
                            // "{\"action\":\"checkname\",\"hero\":\"The Hulk\",\"realname\":\"Bruce Banner\",\"testresult\":\"1\",\"correct\":\"1\",\"incorrect\":\"0\"}"
                            
                            var response = JSON.parse(data);
                            
                            //alert(JSON.stringify(response));
                            
                            if (response.testresult == 1)
                            {
                                $("#response").css("color","green");
                                $("#response").html("That's correct!<br>correct: " + response.correct + "<br>incorrect: " + response.incorrect);
                            }
                            else
                            {
                                $("#response").css("color","red");
                                $("#response").html("That's not correct!<br>correct: " + response.correct + "<br>incorrect: " + response.incorrect);
                            }
                            
                            //alert("correct = " + response.correct + "\nincorrect = " + response.incorrect);
                            
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            //alert(xhr.status);
                            //alert(thrownError);
                        },
                        complete: function () {
                            //alert('complete');
                        }
                    });
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
        <header><h1>Superhero Quiz</h1></header>
        <br />
        
        <div class="superhero">
            <h3>What is this Superhero's real name?</h3>
            <br />
            
            <?php
            
            echo "<img src=\"img/superheroes/" . $record['image'] . ".png\" alt=\"" . $record['name'] . "\">";
            echo "<br /><br />";
            echo "<input type='hidden' id='superhero' value='" . $record['name'] . "'/>";
            echo "<select name='heroRealName' id='heroRealName'>";
            echo "  <option value=''>Select One</option>";
            
            foreach ($records as $hero)
            {
                $name = $hero['firstname'] . " " . $hero['lastname'];
                echo "  <option value=\"$name\">$name</option>";
            }
            
            echo "</select>";
            
            ?>
            
        </div>
        <br />
        <input type="button" class="btn btn-danger" id="tryName" value="Check Answer"/>
        <br /><br />
        <span id="response"></span>
        
        <br /><br />
        <hr>
        <br />
           
  <table border="1" width="600" cellpadding="10px">
    <tbody><tr><th>#</th><th>Task Description</th><th>Points</th></tr>
     <tr style="background-color:#99E999">
      <td>1</td>
      <td>A random image of a superhero is displayed when refreshing the page <br></td>
      <td width="20" align="center">15</td>
     </tr>     
     <tr style="background-color:#99E999">
      <td>2</td>
      <td><p>The "real names" of the superheroes in the dropdown menu come from the database (without duplicates and in alphabetical order) <br>
        </p></td>
      <td width="20" align="center">15</td>
    </tr>     
     <tr style="background-color:#99E999">
      <td>3</td>
      <td>An error message is displayed if the user clicks on the "Check Answer" button without selecting anything. <br></td>
      <td width="20" align="center">10</td>
    </tr>     
     <tr style="background-color:#99E999">
      <td>4</td>
      <td>The right color-coded feedback (correct or incorrect) is displayed upon clicking on the "Check Answer" button <br></td>
      <td width="20" align="center">15</td>
    </tr>     
     <tr style="background-color:#99E999">
      <td>5</td>
      <td>The number of times the real name for the specific superhero has been answered correctly and incorrectly is stored in the database, via AJAX (you'll need to create a new table, you decide the structure)<br></td>
      <td width="20" align="center">15</td>
    </tr>     

     <tr style="background-color:#99E999">
      <td>6</td>
      <td>The updated number of times for total of correct and incorrect answers (for the specific superhero) is displayed, via AJAX <br></td>
      <td width="20" align="center">15</td>
    </tr>
     
     <tr style="background-color:#99E999">
      <td>7</td>
      <td>The spinning images (indicating that data is being loaded) are displayed and replaced when the data is retrieved, via AJAX</td>
      <td width="20" align="center">5</td>
    </tr> 

     <tr style="background-color:#99E999">
      <td>8</td>
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