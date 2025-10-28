document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("#loginForm");
  form.addEventListener("submit", (e) => {
    const button = form.querySelector(".btn-login");
    button.textContent = "Memproses...";
    button.disabled = true;
    button.style.opacity = "0.8";
  });
});
