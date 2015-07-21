function addToCart(email,product_id){

    var request = $.ajax({
        url: "products_pilot/public/script/add_to_cart.php",
        data: { email: email, product_id: product_id },
        type: "POST",
        dataType: "text"
    });

    request.done(function(data){
        var x = document.getElementById("myCart").innerHTML="New " + data + " added";
    });

    request.fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus );
    });
}