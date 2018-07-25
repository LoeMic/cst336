var guessedWords = "";
var selectedWord = "";
var selectedHint = "";
var board = [];
var remainingGuesses = 6;
var words = [{ word: "snake", hint: "It's a reptile" },
                { word: "monkey", hint: "It's a mammal" },
                { word: "beetle", hint: "It's an insect" }];

// Creating an array of available letters
var alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 
                'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 
                'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

// console.log(words[0]);

// set the listener
window.onload = startGame();

/*  -- removed
$("#letterBtn").click(function()
    {
        //alert("clicked");
        var boxVal = $("#letterBox").val();
        //console.log("You pressed the button and it had the value: " + boxVal);
        
        // test
        alert("You pressed the button and it had the value: " + boxVal);
    });
*/

$(".letter").click(function()
{
    //alert($(this).attr("id"));
    //console.log($(this).attr("id"));
    checkLetter($(this).attr("id"));
    disableButton($(this));
});

// figure out the new url with the query param
$(".replayBtn").on("click", function() {
    setCookie();
    location.reload();
});

// hide the button and show the hint message
$("#hintBtn").click(function()
{
    $("#hintBtn").hide();
    $("#hintDisplay").append("<span>Hint: " + selectedHint + "</span>");
    $("#hintDisplay").show();
});

// retrieve the guessed words from cookie for display
function getCookie()
{
    guessedWords = document.cookie.replace(/(?:(?:^|.*;\s*)guessed\s*\=\s*([^;]*).*$)|^.*$/, "$1");
    
    // testing
    //alert(guessedWords);
    
    $("#guessed").append(guessedWords);
}

// save the guessed word string to cookie
function setCookie()
{
    document.cookie = "guessed=" + guessedWords;
}

function startGame()
{
    getCookie();
    pickWord();
    
    // testing
    //alert(selectedWord);
    
    initBoard();
    updateBoard();
    createLetters();
}

function pickWord()
{
    var randomInt = Math.floor(Math.random() * words.length);
    selectedWord = words[randomInt].word.toUpperCase();
    selectedHint = words[randomInt].hint;
}

// fill the board with underscores
function initBoard()
{
    for (var letter in selectedWord)
    {
        board.push("_");
    }
}

function updateBoard()
{
    $("#word").empty();
    
    for (var i=0; i < board.length; i++)
    {
        $("#word").append(board[i] + " ");
    }
}

function createLetters()
{
    for (var letter of alphabet)
    {
        $("#letters").append("<button class='letter btn btn-success' id='" + letter + "'>" + letter + "</button>");
    }
}

// check for the letter in the selected word
function checkLetter(letter)
{
    var positions = new Array();
    
    // put all of the times the letter is found in an array
    for (var i = 0; i < selectedWord.length; i++)
    {
        console.log(selectedWord);
        if (letter == selectedWord[i])
        {
            positions.push(i);
        }
    }
    
    if (positions.length > 0)
    {
        updateWord(positions, letter);
        
        // check for a win - no more '_' chars
        if (!board.includes('_'))
        {
            endGame(true);
        }
    }
    else
    {
        remainingGuesses -= 1;
        updateMan();
    }
    
    if (remainingGuesses <= 0)
    {
        endGame(false);
    }
}

// update the current word then call updateBoard
function updateWord(positions, letter)
{
    for (var pos of positions)
    {
        board[pos] = letter;
    }
    
    updateBoard();
}

// calculates and updates the image for the stick man
function updateMan()
{
    $("#hangImg").attr("src","img/stick_" + (6 - remainingGuesses) + ".png");
}

// Ends the game by hiding game divs and displaying the win or loss divs
function endGame(win)
{
    $("#letters").hide();
    
    if (win) {
        $('#won').show();
        
        // testing
        //alert(selectedWord);
        
        guessedWords = guessedWords + " " + selectedWord;
        
        $("#guessed").append(" " + selectedWord);
    }
    else
    {
        $('#lost').show();
    }
}

function disableButton(btn)
{
    btn.prop("disabled", true);
    btn.attr("class","btn btn-danger");
}

