function validateForm(){
    var conf = confirm("Are you sure you want to delete ?");
    if(!conf){
        var del_form = document.getElementById('del_form');
        del_form.action = '';
    }
}