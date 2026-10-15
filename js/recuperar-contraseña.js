
/* =========================================================
   MARKETNUS — RECUPERAR CONTRASEÑA
   Supabase Auth
   ========================================================= */

document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    // =====================================================
    // CONFIGURACIÓN DE SUPABASE
    // =====================================================

    const SUPABASE_URL = "TU_SUPABASE_URL";
    const SUPABASE_ANON_KEY = "TU_SUPABASE_ANON_KEY";

    // URL a la que regresará el usuario desde el email.
    const REDIRECT_URL =
        `${window.location.origin}/pages/nueva-password.html`;

    // =====================================================
    // ELEMENTOS DEL DOM
    // =====================================================

    const form = document.querySelector(".auth-form-fields");
    const emailInput = form?.querySelector('input[type="email"]');
    const submitButton = document.querySelector(".auth-submit");
    const message = document.querySelector(".auth-message");

    if (!form || !emailInput || !submitButton || !message) {
        console.error(
            "Marketnus: no se encontraron todos los elementos del formulario."
        );
        return;
    }

    // =====================================================
    // COMPROBAR LA LIBRERÍA DE SUPABASE
    // =====================================================

    if (!window.supabase?.createClient) {
        showMessage(
            "No se ha podido conectar con el servicio. Inténtalo más tarde.",
            "error"
        );

        console.error(
            "Marketnus: carga la librería JavaScript de Supabase antes de este archivo."
        );
        return;
    }

    const supabase = window.supabase.createClient(
        SUPABASE_URL,
        SUPABASE_ANON_KEY
    );

    // =====================================================
    // MENSAJES
    // =====================================================

    function showMessage(text, type = "success") {
        message.textContent = text;
        message.hidden = false;

        message.setAttribute("role", "status");
        message.setAttribute("aria-live", "polite");
        message.dataset.type = type;
    }

    function hideMessage() {
        message.textContent = "";
        message.hidden = true;
        delete message.dataset.type;
    }

    // =====================================================
    // ESTADO DEL BOTÓN
    // =====================================================

    function setLoading(isLoading) {
        submitButton.disabled = isLoading;

        if (isLoading) {
            submitButton.dataset.originalText =
                submitButton.textContent.trim();

            submitButton.textContent = "Enviando...";
            submitButton.setAttribute("aria-busy", "true");
        } else {
            submitButton.textContent =
                submitButton.dataset.originalText ||
                "Enviar enlace de recuperación";

            submitButton.removeAttribute("aria-busy");
            delete submitButton.dataset.originalText;
        }
    }

    // =====================================================
    // VALIDACIÓN DEL EMAIL
    // =====================================================

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    emailInput.addEventListener("input", () => {
        hideMessage();
        emailInput.removeAttribute("aria-invalid");
    });

    // =====================================================
    // ENVIAR SOLICITUD DE RECUPERACIÓN
    // =====================================================

    form.addEventListener("submit", async (event) => {
        event.preventDefault();

        hideMessage();

        const email = emailInput.value.trim();

        if (!email) {
            showMessage(
                "Introduce tu dirección de correo electrónico.",
                "error"
            );

            emailInput.setAttribute("aria-invalid", "true");
            emailInput.focus();
            return;
        }

        if (!isValidEmail(email)) {
            showMessage(
                "Introduce una dirección de correo electrónico válida.",
                "error"
            );

            emailInput.setAttribute("aria-invalid", "true");
            emailInput.focus();
            return;
        }

        setLoading(true);

        try {
            const { error } =
                await supabase.auth.resetPasswordForEmail(email, {
                    redirectTo: REDIRECT_URL
                });

            if (error) {
                console.error(
                    "Marketnus: error al solicitar la recuperación.",
                    error.message
                );

                showMessage(
                    "No se ha podido procesar la solicitud. Inténtalo de nuevo más tarde.",
                    "error"
                );

                return;
            }

            showMessage(
                "Si existe una cuenta asociada a ese correo, recibirás un email con las instrucciones para recuperar tu contraseña.",
                "success"
            );

            form.reset();
        } catch (error) {
            console.error(
                "Marketnus: error inesperado.",
                error
            );

            showMessage(
                "Ha ocurrido un error de conexión. Comprueba tu conexión e inténtalo de nuevo.",
                "error"
            );
        } finally {
            setLoading(false);
        }
    });
});