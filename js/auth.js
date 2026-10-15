
document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll("[data-auth-tab]");
    const panels = document.querySelectorAll(".auth-panel");

    if (!tabs.length || !panels.length) return;

    function activateTab(tabName) {
        const selectedPanel = document.getElementById(tabName);

        // Comprobar que existe el panel solicitado
        if (!selectedPanel || !selectedPanel.classList.contains("auth-panel")) {
            return;
        }

        // Actualizar las pestañas
        tabs.forEach((tab) => {
            const isActive = tab.dataset.authTab === tabName;

            tab.classList.toggle("is-active", isActive);
            tab.setAttribute("aria-selected", String(isActive));
        });

        // Mostrar el formulario correspondiente
        panels.forEach((panel) => {
            const isActive = panel.id === tabName;

            panel.classList.toggle("is-active", isActive);
            panel.hidden = !isActive;
        });
    }

    // Cambiar de formulario al pulsar una pestaña
    tabs.forEach((tab) => {
        tab.addEventListener("click", () => {
            activateTab(tab.dataset.authTab);
        });
    });

    // Permitir abrir directamente una pestaña mediante la URL
    const params = new URLSearchParams(window.location.search);
    const requestedTab = params.get("tab");

    activateTab(
        requestedTab === "login" ? "login" : "register"
    );
});
