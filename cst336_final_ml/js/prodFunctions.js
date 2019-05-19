// javascript

function addToCartClick(btnObj, id, name, basePrice, salePrice, imageUrl, desc)
{
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "app.php",
        data: {action: "addtocart", id: id, name: name, basePrice: basePrice, salePrice: salePrice, imageUrl: imageUrl, desc: desc},
        success: function(data) {
            
            // testing
            //alert(JSON.stringify(data));

            // update the cart display
            $("#cartCount").html(data.itemCount)
        }
    });
    
    //alert(btnObj.value);
    
    // update the calling button - text and display css
    btnObj.value = "Added";
    btnObj.classList.toggle("btn-warning");
    btnObj.classList.toggle("btn-success");
}

