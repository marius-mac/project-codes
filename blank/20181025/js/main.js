// =================Patikrinimas ar veikia==========================
console.log("PATIKRINIMAS_1");
console.log("===================================================");

// =================paleidziamas js tik uzkrovus html (js pradzia)==
$ (document).ready(function(){

// =================Patikrinimas ar veikia js========================

document.querySelector("h2").innerHTML += "PATIKRINIMAS_1";
document.querySelector("h2").innerHTML += "<br>" + "LOADING+++++";
// =================Patikrinimas ar veikia jquery====================
$ ("h2").css("color", "green");

// =================2-jQ-efects=====================================



// ================js pabaiga=======================================
});
