function countCart(email){
    if(email != null && email != ''){
        var request = $.ajax({
        url: "/scripts/countCart.php",
        data: { email: email },
        type: "POST",
        dataType: "text"
        });

        request.done(function(data){
            var x = document.getElementById("countCart").innerHTML = data;
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }
}