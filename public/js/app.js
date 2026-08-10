// ===============================
// FitTrack App JS
// ===============================

document.addEventListener("DOMContentLoaded", () => {

    animateRings();
    animateWaterGlass();
    animateBars();

    initSidebar();
    initFlashDismiss();
    spawnWaterBubbles();

    initTheme();

    initBmiPreview();

});

// ===============================
// Progress Rings
// ===============================

function animateRings() {

    document.querySelectorAll(".ring-value").forEach(circle => {

        const percent = Math.max(
            0,
            Math.min(100, parseFloat(circle.dataset.percent || 0))
        );

        const radius = parseFloat(circle.getAttribute("r"));

        const circumference = 2 * Math.PI * radius;

        circle.style.strokeDasharray = circumference;

        circle.style.strokeDashoffset = circumference;

        circle.getBoundingClientRect();

        requestAnimationFrame(() => {

            circle.style.strokeDashoffset =
                circumference - (percent / 100) * circumference;

        });

    });

}

// ===============================
// Water Glass
// ===============================

function animateWaterGlass() {

    document.querySelectorAll(".water-fill").forEach(fill => {

        const percent = Math.max(
            0,
            Math.min(100, parseFloat(fill.dataset.percent || 0))
        );

        requestAnimationFrame(() => {

            fill.style.height = percent + "%";

        });

    });

}

// ===============================
// Bar Charts
// ===============================

function animateBars() {

    document.querySelectorAll(".bar").forEach(bar => {

        const percent = Math.max(
            0,
            Math.min(100, parseFloat(bar.dataset.percent || 0))
        );

        requestAnimationFrame(() => {

            bar.style.height = percent + "%";

        });

    });

}
function animateGoalBars(){
    document.querySelectorAll(".goal-progress").forEach(bar =>{
        const percent = Math.max(0,Math.min(
            100,
            parseFloat(bar.dataset.percent) || 0
        ));
        requestAnimationFrame(() =>{
            bar.style.width = percent + "%";
        });
    });
}

// ===============================
// Mobile Sidebar
// ===============================

function initSidebar() {

    const openBtn = document.querySelector("[data-sidebar-open]");
    const sidebar = document.querySelector(".sidebar");
    const backdrop = document.querySelector(".sidebar-backdrop");

    if (!openBtn || !sidebar || !backdrop) return;

    openBtn.addEventListener("click", () => {

        sidebar.classList.add("is-open");
        backdrop.classList.add("is-open");

    });

    backdrop.addEventListener("click", () => {

        sidebar.classList.remove("is-open");
        backdrop.classList.remove("is-open");

    });

}

// ===============================
// Flash Messages
// ===============================

function initFlashDismiss() {

    document.querySelectorAll(".flash").forEach(el => {

        setTimeout(() => {

            el.style.transition = "opacity .4s ease, transform .4s ease";
            el.style.opacity = "0";
            el.style.transform = "translateY(-6px)";

            setTimeout(() => {

                el.remove();

            }, 400);

        }, 4500);

    });

}

// ===============================
// Water Bubble Animation
// ===============================

function spawnWaterBubbles() {

    document.querySelectorAll(".water-glass").forEach(glass => {

        const fill = glass.querySelector(".water-fill");

        if (!fill) return;

        setInterval(() => {

            const percent = parseFloat(fill.style.height || 0);

            if (percent < 8) return;

            const bubble = document.createElement("span");

            bubble.className = "water-bubble";

            const size = 3 + Math.random() * 4;

            bubble.style.width = size + "px";
            bubble.style.height = size + "px";
            bubble.style.left = (10 + Math.random() * 70) + "%";
            bubble.style.animationDuration = (2.4 + Math.random() * 1.4) + "s";

            fill.appendChild(bubble);

            setTimeout(() => {

                bubble.remove();

            }, 3600);

        }, 900);

    });

}

// ===============================
// BMI Preview
// ===============================

function initBmiPreview() {

    const bmiHeight = document.getElementById("bmi_height_input");
    const bmiWeight = document.getElementById("bmi_weight_input");
    const bmiPreview = document.getElementById("bmi_live_preview");

    if (!bmiHeight || !bmiWeight || !bmiPreview) return;

    function update() {

        const h = parseFloat(bmiHeight.value);
        const w = parseFloat(bmiWeight.value);

        if (!h || !w) {

            bmiPreview.textContent = "—";
            return;

        }

        const bmi = w / Math.pow(h / 100, 2);

        bmiPreview.textContent = bmi.toFixed(1);

    }

    bmiHeight.addEventListener("input", update);
    bmiWeight.addEventListener("input", update);

}

// ===============================
// Theme Toggle
// ===============================

function initTheme() {

    const themeBtn = document.getElementById("theme-toggle");

    if (!themeBtn) return;

    if (localStorage.getItem("theme") === "light") {

        document.body.classList.add("light-theme");
        themeBtn.textContent = "☀️ Light";

    } else {

        themeBtn.textContent = "🌙 Dark";

    }

    themeBtn.addEventListener("click", () => {

        document.body.classList.toggle("light-theme");

        if (document.body.classList.contains("light-theme")) {

            localStorage.setItem("theme", "light");
            themeBtn.textContent = "☀️ Light";

        } else {

            localStorage.setItem("theme", "dark");
            themeBtn.textContent = "🌙 Dark";

        }

    });

}