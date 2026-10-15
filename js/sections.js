document.addEventListener("DOMContentLoaded", () => {
    loadSection("header", "header.html", initHeader);
    loadSection("footer", "footer.html");
});

async function loadSection(id, file, callback) {
    const container = document.getElementById(id);

    if (!container) {
        console.error(`No se encontró #${id}`);
        return;
    }

    try {
        const response = await fetch(file);

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${file}`);
        }

        container.innerHTML = await response.text();

        if (callback) {
            callback(container);
        }
    } catch (error) {
        console.error(`Error al cargar ${file}:`, error);
    }
}

function initHeader(container) {
    const toggle = container.querySelector("#open-menu");
    const navbar = container.querySelector("#navbar");
    const close = container.querySelector(".close-menu");

    if (!toggle || !navbar || !close) {
        console.error("No se encontraron #open-menu, #navbar o .close-menu");
        return;
    }

    toggle.setAttribute("aria-controls", "navbar");
    toggle.setAttribute("aria-expanded", "false");

    function openMenu() {
        navbar.classList.add("active");
        toggle.classList.add("active");
        toggle.setAttribute("aria-expanded", "true");
    }

    function closeMenu() {
        navbar.classList.remove("active");
        toggle.classList.remove("active");
        toggle.setAttribute("aria-expanded", "false");
    }

    toggle.addEventListener("click", (event) => {
        event.preventDefault();

        if (navbar.classList.contains("active")) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    close.addEventListener("click", (event) => {
        event.preventDefault();
        closeMenu();
    });

    navbar.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", closeMenu);
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            closeMenu();
        }
    });
}