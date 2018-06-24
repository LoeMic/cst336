<!DOCTYPE html>
<html>
    <head>
        <title> The World of Fuzz - Reviews by Mike Loeser</title>
        <meta charset="utf-8" />
        <style>
            @import "css/style.css";
        </style>
        
        <?php
            // build the array of items
            // there will be one array for the summary and name, then another for the reviews
            $pedals = array("Way Huge - Russian Pickle", "Tone Bender - MkIII", "Death By Audio - Fuzz War");
            $pedalImgSm = array("pickle_sm.jpg", "bender_sm.jpg", "fuzzwar_sm.jpg");
            $pedalImgLg = array("pickle_lg.jpg", "bender_lg.jpg", "fuzzwar_lg.jpg");
            $pedalDetails = array(
"<h2>Way Huge - Russian Pickle</h2>
<br />
I absolutely love the Way Huge pedals.  They are unique in their sound, 
tend to focus on big sounds and massive sound shaping, and are designed by
Jeorge Tripps, an absolute legend in pedal building since the early 90's.
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
of the time, but it had it's issues.  I've personally had 2 of these and one had a switch 
fail and other has had issues with 2 of it's pots.  Thankfully they are easily fixed.
<br /><br />
The Way Huge pedal is built like an absolute tank.  The housing is aluminum and thicker 
than the normal sheet steel used for pedals, knobs are their standard large pointed items 
with painted markers, and the switch feels like it is ready to take years of abuse.  All 
of this is typical of the Way Huge line.
<br /><br />
The last, and possibly best, point to make is on price.  Way Huge is a division of 
Jim Dunlop and so with their buying power and volume production, the WH line is kept 
extremely reasonably priced.  The Russian Pickle averages \$150 new on various sites.
",
"<h2>Tone Bender - MkIII</h2>
<br />
The Tone Bender is one of the earliest mass produced fuzz pedals and is still available 
in many forms and in many copies today.  An absolute classic that shaped the sounds for 
other later pedals like the big muff and it's variants.
<br /><br />
This pedal is a bit of a one-hit wonder, but if you are into this sound, it hits it 
right out of the park.  Big sound, good for single line notes and sludgy power chords.  
This is a go-to for classic sounds.
<br /><br />
Price is where this pedal has its issues.  The originals still being made are more expensive 
and have less features than many of the clones available on the market.  The classic 
pedals can go for hundreds of dollars more.  I think I paid \$250 for this one 
and have lots of other clones and like-sounding pedals that I always go to first, 
which says something.  I'm happy I have it, but there are lots of options out there.
",
"<h2>Death By Audio - Fuzz War</h2>
<br />
I can't say enough about this pedal.  It's a constant on my board and has been a 
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
This is an absolute new classic and easily worth the \$150 purchase price.
");
        ?>
        <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet">
    </head>
    <body>
        <header>
        <h1> The World of Fuzz </h1>
        <h3> Reviews by Mike Loeser </h3>
        </header>

        <br />
        <div id="summary">
            <!-- list of items -->
            <table class="summ">
            
            <?php
            
            for($i = 0; $i < count($pedals); $i++)
            {
                echo "<tr>";
                echo "  <td class='name'>";
                echo "<a href='.?idx=$i'>" . $pedals[$i] . "</a>";
                echo "  </td>";
                echo "  <td class='img'>";
                
                // only display image if one provided
                if (strlen($pedalImgSm[$i]) > 0)
                {
                    echo "<img src='img/" . $pedalImgSm[$i] . "' alt='" . $pedals[$i] . "'>";
                }
                else
                {
                    echo "&nbsp;";
                }
                
                echo "  </td>";
                echo "</tr>";
            }
    
            ?>
            
            </table>
        </div>
        
        <hr />
    
        <br />    
        <div id="">
            <!-- detail reviews -->
            <table class='details'>
                <tr>
            
            <?php
                $idx = $_GET["idx"];
                
                // randomly pick an index if none selected
                if (is_null($idx) And is_array($pedals) )
                {
                    $idx = array_rand($pedals);
                }

                echo "<td class='dets'>";
                
                // only display image if one provided
                if (strlen($pedalImgLg[$idx]) > 0)
                {
                    echo "<img src='img/" . $pedalImgLg[$idx] . "' alt='" . $pedals[$idx] . "'>";
                }
                else
                {
                    echo "&nbsp;";
                }
                echo "</td>";
                echo "<td class='dets'>";
                echo $pedalDetails[$idx];
                echo "</td>";
            ?>
            
                </tr>
            </table>
        </div>
        
        <!--
        <?php
            // need a second loop - add some comments to the page
            for ($i = 0; $i < 10; $i++)
            {
                echo "building comment - " . $i;
            }
        ?>
        -->
        
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