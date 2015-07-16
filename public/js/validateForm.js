function validateForm(formId){
    var conf = confirm("Are you sure you want to delete ?");
    if(!conf){
        var del_form = document.getElementById('del_form_'+formId);
        del_form.action = '';
    }
}