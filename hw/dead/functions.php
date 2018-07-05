<?php
session_start();

// clean the form inputs
function cleanFormData($input)
{
    $input = stripslashes($input);
    $input = trim($input);
    $input = htmlspecialchars($input);
}

// add a review to the array
function addReview($name, $category, $rating, $price, $imageSm, $imageLg, $text)
{
    $reviews = $_SESSION['reviews'];
    
    $newReview = array();
    $newReview['id'] = count($reviews);
    $newReview['name'] = $name;
    $newReview['category'] = $category;
    $newReview['rating'] = $rating;
    $newReview['price'] = $price;
    $newReview['imageSm'] = $imageSm;
    $newReview['imageLg'] = $imageLg;
    $newReview['reviewText'] = $text;
    
    array_push($_SESSION['reviews'], $newReview);
}

// display the single selected item
//  add form for edits
function displaySelectedReview($idx)
{
    $review = $_SESSION['reviews'][$idx];
    
    echo "<td class='image' rowspan='6'>";
    // only display image if one provided
    if (strlen($review['imageLg']) > 0)
    {
        echo "<img src='" . $review['imageLg'] . "' alt='" . $review['name'] . "'>";
    }
    else
    {
        echo "&nbsp;";
    }
    echo "</td>";
    echo "<td class='name'>" . $review['name'] . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class='cat'>Category: " . $review['category'] . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class='rating'>Rating: " . convertRatingToStars($review['rating']) . "</td>";
    echo "</tr>";
    echo "<tr>";
    
    // set the locale for currency display
    setlocale(LC_MONETARY,"en_US");
    
    echo "<td class='price'>Price: " . money_format("%n",$review['price']) . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class='dets'>" . $review['reviewText'] . "</td>";
    echo "</tr>";
    echo "<tr>";
    // ?editReview=True
    //, '" . $review['reviewText'] . "'
    echo "<td class='dets'><a href='#' onclick=\"showForm('Edit Review', '" . htmlentities($review['name']) . "', 
            '" . $review['category'] . "', '" . $review['rating'] . "', 
            '" . $review['price'] . "', '" . $review['imageSm'] . "', 
            '" . $review['imageLg'] . "')\">Edit Review</a></td>";
    echo "</tr>";
}

// loop through the list of reviews and build the display
function displaySummaryReviews()
{
    $reviews = $_SESSION['reviews'];
    
    foreach($reviews as $review)
    {
        echo "<tr>";
        echo "  <td class='summ_name'>";
        echo "      <a href='.?id=" . $review['id'] . "'>" . $review['name'] . "</a>";
        echo "  </td>";
        echo "  <td class='summ_img'>";
        
        // only display image if one provided
        if (strlen($review['imageSm']) > 0)
        {
            echo "<a href='.?id=" . $review['id'] . "'><img src='" . $review['imageSm'] . "' alt='" . $review['name'] . "'></a>";
        }
        else
        {
            echo "&nbsp;";
        }
        
        echo "  </td>";
        echo "</tr>";
    }
}

// show stars instead of the numeric ratings
function convertRatingToStars($rating)
{
    $retStr = "";
    for ($i = 1; $i <= $rating; $i++)
    {
        $retStr = $retStr . '<img src="img/horns2.png" alt="star">';
    }
    return $retStr;
}

/*
function showEditForm($review)
{
    return "<span id='formTitle'></span>
                <form method='post' id='pedalForm'>
                    <input type='hidden' id='testAction' name='testAction' value='add'>
                    <table class='additem'>
                        <tr>
                            <td>
                                <label for='pname'>Pedal Name</label>
                                <input type='text' id='pname' name='pname' required value="<?=$editReview != True ? '' : $review['name'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for='category'>Category</label>
                                <select id='category' id='category' name='category' required>
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
                                <input type='radio' id='rating' name='rating' value='0' required>0 Stars</input>
                                <br />
                                <input type='radio' id='rating' name='rating' value='1'>1 Star</input>
                                <br />
                                <input type='radio' id='rating' name='rating' value='2'>2 Stars</input>
                                <br />
                                <input type='radio' id='rating' name='rating' value='3'>3 Stars</input>
                                <br />
                                <input type='radio' id='rating' name='rating' value='4'>4 Stars</input>
                                <br />
                                <input type='radio' id='rating' name='rating' value='5'>5 Stars</input>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for='price'>Price</label>
                                <input type='text' id='price' name='price' required value="<?=$editReview != True ? '' : $review['price'] ?>"></input>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for='imageSm'>Small Image URL</label>
                                <input type='text' id='imageSm' name='imageSm' value="<?=$editReview != True ? '' : $review['imageSm'] ?>"></input>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for='imageLg'>Large Image URL</label>
                                <input type='text' id='imageLg' name='imageLg' value="<?=$editReview != True ? '' : $review['imageLg'] ?>"></input>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for='reviewText'>Review Text</label>
                                <textarea id='reviewText' name='reviewText' required value="<?=$editReview != True ? '' : $review['reviewText'] ?>"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button type='submit' value='submit' onclick='validateForm'><?=$editReview != True ? 'Add Item' : 'Edit Item' ?></button>&nbsp;
                                <button type='reset' value='Cancel' onclick='hideForm();'>Cancel</button>
                            </td>
                        </tr>
                    </table>
                </form>
}
*/

?>