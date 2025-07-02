let btn1 = document.querySelector(".btn1");
let Theme = "light";
let body = document.querySelector("body");

btn1.addEventListener("click", () => {
    if (Theme === "light") {
        Theme = "dark";
        body.classList.add("dark");
        body.classList.remove("light");
        btn1.src = "../image/night-mode (1).png";
    } else {
        Theme = "light";
        body.classList.add("light");
        body.classList.remove("dark");
        btn1.src = "../image/sun.svg";
    }
    console.log(Theme);
});

function showMenu(day) {
    const menus = document.querySelectorAll('.menu-card');
    menus.forEach(menu => menu.classList.add('hidden'));
    document.getElementById(`${day}-menu`).classList.remove('hidden');
}
// Show Monday menu by default
window.onload = function() { showMenu('monday'); };