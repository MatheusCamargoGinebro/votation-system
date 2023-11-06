console.log("votingPage.js está incluido na página atual.");

document.addEventListener("DOMContentLoaded", function(){
    sessionChecker().then((data) => {

        if(data.level != 2){
            console.log("saia");
        }
    })
});

const check = {
    email: false,
    candidatoID: false
}

const checker = () => {
    if(check.email && candidatoID){
        document.getElementById("voting-submit").classList.remove("disabled");
        
        return true;
    } else {
        document.getElementById("voting-submit").classList.add("disabled");
    }
}

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