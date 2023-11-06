console.log("adminPage.js está incluido na página atual.");

document.addEventListener("DOMContentLoaded", function () {
  sessionChecker().then((data) => {
    console.log(data);

    if (data.level == 0) {
      window.location.href = "http://localhost:5000/";
    } else if (data.level == 2) {
      window.location.href = "http://localhost:5000/pages/voting.html";
    } else if (data.level != 1) {
      window.location.href = "http://localhost:5000/pages/admin.html";
    }
  });
});
