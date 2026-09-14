console.log("JS MASUK!");

// show hidden sidebar
const toggleBtn = document.querySelector(".toggle-sidebar");
const sidebar = document.getElementById("sidebar");

toggleBtn.addEventListener("click", () => {
  sidebar.classList.toggle("hide");
});

// show dropdown on avatar
function toggleBox() {
  const dropdown = document.getElementById("profile-link");
  dropdown.classList.toggle("hidden");
}

// visibility content
document.addEventListener("DOMContentLoaded", function () {
  const menuBtns = document.querySelectorAll(".menu-btn");
  const contents = document.querySelectorAll(".menu-content");

  menuBtns.forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();

      menuBtns.forEach((b) => b.classList.remove("active"));

      contents.forEach((c) => c.classList.add("hide"));

      this.classList.add("active");

      const targetId = this.getAttribute("data-target");
      document.getElementById(targetId).classList.remove("hide");
    });
  });
});
