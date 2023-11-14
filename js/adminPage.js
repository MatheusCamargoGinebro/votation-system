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

  getAllData().then((data) => {
    var candidatesTable =
      "<table><tr><th>Nome do candidato</th><th>Número do candidato</th><th>Quantidade de Votos</th></tr>";
    for (var i = 0; i < data.candidatesSize; i++) {
      candidatesTable +=
        "<tr><td>" +
        data.candidates[i].nome_candidato +
        "</td><td>" +
        data.candidates[i].numero_candidato +
        "</td><td>" +
        data.candidates[i].votos +
        "</td></tr>";
    }
    candidatesTable += "</table>";

    document.getElementById("candidatesTable").innerHTML = candidatesTable;
    var studentsTable =
      "<table><tr><th>Nome do aluno</th><th>Email do aluno</th><th>ID do aluno</th></tr>";
    for (var i = 0; i < data.StudentsSize; i++) {
      studentsTable +=
        "<tr><td>" +
        data.students[i].nome_estudante +
        "</td><td>" +
        data.students[i].email +
        "</td><td>" +
        data.students[i].id +
        "</td></tr>";
    }
    studentsTable += "</table>";
    document.getElementById("studentsTable").innerHTML = studentsTable;
  });
});

// fetch para pegar todos os dados do banco de dados:
async function getAllData() {
  const url = "http://localhost:5000/php/database/getAllData.php";

  let response = await fetch(url);

  let data = await response.json();

  return data;
}

const candidateTab = document.getElementById("candidates-tab-field");
const studentTab = document.getElementById("students-tab-field");
const seeCandidates = document.getElementById("see-candidates");
const seeStudents = document.getElementById("see-students");

seeCandidates.addEventListener("click", function () {
  candidateTab.classList.remove("tab-item-disabled");
  studentTab.classList.add("tab-item-disabled");

  seeCandidates.classList.add("selected-tab");
  seeStudents.classList.remove("selected-tab");
});

seeStudents.addEventListener("click", function () {
  candidateTab.classList.add("tab-item-disabled");
  studentTab.classList.remove("tab-item-disabled");

  seeCandidates.classList.remove("selected-tab");
  seeStudents.classList.add("selected-tab");
});
