console.log("loginPage.js está incluido na página atual.");

document.addEventListener("DOMContentLoaded", function(){
    sessionChecker().then((data) => {
        console.log(data);

        if(data.level == 1){
            window.location.href = "http://localhost:5000/pages/admin.html";
        } else if (data.level == 2) {
            window.location.href = "http://localhost:5000/pages/voting.html";
        }
    })
});

/* Constantes de verificação */
const check = {
    name: false,
    password: false
}

// Função que desativa o botão caso haja algo de errado:
const checker = () => {
    if(check.name && check.password){
        document.getElementById("login-submit").classList.remove("disabled");

        return true;
    }else{
        document.getElementById("login-submit").classList.add("disabled");

        return false;
    }
}

// Função que verifica o input de nome:
const name = document.getElementById("login-username").addEventListener("input", function(e){
    if(e.target.value < 1){   
        check.name = false;
        changeInputStyle("login-username", "login-username-error", "Você deve digitar o seu nome de usuário.", false);
    }else{
        check.name = true;
        changeInputStyle("login-username", "login-username-error", "", true);
    }

    checker();
});

// Função que verifica a senha:
const password = document.getElementById("login-password").addEventListener("input", function(e){
    if(e.target.value < 1){
        check.password = false;
        changeInputStyle("login-password", "login-password-error", "Você deve digitar uma senha.", false);
    } else {
        check.password = true;
        changeInputStyle("login-password", "login-password-error", "", true);
    }

    checker();
});

// Função de submissão de formulário:
const submitLoginForm = document.getElementById("login-submit").addEventListener("click", function(e){
    if(checker()){
        const name = document.getElementById("login-username").value;
        const password = document.getElementById("login-password").value;

        login(name, password).then((data) => {
            if(data.session){
                if(data.level == 1){
                    window.location.href = "http://localhost:5000/pages/admin.html";
                } else if (data.level == 2) {
                    window.location.href = "http://localhost:5000/pages/voting.html";
                }
            }else{
                changeInputStyle("login-submit", "login-submit-error", data.message, false);
            }
        });
    } else{
        if(check.name === false) {
            changeInputStyle("login-username", "login-username-error", "Nome de usuário inválido.", false);
        }
        if(check.password === false){
            changeInputStyle("login-password", "login-password-error", "Senha inválida.", false);
        }
    }
});

async function login(name, password) {
    const url = "http://localhost:5000/php/session/login.php";
    const init = {
      method: "POST",
      body: JSON.stringify({
          name: name,
          password: password,
      }),
      headers: {
          "content-type": "application/json",
      },
    };
  
    try {
      const response = await fetch(url, init);
      const data = await response.json();
  
      return data;
    }catch(error) {
      console.log("Erro: ", error);
    }
  }