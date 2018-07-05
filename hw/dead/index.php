<?php
    // link the functions
    include 'functions.php';
    session_start();
    
    // initialize the session array
    if (!isset($_SESSION['reviews']))
    {
        $_SESSION['reviews'] = array();
        
        // build the initial set of reviews
        addReview('Way Huge - Russian Pickle', 'Fuzz', '4', '150', 'img/pickle_sm.jpg', 'img/pickle_lg.jpg',
            'I absolutely love the Way Huge pedals.  They are unique in their sound, 
            tend to focus on big sounds and massive sound shaping, and are designed by
            Jeorge Tripps, an absolute legend in pedal building since the early 90s.
            <br/><br/>
            The Russian Pickle is his take on the original Russian Big Muff from Electro-Harmonix.  
            It not only does that pedal justice, but steps things up considerably with a ton more volume, 
            more gain, and a more usable tone sweep.  For those that have used (and loved) the original
            Russian Big Muff Pi, you know there was a sweet spot on the tone for each of those pedals 
            and everything outside of that was either mud or sharp buzz.  The Tone for the Russian Pickle 
            gives many usable options while still giving enough adjustment to either cut through or push the 
            rhythm.
            <br /><br />
            The original Russian Big Muff was better built and not as flimsy as standard EHX pedals 
            of the time, but it had its issues.  The Way Huge pedal is built like an absolute tank.  
            The housing is aluminum and thicker than the normal sheet steel used for pedals, knobs 
            are their standard large pointed items with painted markers, and the switch feels like 
            it is ready to take years of abuse.  All of this is typical of the Way Huge line.
            <br /><br />
            The last, and possibly best, point to make is on price.  Way Huge is a division of 
            Jim Dunlop and so with their buying power and volume production, the WH line is kept 
            extremely reasonably priced.');
        
        addReview('Tone Bender - MkIII', 'Fuzz', '3', '250', 'img/bender_sm.jpg', 'img/bender_lg.jpg',
            'The Tone Bender is one of the earliest mass produced fuzz pedals and is still available 
            in many forms and in many copies today.  An absolute classic that shaped the sounds for 
            other later pedals like the big muff and its variants.
            <br /><br />
            This pedal is a bit of a one-hit wonder, but if you are into this sound, it hits it 
            right out of the park.  Big sound, good for single line notes and sludgy power chords.  
            This is a go-to for classic sounds.
            <br /><br />
            Price is where this pedal has its issues.  The originals still being made are more expensive 
            and have less features than many of the clones available on the market.  The classic 
            pedals can go for hundreds of dollars more.  I think I paid $250 for this one 
            and have lots of other clones and like-sounding pedals that I always go to first, 
            which says something.  Im happy I have it, but there are lots of options out there.');
        
        addReview('Death By Audio - Fuzz War', 'Fuzz', '5', '165', 'img/fuzzwar_sm.jpg', 'img/fuzzwar_lg.jpg',
            'I cant say enough about this pedal.  Its a constant on my board and has been a 
            major inspiration and piece of my sound since I first heard of Death By Audio as 
            a pedal builder.  The Fuzz War sounds absolutely massive.  MASSIVE!
            <br /><br />
            Details...  This is a thoroughly modern pedal with a ton of volume and a 
            unique sound.  Built with influences from a lot of the major fuzzes around, but 
            new and with its own thing going on.  It is both sludgy and thick while somehow 
            also staying articulate and bright.  The later 3 knob version is really the one 
            to get.  It has a wide sweep Tone knob that can get you a huge number of different 
            sounds.  This may be the only fuzz pedal you need!
            <br /><br />
            Another fun feature of the Fuzz War is how responsive it is to changes in your 
            guitar volume.  You can go from a light overdrive all the way to peeling paint  
            with a slight twist.
            <br /><br />
            This is an absolute new classic and easily worth the purchase price.');
    }
    
    // item selected from summary
    if (isset($_GET['id']))
    {
        $idx = $_GET['id'];
        
        // save to session
        $_SESSION['id'] = $idx;
    }

    // check for missing display index
    if (!isset($idx) && !isset($_SESSION['id']))
    {
        // this is the first time for display
        $idx = array_rand($_SESSION['reviews']);
        
        // save to session
        $_SESSION['id'] = $idx;
    }
    
    if (isset($_SESSION['id']) AND !isset($idx))
    {
        $idx = $_SESSION['id'];
    }
    
    // user selected to edit - should be same as id being viewed
    if (isset($_GET['editReview']) AND $_GET['editReview'] == 'True')
    {
        $editReview = True;
        echo '<script language="javascript">showForm("Edit Review")</script>';
    }

    // check for form post
    if ($_SERVER["REQUEST_METHOD"] == "POST" AND isset($_POST['testAction']))
    {
        $fail = false;
        
        // test the form elements
        $frmName = cleanFormData($_POST['frmName']);
        $frmCategory = cleanFormData($_POST['frmCategory']);
        $frmRating = cleanFormData($_POST['frmRating']);
        $frmPrice = cleanFormData($_POST['frmPrice']);
        $frmImageSm = cleanFormData($_POST['frmImageSm']);
        $frmImageLg = cleanFormData($_POST['frmImageLg']);
        $frmReviewText = cleanFormData($_POST['frmReviewText']);

        $frmNameErr = $frmCategoryErr = $frmPriceErr = $frmRatingErr = $frmImageSmErr = $frmImageLgErr = $frmReviewTextErr = "";

        if (empty($frmName))
        {
            $frmNameErr = "required";
            $fail = true;
        }
        if (empty($frmCategory))
        {
            $frmCategoryErr = "required";
            $fail = true;
        }
        if (empty($frmRating))
        {
            $frmRatingErr = "required";
            $fail = true;
        }
        if (empty($frmReviewText))
        {
            $frmReviewTextErr = "required";
            $fail = true;
        }

        // test for an error before saving
        if ($fail == false)
        {
            // get the entered values from the form
            addReview($name, $category, $rating, $price, $imageSm, $imageLg, $reviewText);
        }
    }
    
    // check for edit item submission
    if (isset($_POST['testAction']) AND $_POST['testAction'] == 'edit')
    {
        //$review = $_SESSION['reviews'][$idx];
    }
    
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
        <div id="summary">
            <!-- list of items -->
            <table class="summ">
            <?php
            // display the list of reviews in the array
            displaySummaryReviews();
            ?>
            </table>
            <br />
            <a href="#" onClick="showForm('Add New Review')">Add Review</a>
            
            <!-- edit form -->
            <div id="editForm" class="edit">
                <span id="formTitle"></span>
                <form method='post' id='pedalForm'>
                    <input type='hidden' id='testAction' name='testAction' value="<?=$editReview != True ? 'add' : 'edit' ?>">
                    <table class='additem'>
                        <tr>
                            <td>
                                <label for='frmName'>Pedal Name</label>
                                <input type='text' id='frmName' name='frmName' value='<?php echo $frmName;?>'>
                                <span class='frmError'><?php echo $frmNameErr;?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for='frmCategory'>Category</label>
                                <select id='category' id='frmCategory' name='frmCategory' value='<?php echo $frmCategory;?>'>
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
                                <span class='frmError'><?php echo $frmNameErr;?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for='frmRating'>Rating</label>
                                <input type='radio' id='frmRating' name='frmRating' value='0' 
                                    <?php if (isset($frmRating) AND $frmRating==0) echo 'checked';?> 
                                    >0 Stars</input>
                                <br />
                                <input type='radio' id='rating' name='rating' value='1' 
                                    <?php if (isset($frmRating) AND $frmRating==1) echo 'checked';?> 
                                    >1 Star</input>
                                <br />
                                <input type='radio' id='rating' name='rating' value='2' 
                                    <?php if (isset($frmRating) AND $frmRating==2) echo 'checked';?> 
                                    >2 Stars</input>
                                <br />
                                <input type='radio' id='rating' name='rating' value='3'
                                    <?php if (isset($frmRating) AND $frmRating==3) echo 'checked';?> 
                                    >3 Stars</input>
                                <br />
                                <input type='radio' id='rating' name='rating' value='4' 
                                    <?php if (isset($frmRating) AND $frmRating==4) echo 'checked';?> 
                                    >4 Stars</input>
                                <br />
                                <input type='radio' id='rating' name='rating' value='5'
                                    <?php if (isset($frmRating) AND $frmRating==5) echo 'checked';?> 
                                    >5 Stars</input>
                                <span class='frmError'><?php echo $frmNameErr;?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for='frmPrice'>Price</label>
                                <input type='text' id='frmPrice' name='frmPrice' value='<?php echo $frmPrice; ?>'></input>
                                <span class='frmError'><?php echo $frmNameErr;?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for='frmImageSm'>Small Image URL</label>
                                <input type='text' id='frmImageSm' name='frmImageSm' value='<?php echo $frmImageSm; ?>'></input>
                                <span class='frmError'><?php echo $frmNameErr;?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for='frmImageLg'>Large Image URL</label>
                                <input type='text' id='frmImageLg' name='frmImageLg' value='<?php echo $frmImageLg; ?>'></input>
                                <span class='frmError'><?php echo $frmNameErr;?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for='frmReviewText'>Review Text</label>
                                <textarea id='frmReviewText' name='frmReviewText' rows='4' cols='50'><?php echo $frmReviewText; ?></textarea>
                                <span class='frmError'><?php echo $frmNameErr;?></span>
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
            </div>
            
            <br />
            <p class="instructions">Select item above to view detail review</p>
        </div>
        
        <hr />
    
        <br />    
        <div id="details">
            <!-- detail reviews -->
            <table class='dets'>
                <tr>
            
            <?php
                displaySelectedReview($idx);
            ?>
            
                </tr>
            </table>
        </div>
        
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