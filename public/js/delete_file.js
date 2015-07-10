function delete_file(file){
    var r = confirm("Are you sure you want to delete this file?");
    if(r == true)
    {
        $.ajax({
            url: 'del.php',
            data: {'file' : file }
        });

        var x = document.getElementById("file_link");
        x.parentNode.removeChild(x);
        x = document.getElementById("file_button");
        x.parentNode.removeChild(x);
        var y = document.createElement("input");
        y.type = "file";
        y.name = "file";
        y.accept=".txt,.pdf,.doc,.docx";
        var x = document.getElementById("update_form");
        var z = document.getElementById("last_line");
        x.insertBefore(y, z);
    }
}