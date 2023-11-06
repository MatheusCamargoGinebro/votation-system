console.log("_basics.js está incluido na página atual.");

async function sessionChecker(){
    const url = "http://localhost:5000/php/session/checkSession.php";

    let response = await fetch(url);
    
    let data = await response.json();
    
    return data;
}

function changeInputStyle(inputID, inputErrorID, errorMessage, state){
    if(state == true){
        document.getElementById(inputID).style.border = "1px solid green";
        document.getElementById(inputErrorID).style.top = "-15px";
    } else{
        document.getElementById(inputID).style.border = "1px solid red";
        document.getElementById(inputErrorID).style.top = "5px";
        document.getElementById(inputErrorID).innerHTML = errorMessage;
    }
    
}