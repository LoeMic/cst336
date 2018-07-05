// JavaScript File

function toggleHide(item)
{
    // 'hide','show'
    var x = document.getElementById("contact"+item).querySelectorAll("span");
    
    alert(x.length);
    
    for(var i=0; i<x.length; i++)
    {
        // check for writing the style - show will accept hide
        if (x[i].className == 'show')
        {
            x[i].classList.add('hide');
            x[i].classList.remove('show');
        }
        else
        {
            x[i].classList.add('show');
            x[i].classList.remove('hide');
        }
    }
}
