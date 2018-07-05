<?php
    // link the functions
    include 'functions.php';
    session_start();
    
    // check for the contact list
    if (!isset($_SESSION['contactList']))
    {
        $_SESSION['contactList'] = array();
        $_SESSION['maxId'] = 0;
        
        // testing
        saveContact(NULL, 'default-first', 'default-last', '2348765467', 'testemail', 0, 'mx');
        saveContact(NULL, 'default-first2', 'default-last2', '9999999999', 'testemail2', 1, 'fr');
    }
    
    if (isset($_REQUEST['delete']))
    {
        deleteContact($_REQUEST['delete']);
    }
    
    $contacts = &$_SESSION['contactList'];
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
            <h3>Contact List
            &nbsp;&nbsp;
            <a href="editform.php?addNew">Form</a></h3>
        </nav>
        <br />
        
        <table>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone Number</th>
                <th>Email Address</th>
                <th>Contact Pref</th>
                <th>Country</th>
                <th></th>
            </tr>
            
    <?php

    // loop through the contacts in the list
    if (isset($contacts))
    {
        foreach ($contacts as $contact)
        {

    ?>

            <tr id='contact" . $contact['id'] . "'>
                <td class='contact'>
                    <span class='show'><?=$contact['fname']?></span>
                </td>
                <td class='contact'>
                    <span class='show'><?=$contact['lname']?></span>
                </td>
                <td class='contact'>
                    <span class='show'><?=$contact['phone']?></span>
                </td>
                <td class='contact'>
                    <span class='show'><?=$contact['email']?></span>
                </td>
                <td class='contact'>
                    <span class='show'><?=getContactPreferenceDisplay($contact['pref'])?></span>
                </td>
                <td class='contact'>
                    <span class='show'><?=getCountryDisplay($contact['country'])?></span>
                </td>
                <td class='contact'>
                    <span class='show'><a alt='edit' href='editform.php?id=<?=$contact['id'] ?>'>edit</a></span>
                    &nbsp;&nbsp;
                    <span class='show'><a alt='delete' href='./?delete=<?=$contact['id'] ?>'>delete</a></span>
                </td>
            </tr>
            
    <?php
        }
    }

    ?>
        </table>

        <br /><br />
        <a href="editform.php?addNew" alt="Add Contact">Add Contact</a>

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