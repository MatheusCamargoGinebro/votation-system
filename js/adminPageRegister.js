document.addEventListener("DOMContentLoaded", function () {
    sessionChecker().then((data) => {
        if (data.level == 0) {
            window.location.href = "http://localhost:5000/";
        } else if (data.level == 2) {
            window.location.href = "http://localhost:5000/pages/session/voting.html";
        } else if (data.level != 1) {
            window.location.href = "http://localhost:5000/pages/admin/admin.html";
        }
    });
});

/* Constantes de verificação */
const check = {
    name: false,
    number: false,
};

// Função que desativa o botão caso haja algo de errado:
const checker = () => {
    if (check.name && check.number) {
        document.getElementById("register-candidate-submit").classList.remove("disabled");

        return true;
    } else {
        document.getElementById("register-candidate-submit").classList.add("disabled");

        return false;
    }
};

// Função que verifica o input de nome:
const name = document.getElementById("register-candidate-name").addEventListener("input", function (e) {
    var nameRegex = /^[a-zA-Z\s]{3,255}$/;
    if (nameRegex.test(e.target.value) == false) {
        check.name = false;

        if (e.target.value.length < 3) {
            changeInputStyle("register-candidate-name", "register-candidate-name-error", "O nome deve ter no mínimo 3 caracteres.", false);
        } else if (e.target.value.length > 255) {
            changeInputStyle("register-candidate-name", "register-candidate-name-error", "O nome deve ter no máximo 255 caracteres.", false);
        } else {
            changeInputStyle("register-candidate-name", "register-candidate-name-error", "O nome deve conter apenas letras e espaços.", false);
        }
    } else {
        check.name = true;
        changeInputStyle("register-candidate-name", "register-candidate-name-error", "", true);
    }

    checker();
});

// Função que verifica o input de número:
const number = document.getElementById("register-candidate-number").addEventListener("input", function (e) {
    var numberRegex = /^\d+$/;
    if (e.target.value < 0) {
        check.number = false;
        changeInputStyle("register-candidate-number", "register-candidate-number-error", "O número do candidato não deve ser negativo.", false);
    } else if(!Number.isInteger(Number(e.target.value)) || !numberRegex.test(e.target.value)){
        check.number = false;
        changeInputStyle("register-candidate-number", "register-candidate-number-error", "O número do candidato deve ser um número inteiro.", false);
    }else {
        check.number = true;
        changeInputStyle("register-candidate-number", "register-candidate-number-error", "", true);
    }

    checker();
});

// Função que envia os dados para o banco de dados:
const submitCandidate = document.getElementById("register-candidate-submit").addEventListener("click", async function () {
    if(checker()){
        const name = document.getElementById("register-candidate-name").value;
        const number = document.getElementById("register-candidate-number").value;

        registerCandidate(name, number).then((data) => {
            if(data.success){
                window.location.href = "http://localhost:5000/pages/admin/admin.html";
            } else{
                changeInputStyle("register-candidate-name", "register-candidate-name-error", "O nome do candidato já existe.", data.name);
                changeInputStyle("register-candidate-number", "register-candidate-number-error", "O número do candidato já existe.", data.number);
                changeInputStyle("register-candidate-submit", "register-candidate-submit-error", "Dados já cadastrados.", false);
            }
        });
    }else{
        if(!check.name){
            changeInputStyle("register-candidate-name", "register-candidate-name-error", "Você deve digitar um nome para o candidato.", false);
        }
        if(!check.number){
            changeInputStyle("register-candidate-number", "register-candidate-number-error", "Você deve digitar um número para o candidato.", false);
        }
    }
});

// Função que envia os dados para o banco de dados:
async function registerCandidate(name, number) {
    const url = "http://localhost:5000/php/database/registerCandidate.php";

    const init = {
        method: "POST",
        body: JSON.stringify({
            name: name,
            number: number
        }),
        headers: {
            "Content-Type": "application/json",
        },
    };

    try {
        let response = await fetch(url, init);

        let data = await response.json();

        return data;
    } catch (error) {
        console.log("Erro: ", error);
    }
}