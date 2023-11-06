console.log("votingPage.js está incluido na página atual.");

// usando uma função anônima assíncrona como argumento do evento
document.addEventListener("DOMContentLoaded", async function(){
    // usando await para esperar pela resolução da promise
    let data = await sessionChecker();
    console.log(data);

    if(data.level == 0){
        window.location.href = "http://localhost:5000/";
    } else if (data.level == 1) {
        window.location.href = "http://localhost:5000/pages/admin.html";
    } else if(data.level == 2 && data.voted == false){
        document.getElementById("voting-email").value = data.email;
    } else{
        document.getElementById("alert-voted").style.display = "flex";
        document.getElementById("alert-voted-title").innerHTML = "Você já havia votado!";
        document.getElementById("alert-voted-text").innerHTML = "Você já havia votado anteriormente, portanto, não pode votar novamente. Clique no botão abaixo para voltar e finalizar a sessão.";
    }

    // carregando candidatos:
    // usando await para esperar pela resolução da promise
    await loadCanditates();

});

// definindo a função loadCanditates
async function loadCanditates() {
    try {
        const response = await fetch("http://localhost:5000/php/database/loadCandidates.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
        });
    
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        
        data = await response.json();

        var Content = '<option value="">Escolha o seu candidato</option>';

        for (let i = 0; i < data.candidates.length; i++){
            Content += '<option value="' + data.candidates[i].id + '">' + data.candidates[i].id + " - " + data.candidates[i].nome_candidato + '</option>';
        }

        document.getElementById("voting-candidato").innerHTML = Content;
    
    }catch (error) {
        console.error("Error:", error);
    }
}

// definindo uma constante de verificação:
const check = {
    email: true,
    candidatoID: false
}

// definindo a função de verificação:
const checker = () => {
    if(check.email && check.candidatoID){
        document.getElementById("voting-submit").classList.remove("disabled");
        
        return true;
    } else {
        document.getElementById("voting-submit").classList.add("disabled");
    }
}

// definindo a função de verificar o input de email:
const email = document.getElementById("voting-email").addEventListener("input", function(e){
    var emailRegex = /^[a-zA-Z0-9._-]+@aluno\.ifsp\.edu\.br$/;

    if(emailRegex.test(e.target.value) == false){
        check.email = false;
        changeInputStyle("voting-email", "voting-email-error", "O email deve seguir o padrão email@aluno.ifsp.edu.br", false);
    } else {
        check.email = false;
        changeInputStyle("voting-email", "voting-email-error", "", true);
    }

    checker();
});

// definindo a função de verificar o input de candidato:
const candidatoID = document.getElementById("voting-candidato").addEventListener("input", function(e){
    if(e.target.value === ""){
        check.candidatoID = false;
        changeInputStyle("voting-candidato", "voting-candidato-error", "Escolha um dos candidatos disponíveis.", false);
    } else {
        check.candidatoID = true;
        changeInputStyle("voting-candidato", "voting-candidato-error", "", true);
    }

    checker();
});

// definindo a função de submeter o formulário:
const submitVotationForm = document.getElementById("voting-submit").addEventListener("click", function(e){
    if(checker()){
        const email = document.getElementById("voting-email").value;
        const candidatoID = document.getElementById("voting-candidato").value;

        vote(email, candidatoID).then((data) => {
            console.log(data);
        });
    } else {
        if(check.email == false){
            changeInputStyle("voting-email", "voting-email-error", "O email deve seguir o padrão email@aluno.ifsp.edu.br", false);
        }
        if(check.candidatoID == false){
            changeInputStyle("voting-candidato", "voting-candidato-error", "Escolha um dos candidatos disponíveis.", false);
        }
    }
});

async function vote(email, candidatoID){
    const url = "http://localhost:5000/php/database/vote.php";

    const init = {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            email: email,
            candidateID: candidatoID
        }),
        headers: {
            "content-type": "application/json",
        },
    }
    try {
        const response = await fetch(url, init);
        const data = await response.json();

        return data;
    }catch (error) {
        console.error("Error:", error);
    }
}