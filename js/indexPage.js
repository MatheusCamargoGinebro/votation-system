// adicionando um ouvinte de evento ao document
document.addEventListener("DOMContentLoaded", async function () {
  // executando a função anônima assíncrona de logout
  const url = "http://localhost:5000/php/session/logout.php";
  fetch(url);
});
