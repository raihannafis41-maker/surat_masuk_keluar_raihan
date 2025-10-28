const form = document.querySelector("form");
const transition = document.getElementById("transition");

form.addEventListener("submit", (e) => {
  e.preventDefault();
  transition.classList.remove("hidden");

  setTimeout(() => {
    form.submit();
  }, 1500);
});
