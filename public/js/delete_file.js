function delete_file(file,id){
    var r = confirm("Are you sure you want to delete this file?");
    if(r == true)
    {
        request = $.ajax({
            url: '/scripts/del.php',
            data: {'file' : file , 'id' : id},
            type: 'POST'
        });

        request.done(function(data){
            console.log(data);
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });

        var x = document.getElementById("file_link"+id);
        x.parentNode.removeChild(x);
        x = document.getElementById("file_button"+id);
        x.parentNode.removeChild(x);
        var y = document.createElement("input");
        y.type = "file";

        if(id == 1) {
            y.name = "file";
            y.accept=".txt,.pdf,.doc,.docx";
        }
        else {
            y.name = "image";
            y.accept=".jpg,.jpeg,.png";
        }
        var x = document.getElementById("uploadfield"+id);
        //var z = document.getElementById("last_line");
        //x.insertBefore(y, z);
        x.appendChild(y);
    }
}