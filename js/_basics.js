console.log("_basics.js está incluido na página atual.");

async function sessionChecker() {
  const url = "http://localhost:5000/php/session/checkSession.php";

  let response = await fetch(url);

  let data = await response.json();

  return data;
}

function changeInputStyle(inputID, inputErrorID, errorMessage, state) {
  if (state == true) {
    if (document.getElementById(inputID).type != "button") {
      document.getElementById(inputID).style.border = "1px solid green";
    }
    document.getElementById(inputErrorID).style.top = "-15px";
  } else {
    if (document.getElementById(inputID).type != "button") {
      document.getElementById(inputID).style.border = "1px solid red";
    }
    document.getElementById(inputErrorID).style.top = "5px";
    document.getElementById(inputErrorID).innerHTML = errorMessage;
  }
}

async function criptografarSenha(senha) {
  const msgBuffer = new TextEncoder().encode(senha);
  const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
  const hashArray = Array.from(new Uint8Array(hashBuffer));
  const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
  return hashHex.substring(0, 64);
}