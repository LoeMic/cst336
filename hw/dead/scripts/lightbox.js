function showForm(title, name, category, rating, price, imageSm, imageLg, reviewText)
{
    clearErrors();
    
    // populate the form elements if values are passed
    if (name != null)
    {
        nameTxt = document.getElementById('pedalForm').frmName;
        nameTxt.value = name;
    }

    if (category != null)
    {
        catSel = document.getElementById('pedalForm').elements['frmCategory'];
        catSel.value = category;
    }

    if (rating != null)
    {
        ratingRadios = document.getElementById('pedalForm').elements['frmRating'];
        for (var i = 0; i < ratingRadios.length; i++) {
          if (ratingRadios[i].value == rating) {
              ratingRadios[i].selected = true;
              break;
           }
        }
    }

    if (price != null)
    {
        priceTxt = document.getElementById('editForm').elements['frmPrice'];
        priceTxt.value = price;
    }

    if (imageSm != null)
    {
        imageSmTxt = document.getElementById('editForm').elements['frmImageSm'];
        imageSmTxt.value = imageSm;
    }
    
    if (imageLg != null)
    {
        imageLgTxt = document.getElementById('editForm').elements['frmImageLg'];
        imageLgTxt.value = imageLg;
    }

    if (reviewText != null)
    {
        reviewTextTxt = document.getElementById('editForm').elements['frmReviewText'];
        reviewTextTxt.value = reviewText;
    }
    
    // show the lightbox
    lb = document.getElementById('editForm');

    var formTitle = document.getElementById('formTitle');
    formTitle.innerHTML = title;

    lb.style.display='block';
}

function clearErrors()
{
    items = document.getElementsByClassName("example");
    
    for (i = 0; i < items.length; i++)
    {
        items[i].innerHTML = "";
    }
}

function hideForm()
{
    document.getElementById('editForm').style.display='none';
}