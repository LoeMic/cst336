<?php

session_start();

    /*
    contact list:
    first name
    last name
    phone number
    email address
    pref
    country
    */

function saveContact($id, $fname, $lname, $phone, $email, $pref, $country)
{
    // test for add - edit
    if (!isset($id) OR $id == NULL)
    {
        $contact = array();
    
        $_SESSION['maxId']++;
        
        $contact['id'] = $_SESSION['maxId'];
        $contact['fname'] = $fname;
        $contact['lname'] = $lname;
        $contact['phone'] = $phone;
        $contact['email'] = $email;
        $contact['pref'] = $pref;
        $contact['country'] = $country;
        
        array_push($_SESSION['contactList'], $contact);
    }
    else
    {
        /*
        // this is an edit
        echo 'this is an update';
        echo '<br />id - ' . $id;
        echo '<br />fname - ' . $fname;
        echo '<br />lname - ' . $lname;
        echo '<br />phone - ' . $phone;
        echo '<br />email - ' . $email;
        echo '<br />pref - ' . $pref;
        echo '<br />country - ' . $country;
        echo '<br />';
        */
        
        // find the record to update
        foreach ($_SESSION['contactList'] as &$contact)
        {
            if ($contact['id'] == $id)
            {
                $contact['fname'] = $fname;
                $contact['lname'] = $lname;
                $contact['phone'] = $phone;
                $contact['email'] = $email;
                $contact['pref'] = $pref;
                $contact['country'] = $country;       
            }
        }
    }
    
    return count($_SERVER['contactList']);
}

function getContactPreferenceDisplay($pref)
{
    if (!isset($pref))
    {
        return 'n/a';
    }
    elseif ($pref == 0)
    {
        return 'phone';
    }
    elseif ($pref == 1)
    {
        return 'email';
    }
    elseif ($pref == 2)
    {
        return 'none';
    }
}

function getCountryDisplay($country)
{
    if (!isset($country))
    {
        return 'n/a';
    }
    elseif ($country == 'us')
    {
        return 'United States';
    }
    elseif ($country == 'uk')
    {
        return 'United Kingdom';
    }
    elseif ($country == 'ca')
    {
        return 'Canada';
    }
    elseif ($country == 'mx')
    {
        return 'Mexico';
    }
    elseif ($country == 'es')
    {
        return 'Spain';
    }
    elseif ($country == 'fr')
    {
        return 'France';
    }
    elseif ($country == 'it')
    {
        return 'Italy';
    }
}

function deleteContact($id)
{

    for ($i = 0; $i < count($_SESSION['contactList']); $i++)
    {
        $contact = $_SESSION['contactList'][$i];
        
        if ($contact['id'] == $id)
        {
            // remove this item
            unset($_SESSION['contactList'][$i]);
            return;
        }
    }
}

?>