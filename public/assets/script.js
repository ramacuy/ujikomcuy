document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const content = document.querySelector(".content");
    const toggle = document.getElementById("toggleSidebar");

    if (sidebar && toggle) {
        toggle.addEventListener("click", () => {
            sidebar.classList.toggle("hide");
            content.classList.toggle("full-width");
        });
    }

    // Aktifkan link sidebar
    let links = document.querySelectorAll("#sidebar .nav-link");
    links.forEach(link => {
        link.addEventListener("click", function () {
            links.forEach(l => l.classList.remove("active"));
            this.classList.add("active");
        });
    });
});

