console.log("adminPage.js está incluido na página atual.");

document.addEventListener("DOMContentLoaded", function(){
    sessionChecker().then((data) => {
        console.log(data);

        if(data.level != 1){
            console.log("saia");
        }
    })
});