document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".bg-slide");
    const prefersReducedMotion = window.matchMedia(
        "(prefers-reduced-motion: reduce)",
    ).matches;
    let currentSlide = 0;
    const slideInterval = 5000;

    function nextSlide() {
        if (slides.length === 0) return;
        slides[currentSlide].classList.remove("active");
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add("active");
    }

    if (slides.length > 1 && !prefersReducedMotion) {
        setInterval(nextSlide, slideInterval);
    }

    const togglePasswordBtn = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("studentPassword");

    if (togglePasswordBtn && passwordInput) {
        togglePasswordBtn.addEventListener("click", function () {
            const type =
                passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            this.setAttribute("aria-pressed", String(type === "text"));

            const icon = this.querySelector("i");
            if (type === "text") {
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });
    }

    const loginForm = document.getElementById("loginForm");

    if (loginForm) {
        loginForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const studentIdInput = document.getElementById("studentId");
            const passwordField = document.getElementById("studentPassword");
            if (!studentIdInput || !passwordField) return;

            const studentId = studentIdInput.value.trim();
            const password = passwordField.value.trim();

            if (!studentId || !password) {
                alert("Please enter your Student ID and Password.");
                return;
            }

            alert(
                `[Non-Functional Prototype]\nLogin attempted with Student ID: ${studentId}.\nThe main homepage has not been constructed yet.`,
            );
        });
    }

    const resetPasswordLink = document.getElementById("resetPasswordLink");
    if (resetPasswordLink) {
        resetPasswordLink.addEventListener("click", function (e) {
            e.preventDefault();
            alert("Password reset is currently unavailable in this prototype.");
        });
    }
});
