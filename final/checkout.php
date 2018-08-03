<?php
    session_start();
    
    // link the functions
    include 'functions.php';
    
    $successMessage = "";
    
    // handle the form inputs and validation
    if (isset($_POST['fname']))
    {
        // do the insert
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $address1 = $_POST['address1'];
        $address2 = $_POST['address2'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $postalcode = $_POST['postalcode'];
        $tendertype = $_POST['tendertype'];
        
        // pass the whole cart object
        $result = saveTransaction($fname, $lname, $email, $address1, $address2, $city, $state, $postalcode, $tendertype, $_SESSION['cart']);
        
        //echo "result = " . $result;
        
        // set the message and block the submit button
        if ($result)
        {
            $successMessage = "<div class='txncomp'>Transaction Completed<br />cart is empty</div><br />";
        
            // reset the cart
            unset($_SESSION['cart']);
        }
    }
?>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            @import "css/styles.css";
        </style>
        
        <title> E-Shop Site - Checkout </title>

        <script language="javascript">
        function ValidateForm()
        {
            $("#btnSubmit").attr("disabled", true);
            
            // reset the error displays
            $("#fnameErr").html("");
            $("#lnameErr").html("");
            $("#emailErr").html("");
            $("#email2Err").html("");
            $("#address1Err").html("");
            $("#cityErr").html("");
            $("#stateErr").html("");
            $("#postalcodeErr").html("");
            $("#tendertypeErr").html("");
            $("#saveResponse").html("");
            
            var valid = true;
            var fname = $("#fname").val();
            var lname = $("#lname").val();
            var email = $("#email").val();
            var email2 = $("#email2").val();
            var address1 = $("#address1").val();
            var address2 = $("#address2").val();
            var city = $("#city").val();
            var state = $("#state option:selected").val();
            var postalcode = $("#postalcode").val();
            var tendertype = $("#tendertype option:selected").val();
            
            if (fname == "")
            {
                $("#fnameErr").html('<br />First Name is required');
                valid = false;
            }
            if (lname == "")
            {
                $("#lnameErr").html('<br />Last Name is required');
                valid = false;
            }
            if (email == "")
            {
                $("#emailErr").html('<br />Email is required');
                valid = false;
            }
            if (email != email2)
            {
                $("#email2Err").html('<br />Email does not match');
                valid = false;
            }
            
            if (address1 == "")
            {
                $("#address1Err").html('<br />Address1 is required');
                valid = false;
            }
            if (city == "")
            {
                $("#cityErr").html('<br />City is required');
                valid = false;
            }
            if (state == "")
            {
                $("#stateErr").html('<br />State is required');
                valid = false;
            }
            if (postalcode == "")
            {
                $("#postalcodeErr").html('<br />Postal Code is required');
                valid = false;
            }
            if (tendertype == "")
            {
                $("#tendertypeErr").html('<br />Tender Type is required');
                valid = false;
            }
            
            //alert("valid = " + valid);
            
            if (!valid)
            {
                // apply the error displays
                // stop the page process from reloading
                event.stopPropagation();
                
                $("#saveResponse").html("<br/>Fix errors and retry<br/>");
                
                $("#btnSubmit").attr("disabled", false);
                
                return false;
            }
            
            return true;
        }
        </script>
    </head>
    <body>
        <div class='container'>
            <div class="text-center">
                <!-- cart image -->
                <!-- number of items in cart -->
                <!-- Bootstrap Navagation Bar -->
                <nav class='navbar navbar-default - navbar-right'>
                    <ul class='nav navbar-nav'>
                        <li><a href='index.php'>Home</a></li>
                        <li><a href='cart.php'>
                            <span class='glyphicon glyphicon-shopping-cart' aria-hidden='true'></span>
                            Cart: <span id='cartCount'><?php displayCartCount(); ?></span> </a></li>
                        <li><a href='login.php'>Login</a></li>
                    </ul>
                </nav>
                <br /><br />
                <div class="page-header"><h1> E-Shop Site </h1><h4>Checkout</h4></div>
                
                <?=$successMessage?>
                
                <!-- checkout form -->
                <?php displayCheckoutTotals() ?>
                <br/>
                
                <span class="err" id="saveResponse"></span>
                
                <form method="post" class="form-inline" id="form" name="form" onsubmit="return ValidateForm();">
                <div class='checkoutall'>
                    <div class='checkoutleft'>
                        <table class="form-group">
                            <tr><th class="custdatahead">Customer Data</th></tr>
                            <tr>
                                <td class='custdata' nowrap>
                                    <label for='fname'>First Name: </label><span class='req'>*</span>
                                    <input type='text' name='fname' id='fname' class='form-control' placeholder='first name'>
                                    <span id='fnameErr' class='err'></span>
                                </td>
                            </tr>
                            <tr>
                                <td class='custdata' nowrap>
                                    <label for='lname'>Last Name: </label><span class='req'>*</span>
                                    <input type='text' name='lname' id='lname' class='form-control' placeholder='last name'>
                                    <span id='lnameErr' class='err'></span>
                                </td>
                            </tr>
                            <tr>
                                <td class='custdata' nowrap>
                                    <label for='email'>Email Address: </label><span class='req'>*</span>
                                    <input type='text' name='email' id='email' class='form-control' placeholder='email address'>
                                    <span id='emailErr' class='err'></span>
                                </td>
                            </tr>
                            <tr>
                                <td class='custdata' nowrap>
                                    <label for='email2'>Validate Email Address: </label><span class='req'>*</span>
                                    <input type='text' name='email2' id='email2' class='form-control' placeholder='email address'>
                                    <span id='email2Err' class='err'></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class='checkoutright'>
                        <table class="form-group">
                            <tr><th class="custdatahead">Shipping Info</th></tr>
                            <tr>
                                <td class='custdata' nowrap>
                                    <label for='address1'>Address1: </label><span class='req'>*</span>
                                    <input type='text' name='address1' id='address1' class='form-control' placeholder='street address'>
                                    <span id='address1Err' class='err'></span>
                                </td>
                            </tr>
                            <tr>
                                <td class='custdata' nowrap>
                                    <label for='address2'>Address2: </label>
                                    <input type='text' name='address2' id='address2' class='form-control' placeholder='street address 2'>
                                    <span id='address2Err' class='err'></span>
                                </td>
                            </tr>
                            <tr>
                                <td class='custdata' nowrap>
                                    <label for='city'>City: </label><span class='req'>*</span>
                                    <input type='text' name='city' id='city' class='form-control' placeholder='city'>
                                    <span id='cityErr' class='err'></span>
                                </td>
                            </tr>
                            <tr>
                                <td class='custdata' nowrap>
                                    <label for='state'>State: </label><span class='req'>*</span>
                                    <select name='state' id='state' class='form-control'>
                                    	<option value="">Select State</option>
                                    	<option value="AL">Alabama</option>
                                    	<option value="AK">Alaska</option>
                                    	<option value="AZ">Arizona</option>
                                    	<option value="AR">Arkansas</option>
                                    	<option value="CA">California</option>
                                    	<option value="CO">Colorado</option>
                                    	<option value="CT">Connecticut</option>
                                    	<option value="DE">Delaware</option>
                                    	<option value="DC">District Of Columbia</option>
                                    	<option value="FL">Florida</option>
                                    	<option value="GA">Georgia</option>
                                    	<option value="HI">Hawaii</option>
                                    	<option value="ID">Idaho</option>
                                    	<option value="IL">Illinois</option>
                                    	<option value="IN">Indiana</option>
                                    	<option value="IA">Iowa</option>
                                    	<option value="KS">Kansas</option>
                                    	<option value="KY">Kentucky</option>
                                    	<option value="LA">Louisiana</option>
                                    	<option value="ME">Maine</option>
                                    	<option value="MD">Maryland</option>
                                    	<option value="MA">Massachusetts</option>
                                    	<option value="MI">Michigan</option>
                                    	<option value="MN">Minnesota</option>
                                    	<option value="MS">Mississippi</option>
                                    	<option value="MO">Missouri</option>
                                    	<option value="MT">Montana</option>
                                    	<option value="NE">Nebraska</option>
                                    	<option value="NV">Nevada</option>
                                    	<option value="NH">New Hampshire</option>
                                    	<option value="NJ">New Jersey</option>
                                    	<option value="NM">New Mexico</option>
                                    	<option value="NY">New York</option>
                                    	<option value="NC">North Carolina</option>
                                    	<option value="ND">North Dakota</option>
                                    	<option value="OH">Ohio</option>
                                    	<option value="OK">Oklahoma</option>
                                    	<option value="OR">Oregon</option>
                                    	<option value="PA">Pennsylvania</option>
                                    	<option value="RI">Rhode Island</option>
                                    	<option value="SC">South Carolina</option>
                                    	<option value="SD">South Dakota</option>
                                    	<option value="TN">Tennessee</option>
                                    	<option value="TX">Texas</option>
                                    	<option value="UT">Utah</option>
                                    	<option value="VT">Vermont</option>
                                    	<option value="VA">Virginia</option>
                                    	<option value="WA">Washington</option>
                                    	<option value="WV">West Virginia</option>
                                    	<option value="WI">Wisconsin</option>
                                    	<option value="WY">Wyoming</option>
                                    	<option value="AS">American Samoa</option>
                                        <option value="GU">Guam</option>
                                        <option value="MP">Northern Mariana Islands</option>
                                        <option value="PR">Puerto Rico</option>
                                        <option value="UM">United States Minor Outlying Islands</option>
                                        <option value="VI">Virgin Islands</option>
                                        <option value="AA">Armed Forces Americas</option>
                                        <option value="AP">Armed Forces Pacific</option>
                                        <option value="AE">Armed Forces Others</option>
                                    </select>
                                    <span id='stateErr' class='err'></span>
                                </td>
                            </tr>
                            <tr>
                                <td class='custdata' nowrap>
                                    <label for='postalcode'>Postal Code: </label><span class='req'>*</span>
                                    <input type='text' name='postalcode' id='postalcode' class='form-control' placeholder='postal code'>
                                    <span id='postalcodeErr' class='err'></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br/>
                <div class='checkoutall'>
                    <table class="form-group">
                        <tr><th class="custdatahead">Payment Method</th></tr>
                        <tr>
                            <td class='custdata' nowrap>
                                <label for='tendertype'>Tender Type: </label><span class='req'>*</span>
                                <select name='tendertype' id='tendertype' class='form-control'>
                                    <option value=''>Select Tender</option>
                                    <option value='visa'>Visa</option>
                                    <option value='mc'>MasterCard</option>
                                    <option value='disc'>Discover</option>
                                    <option value='apple'>Apple Pay</option>
                                    <option value='samsung'>Samsung Pay</option>
                                </select>
                                <span id='tendertypeErr' class='err'></span>
                            </td>
                        </tr>
                    </table>
                </div>
                <br />
                <input type='submit' id='btnSubmit' name='btnSubmit' class='btn btn-danger' value='Complete Transaction' <?=empty($successMessage) ? '' : 'disabled'?> ></input>
                </form>
            </div>
        </div>
        
        <?php displayFooter(); ?>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </body>
</html>
