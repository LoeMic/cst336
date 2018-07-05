<?php

// link the functions
include 'functions.php';
session_start();

$title = '';

if (isset($_GET['addItem']))
{
    $title = 'Add New Review';
}
elseif (isset($_GET['editItem']))
{
    $title = 'Edit Review';    
}

/*
// check for add item submission
if (isset($_POST['AddItem']))
{
    // test the form elements
    $name = $_POST['name'];
    $category = $_POST['category'];
    $rating = $_POST['rating'];
    $price = $_POST['price'];
    $imageSm = $_POST['imageSm'];
    $imageLg = $_POST['imageLg'];
    $reviewText = $_POST['reviewText'];

    // get the entered values from the form
    //addReview($_POST['name'],$_POST['category'], $_POST['price'], $_POST['imageSm'], $_POST['imageLg'], $_POST['reviewText']);
}
*/

?>

<!DOCTYPE html>
<html>
    <head>
        <title> The World of Fuzz - Reviews by Mike Loeser</title>
        <meta charset="utf-8" />
        <style>
            @import "css/style.css";
        </style>
        <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet">
        <script src="scripts/lightbox.js" type="text/javascript"></script>
    </head>
    <body>
        <header>
        <h1> The World of Fuzz </h1>
        <h3> Pedal Reviews by Mike Loeser </h3>
        </header>

        <br />

        <span id='formTitle'><?=$title?></span>
        <form method='post' id='pedalForm' action="#">
            <input type='hidden' id='testAction' name='testAction' value='add'>
            <table class='additem'>
                <tr>
                    <td>
                        <label for='pname'>Pedal Name</label>
                        <input type='text' id='name' name='name' required value='<?php echo $name;?>'>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for='category'>Category</label>
                        <select id='category' id='category' name='category' required value="<?php echo $category;?>">
                            <option value='Fuzz'>Fuzz</option>
                            <option value='Overdrive'>Overdrive</option>
                            <option value='Distortion'>Distortion</option>
                            <option value='Boost'>Boost</option>
                            <option value='Delay'>Delay</option>
                            <option value='Reverb'>Reverb</option>
                            <option value='EQ'>EQ</option>
                            <option value='Phaser'>Phaser</option>
                            <option value='Flanger'>Flanger</option>
                            <option value='Wah'>Wah</option>
                            <option value='Looper'>Looper</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for='rating'>Rating</label>
                        <input type='radio' id='rating' name='rating' value='0' required
                            <?php if (isset($rating) && $rating==0) echo "checked";?> >0 Stars</input>
                        <br />
                        <input type='radio' id='rating' name='rating' value='1'
                            <?php if (isset($rating) && $rating==1) echo "checked";?> >1 Star</input>
                        <br />
                        <input type='radio' id='rating' name='rating' value='2'
                            <?php if (isset($rating) && $rating==2) echo "checked";?> >2 Stars</input>
                        <br />
                        <input type='radio' id='rating' name='rating' value='3'
                            <?php if (isset($rating) && $rating==3) echo "checked";?> >3 Stars</input>
                        <br />
                        <input type='radio' id='rating' name='rating' value='4'
                            <?php if (isset($rating) && $rating==4) echo "checked";?> >4 Stars</input>
                        <br />
                        <input type='radio' id='rating' name='rating' value='5'
                            <?php if (isset($rating) && $rating==5) echo "checked";?> >5 Stars</input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for='price'>Price</label>
                        <input type='text' id='price' name='price' required value="<?php echo $price;?>"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for='imageSm'>Small Image URL</label>
                        <input type='text' id='imageSm' name='imageSm' value="<?php echo $imageSm;?>"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for='imageLg'>Large Image URL</label>
                        <input type='text' id='imageLg' name='imageLg' value="<?php echo $imageLg;?>"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for='reviewText'>Review Text</label>
                        <textarea id='reviewText' name='reviewText' required><?php echo $reviewText;?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type='submit' value='submit'>Add Item</button>&nbsp;
                        <button type='reset' value='Cancel' onclick='hideForm();'>Cancel</button>
                    </td>
                </tr>
            </table>
        </form>
        <!-- The footer goes inside the body but not always -->
        <footer>
            <br /><br />
            <hr id="hr_footer" />
            
            page views: <?php echo rand(100,1000); ?>
            
            <br />
            <p id="footer">
                &copy; Mike Loeser - 2018<br>
                The information provided here is for academic purposes only
                <br /><br />
                <a href="http://www.csumb.edu"><img src="img/csumb_icon.png" alt="CSU Monterey Bay"></a>
            </p>
        </footer>
        <!-- closing footer -->
    </body>
</html>