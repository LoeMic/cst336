<?php
    // link the functions
    include 'functions.php';
    session_start();
    
    $id = NULL;

    // check for an id passed in - if yes, edit.  if no, add
    if (isset($_REQUEST['id']) AND $_SERVER['REQUEST_METHOD'] != 'POST')
    {
        $id = $_REQUEST['id'];
        
        // find the contact record
        foreach ($_SESSION['contactList'] as $contact)
        {
            // look for matching id and pull values
            if ($contact['id'] == $id)
            {
                // set the form variables
                $fname = $contact['fname'];
                $lname = $contact['lname'];
                $phone = $contact['phone'];
                $email = $contact['email'];
                $pref = $contact['pref'];
                $country = $contact['country'];
                
                break;
            }
        }
    }
    
    // error display variables
    $fnameErr = "";
    $lnameErr = "";
    $phoneErr = "";
    $emailErr = "";
    $prefErr = "";
    $countryErr = "";
    
    // save display variable
    $saveResponse = "";
    
    // form submitted - validate and save
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        /*
        // testing
        echo 'last was post';
        */
        
        $valid = true;
        
        $id = $_POST['id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $pref = $_POST['pref'];
        $country = $_POST['country'];
        
        if (!isset($fname) OR empty($fname))
        {
            $fnameErr = '<br />First Name is required';
            $valid = false;
        }
        
        if (!isset($lname) OR empty($lname))
        {
            $lnameErr = '<br />Last Name is required';
            $valid = false;
        }
        
        if (isset($phone) AND !empty($phone) AND !preg_match('/^\d+$/', $phone))
        {
            $phoneErr = '<br />Submit numbers only';
            $valid = false;
        }
        
        if (!isset($email) OR empty($email))
        {
            $emailErr = '<br />Email is required';
            $valid = false;
        }
        if (!isset($pref))
        {
            $prefErr = '<br />Contact Preference is required';
            $valid = false;
        }
        if (isset($pref) AND $pref == '0' AND empty($phone))
        {
            $prefErr = '<br />Cannot select phone if no phone entered';
            $valid = false;
        }
        
        if ($valid)
        {
            saveContact($id, $fname, $lname, $phone, $email, $pref, $country);
            $saveResponse = "<br/>Saved successfully<br/>";
            
            // if this was a prior add, the id would not be set
            if (!isset($id) OR $id == NULL)
            {
                $id = $_SESSION['maxId'];
            }
        }
        else
        {
            $saveResponse = "<br/>Fix errors and retry<br/>";
        }
    }

?>
<html>
    <head>
        <title> HW3 - Contact Management </title>
        <meta charset="utf-8" />
        <style>
            @import "css/style.css";
        </style>
        <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet">
        <script src="scripts/scripts.js"></script>
    </head>
    <body>
        <header>
        <h1> HW3 - Contact Management </h1>
        </header>
        <nav>
            <h3><a href="index.php">Contact List</a>
            &nbsp;&nbsp;
            Form</h3>
        </nav>
        <h3> <?= !isset($id) ? 'Add' : 'Update';?> Contact </h3>
        
    <?php
        /*
        // test - display the form variables
        echo 'id = ' . $id;
        echo '<br>empty(id) = ' . empty($id);
        echo '<br>maxid = ' . $_SESSION['maxId'];
        echo '<br>fname = ' . $fname;
        echo '<br>lname = ' . $lname;
        echo '<br>phone = ' . $phone;
        echo '<br>email = ' . $email;
        echo '<br>pref = ' . $pref;
        echo '<br>country = ' . $country;
        echo '<br>';
        */
    ?>
    
        <form name='contactForm' method='POST'>
        <table>
            <input type='hidden' name='id' id='id' value='<?= $id ?>'></input>
            <tr>
                <td class='contact'>
                    <label for='fname'>First Name: </label><span class='req'>*</span>
                </td>
                <td class='contact'>
                    <input type='text' name='fname' id='fname' value='<?=$fname?>'></input>
                    <span class='err'><?=$fnameErr?></span>
                </td>
            </tr>
            <tr>
                <td class='contact'>
                    <label for='lname'>Last Name: </label><span class='req'>*</span>
                </td>
                <td class='contact'>
                    <input type='text' name='lname' id='lname' value='<?=$lname?>'></input>
                    <span class='err'><?=$lnameErr?></span>
                </td>
            </tr>
            <tr>
                <td class='contact'>
                    <label for='phone'>Phone Number: </label>
                </td>
                <td class='contact'>
                    <input type='text' name='phone' id='phone' value='<?=$phone?>'></input>
                    <span class='err'><?=$phoneErr?></span>
                </td>
            </tr>
            <tr>
                <td class='contact'>
                    <label for='email'>Email Address: </label><span class='req'>*</span>
                </td>
                <td class='contact'>
                    <input type='text' name='email' id='email' value='<?=$email?>'></input>
                    <span class='err'><?=$emailErr?></span>
                </td>
            </tr>
            <tr>
                <td class='contact'>
                    <label for='pref'>Contact Preference: </label><span class='req'>*</span>
                </td>
                <td class='contact'>
                    <input type='radio' name='pref' id='pref' value='0' <?= $pref=='0' ? 'checked' : ''?>>phone</input><br/>
                    <input type='radio' name='pref' id='pref' value='1' <?= $pref=='1' ? 'checked' : ''?>>email</input><br/>
                    <input type='radio' name='pref' id='pref' value='2' <?= $pref=='2' ? 'checked' : ''?>>none</input>
                    <span class='err'><?=$prefErr?></span>
                </td>
            </tr>
            <tr>
                <td class='contact'>
                    <label for='country'>Country: </label>
                </td>
                <td class='contact'>
                    <select name='country' id='country'>
                        <option value=''>Select an option -- </option>
                        <option value='us' <?= $country=='us' ? 'selected' : ''?>>US</option>
                        <option value='uk' <?= $country=='uk' ? 'selected' : ''?>>UK</option>
                        <option value='ca' <?= $country=='ca' ? 'selected' : ''?>>CA</option>
                        <option value='mx' <?= $country=='mx' ? 'selected' : ''?>>MX</option>
                        <option value='es' <?= $country=='es' ? 'selected' : ''?>>ES</option>
                        <option value='fr' <?= $country=='fr' ? 'selected' : ''?>>FR</option>
                        <option value='it' <?= $country=='it' ? 'selected' : ''?>>IT</option>
                    </select>
                </td>
            </tr>
        </table>
        
        <br/>
        <button type='submit' name='save' value='<?=isset($id) ? 'Update' : 'Add'?>'><?=isset($id) ? 'Update' : 'Add'?></button> &nbsp;&nbsp; 
        <button value="Cancel" onclick='window.location.replace("index.php");'>Cancel</button>
        
        </form>
        
        <span class="err"><?=$saveResponse?></span>

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