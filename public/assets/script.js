document.addEventListener("DOMContentLoaded", function () {
    let sidebar = document.getElementById("sidebar");
    let content = document.querySelector(".content");

    if (sidebar.classList.contains("hide")) {
        content.classList.add("full-width");
    } else {
        content.classList.remove("full-width");
    }

    document.getElementById("toggleSidebar").addEventListener("click", function () {
        sidebar.classList.toggle("hide");

        if (sidebar.classList.contains("hide")) {
            content.classList.add("full-width");
        } else {
            content.classList.remove("full-width");
        }
    });
    
    let links = document.querySelectorAll("#sidebar .nav-link");
    links.forEach(link => {
        link.addEventListener("click", function () {
            links.forEach(l => l.classList.remove("active"));
            this.classList.add("active");
        });
    });
});