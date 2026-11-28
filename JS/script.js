// oh my god gleason, use comments!

document.addEventListener("DOMContentLoaded", function () {
    const prefersReducedMotion = window.matchMedia(
        "(prefers-reduced-motion: reduce)",
    ).matches;

    const slides = document.querySelectorAll(".bg-slide");
    let currentSlide = 0;

    if (slides.length > 1 && !prefersReducedMotion) {
        setInterval(function () {
            slides[currentSlide].classList.remove("active");
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add("active");
        }, 5000);
    }

    const wait = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

    let navigating = false;

    async function swapPage(url, pushHistory) {
        const target = new URL(url, window.location.href);
        const content = document.querySelector(".panel-content");
        if (!content) {
            window.location.href = target.href;
            return;
        }

        const exitTime = prefersReducedMotion ? 0 : 240;
        navigating = true;
        content.classList.add("is-leaving");

        try {
            const response = await fetch(target.href);
            if (!response.ok) throw new Error("Page request failed");

            const doc = new DOMParser().parseFromString(
                await response.text(),
                "text/html",
            );
            const nextContent = doc.querySelector(".panel-content");
            if (!nextContent) throw new Error("Page content not found");

            await wait(exitTime);

            content.innerHTML = nextContent.innerHTML;
            document.body.className = doc.body.className;
            document.title = doc.title;

            if (pushHistory) {
                window.history.pushState({ page: target.href }, "", target.href);
            }

            content.classList.remove("is-leaving");
            content.classList.add("is-entering");
            requestAnimationFrame(function () {
                requestAnimationFrame(function () {
                    content.classList.remove("is-entering");
                    const firstField = content.querySelector("input");
                    if (firstField) firstField.focus({ preventScroll: true });
                });
            });
        } catch (error) {
            window.location.href = target.href;
            return;
        } finally {
            if (!prefersReducedMotion) await wait(320);
            navigating = false;
        }
    }

    function isPlainClick(event) {
        return (
            event.button === 0 &&
            !event.metaKey &&
            !event.ctrlKey &&
            !event.shiftKey &&
            !event.altKey
        );
    }

    document.addEventListener("click", function (event) {
        const toggle = event.target.closest(".toggle-password");
        if (toggle) {
            const input = toggle.parentElement.querySelector("input");
            if (!input) return;

            const isPassword = input.getAttribute("type") === "password";
            input.setAttribute("type", isPassword ? "text" : "password");
            toggle.setAttribute("aria-pressed", String(isPassword));

            const icon = toggle.querySelector("i");
            if (icon) {
                icon.classList.toggle("fa-eye", !isPassword);
                icon.classList.toggle("fa-eye-slash", isPassword);
            }
            return;
        }

        const resetLink = event.target.closest("#resetPasswordLink");
        if (resetLink) {
            event.preventDefault();
            alert("Password reset is currently unavailable in this prototype.");
            return;
        }

        const pageLink = event.target.closest("a[data-transition]");
        if (pageLink && isPlainClick(event)) {
            event.preventDefault();
            if (navigating || new URL(pageLink.href).pathname === window.location.pathname) {
                return;
            }
            swapPage(pageLink.href, true);
        }
    });

    document.addEventListener("submit", function (event) {
        if (event.target.id !== "registerForm") return;

        const password = document.getElementById("regPassword");
        const confirm = document.getElementById("regConfirmPassword");

        if (password && confirm && password.value !== confirm.value) {
            event.preventDefault();
            alert("Passwords do not match.");
            confirm.focus();
        }
    });

    window.addEventListener("popstate", function () {
        swapPage(window.location.href, false);
    });
});
