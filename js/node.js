// Theme toggle logic
let theme = "light";
const body = document.querySelector("body");
const themeToggle = document.querySelector(".btn1");

themeToggle.addEventListener("click", () => {
  if (theme === "light") {
    theme = "dark";
    body.classList.add("dark");
    body.classList.remove("light");
    themeToggle.src = "../image/night-mode (1).png";
  } else {
    theme = "light";
    body.classList.add("light");
    body.classList.remove("dark");
    themeToggle.src = "../image/sun.svg";
  }
  console.log(theme);
});

// Book Table button click 
const bookBtn = document.getElementById("bookBtn");
if (bookBtn) {
  bookBtn.addEventListener("click", () => {
    window.location.href = "../html/Booking.php"; 
  });
}


