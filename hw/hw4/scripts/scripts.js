// JavaScript File
/*global jQuery*/
/*global $*/

var maxIdCookie = "MAX_ID";
var contactsCookie = "CONTACTS_LIST";

// start with string contact, convert to object, convert back to string and store in cookie
var contacts = {contacts: [
    {id: 1, firstName:"Mike", lastName:"Watt", phone:"9995551212", email:"m_watt@test.com", contactPref: 1, country:"us"},
    {id: 2, firstName:"D", lastName:"Boone", phone:"2123456789", email:"d_boone@test.com", contactPref: 0, country:"us"},
    {id: 3, firstName:"J", lastName:"Mascis", phone:"5555555555", email:"j_mascis@test.com", contactPref: 2, country:"us"},
    {id: 4, firstName:"Buzz", lastName:"Osbourne", phone:"", email:"buzz_o@test.com", contactPref: 1, country:"mx"},
    {id: 5, firstName:"Test", lastName:"User", phone:"", email:"test@test.com", contactPref: 1, country:"ca"}
]};

function checkUserCookie()
{
    // make sure we are setting the user cookie
    var tempContacts = getContactsList();
    if (tempContacts == null)
    {
        setContactsList(contacts);
    }
    else
    {
        // update to use the full contact list
        contacts = tempContacts;
    }
}

function saveContact(id, fname, lname, phone, email, contactPref, country)
{
    var success = false;
    
    // test for insert / update
    if (id == null || id <= 0)
    {
        // get the max id value from cookie
        var maxId = getMaxId();
        
        // increment the maxId value
        maxId++;

        // create a new contact element        
        var contact = {id: maxId, firstName: fname, lastName: lname, phone: phone, email: email, contactPref: contactPref, country: country};
        
        // save the contact in list
        contacts.contacts.push(contact);
        
        // save the updated maxId value
        saveMaxId(maxId);
        
        success = true;
    }
    else
    {
        var updated = false;
        var contact = null;

        $.each(contacts, function() {
            $.each(this, function() {
               if (this.id == id)
               {
                   found = true;
                   contact = this;
                   return false;
               }
            });
    
            // exit loop
            if (found)
            {
                return false;
            }
        });
        
        if (contact != null)
        {
            contact.firstName = firstName;
            contact.lastName = lastName;
            contact.phone = phone;
            contact.email = email;
            contact.contactPref = contactPref;
            contact.country = country;
            
            success = true;
        }

        // save data in cookie
        setCookie();

        return updated;
    }
}

function getContactPreferenceDisplay(pref)
{
    //alert(pref);
    switch (pref)
    {
        case 0:
            return 'phone';
        case 1:
            return 'email';
        case 2:
            return 'none';
        default:
            return 'n/a';
    }
}

function getCountryDisplay(country)
{
    //alert(country);
    switch (country.toLowerCase())
    {
        case 'us':
            return 'United States';
        case 'uk':
            return 'United Kingdom';
        case 'ca':
            return 'Canada';
        case 'mx':
            return 'Mexico';
        case 'es':
            return 'Spain';
        case 'fr':
            return 'France';
        case 'it':
            return 'Italy';
        default:
            return 'n/a';
    }
}

function getContactById(id)
{
    var index = 0;
    var found = false;
    var contact = null;

    $.each(contacts, function() {
        $.each(this, function() {
            contact = this;
       
            if (contact.id == id)
            {
                found = true;
                return false;
            }
        });

        if (found)
        {
            return false;
        }
    });
    
    return contact;
}

// delete the contact matching the incoming id
function deleteContact(id)
{
    var index = 0;
    var found = false;

    $.each(contacts, function() {
        $.each(this, function() {
            var contact = this;
       
           if (contact.id == id)
           {
               found = true;
               return false;
           }
           index++;
        });

        if (found)
        {
            return false;
        }
    });
    
    // see if matching id found
    if (found)
    {
        delete contacts[index];
        writeContactsList();
        return true;
    }
    
    return false;
}

// write the contacts into the 
function writeContactsList()
{
    var str = "<table>" +
            "<tr>" +
            "    <th class='chead'>First Name</th>" +
            "    <th class='chead'>Last Name</th>" +
            "    <th class='chead'>Phone Number</th>" +
            "    <th class='chead'>Email Address</th>" +
            "    <th class='chead'>Contact Pref</th>" +
            "    <th class='chead'>Country</th>" +
            "    <th class='chead'></th>" +
            "</tr>";

    // loop through the contact list
    $.each(contacts, function() {
        $.each(this, function() {
            var contact = this;
            
            // testing
            //alert("id = " + contact.id);
            
            str += "<tr>" +
                    "<td class='contact'>" + contact.firstName + "</td>" +
                    "<td class='contact'>" + contact.lastName + "</td>" +
                    "<td class='contact'>" + contact.phone + "</td>" +
                    "<td class='contact'>" + contact.email + "</td>" +
                    "<td class='contact'>" + getContactPreferenceDisplay(contact.contactPref) + "</td>" +
                    "<td class='contact'>" + getCountryDisplay(contact.country) + "</td>" +
                    "<td class='contact'>" +
                    "<a href='editform.html?id=" + contact.id + "' alt='Edit Contact'><button class='btn btn-success'>Edit</button></a>&nbsp;&nbsp;" +
                    "<button class='btn btn-success' id='deleteBtn' onclick='deleteContact(" + contact.id + ");'>Delete</button>" +
                    "</td>" +
                    "</tr>";
        });
    });
    str += "</table>";
    
    // testing
    //alert(str);
    
    // set the div content
    $("#contactDisplay").html(str);
}


// retrieve the maxid value from cookie
function getMaxId()
{
    return getCookie(maxIdCookie);
}

// save the updated maxId value in the cookie
function saveMaxId(maxId)
{
    setCookie(maxIdCookie, maxId);
}

function getContactsList()
{
    contactsJson = getCookie(contactsCookie);
    return JSON.parse(contactsJson);
}

function setContactsList(contacts)
{
    setCookie(contactsCookie, JSON.stringify(contacts))
}

// set the cookie value
function setCookie(key, value)
{
    var expires = new Date();
    //expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value;    // + ';expires=' + expires.toUTCString();
}

// retrieve the cookie data
function getCookie(key)
{
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}

function validateFormData()
{
    
}