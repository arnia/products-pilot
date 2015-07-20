function delete_file(file,domain){
    var r = confirm("Are you sure you want to delete this file?");
    if(r == true)
    {
        $.ajax({
            url: domain + '/script/del.php',
            data: {'file' : file},
            type: 'POST'
        });

        var x = document.getElementById("file_link");
        x.parentNode.removeChild(x);
        x = document.getElementById("file_button");
        x.parentNode.removeChild(x);
        var y = document.createElement("input");
        y.type = "file";
        y.name = "file";
        y.accept=".txt,.pdf,.doc,.docx";
        var x = document.getElementById("uploadfield");
        //var z = document.getElementById("last_line");
        //x.insertBefore(y, z);
        x.appendChild(y);
    }
}