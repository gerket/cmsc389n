window.onsubmit=validateForm;

function validateForm(){
    "use strict";
    var uid= document.getElementById("uid").value;
    
    var invalidMessages = "";
    if (uid.length !== 9){
        invalidMessages += "Invalid university id\n";
    }else if (isNaN(uid)){
        invalidMessages += "Invalid university id\n";
    }
    
    var firstname = document.getElementById("firstname").value;
    var lastname = document.getElementById("lastname").value;
    var uname= document.getElementById("uname").value;
    var password = document.getElementById("pass").value;
    var email = document.getElementById("email").value;
    
    if (firstname.length === 0){
        invalidMessages += "No Firstname entered\n";
    }
    if (lastname.length === 0){
        invalidMessages += "No Lastname entered\n";
    }
    if (uname.length === 0){
        invalidMessages += "No Username entered\n";
    }
    if (password.length === 0){
        invalidMessages += "No Password entered\n";
    }
    if (email.length === 0){
        invalidMessages += "No Email entered\n";
    }
    
    if (invalidMessages !== ""){
        alert(invalidMessages);
        return false;
    } else {
        if (window.confirm("Do you want to submit the form?"))
            return true;
        else    
            return false;
    }
}