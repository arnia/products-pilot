function countCart(email){
    var request = $.ajax({
        url: "/products_pilot/scripts/countCart.php",
        data: { email: email },
        type: "POST",
        dataType: "text"
    });

    request.done(function(data){
        var x = document.getElementById("countCart").innerHTML=data;
    });

    request.fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus );
    });
}