document.addEventListener("DOMContentLoaded", () => {

    if (typeof Chart === "undefined") {
        console.warn("Chart.js is not loaded.");
        return;
    }

    if (!window.analytics) {
        console.warn("window.analytics is not available.");
        return;
    }

    const days = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];

    /* =====================================================
       GLOBAL CHART SETTINGS
    ===================================================== */

    Chart.defaults.color = "#8e9bb3";

    Chart.defaults.font.family =
        "Inter, Arial, sans-serif";


    /* =====================================================
       CALORIES
    ===================================================== */

    const calorieCanvas =
        document.getElementById("calorieChart");

    if (calorieCanvas) {

        new Chart(calorieCanvas, {

            type: "bar",

            data: {

                labels: days,

                datasets: [{

                    data: window.analytics.calories,

                    borderRadius: 10,

                    borderSkipped: false,

                    backgroundColor: [
                        "#ff4d6d",
                        "#ff6b6b",
                        "#ff8787",
                        "#ff4d6d",
                        "#ff6b6b",
                        "#ff8787",
                        "#ff4d6d"
                    ],

                    hoverBackgroundColor: "#ff1744",

                    barPercentage: .65,

                    categoryPercentage: .75

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                animation: {
                    duration: 1500,
                    easing: "easeOutQuart"
                },

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {

                        backgroundColor: "#101827",

                        titleColor: "#fff",

                        bodyColor: "#dce6f7",

                        borderColor: "rgba(255,255,255,.1)",

                        borderWidth: 1,

                        padding: 12,

                        displayColors: false

                    }

                },

                scales: {

                    x: {

                        grid: {
                            display: false
                        },

                        border: {
                            display: false
                        }

                    },

                    y: {

                        beginAtZero: true,

                        grid: {
                            color: "rgba(255,255,255,.06)"
                        },

                        border: {
                            display: false
                        }

                    }

                }

            }

        });

    }


    /* =====================================================
       WATER
    ===================================================== */

    const waterCanvas =
        document.getElementById("waterChart");

    if (waterCanvas) {

        const waterGradient =
            waterCanvas
                .getContext("2d")
                .createLinearGradient(0, 0, 0, 300);

        waterGradient.addColorStop(
            0,
            "rgba(0,212,255,.35)"
        );

        waterGradient.addColorStop(
            1,
            "rgba(0,212,255,0)"
        );


        new Chart(waterCanvas, {

            type: "line",

            data: {

                labels: days,

                datasets: [{

                    data: window.analytics.water,

                    borderColor: "#00d4ff",

                    backgroundColor: waterGradient,

                    fill: true,

                    tension: .45,

                    borderWidth: 3,

                    pointRadius: 5,

                    pointHoverRadius: 8,

                    pointBackgroundColor: "#00d4ff",

                    pointBorderColor: "#fff",

                    pointBorderWidth: 2

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                animation: {
                    duration: 1800,
                    easing: "easeOutQuart"
                },

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {

                        backgroundColor: "#101827",

                        titleColor: "#fff",

                        bodyColor: "#dce6f7",

                        borderColor: "rgba(0,212,255,.35)",

                        borderWidth: 1,

                        padding: 12,

                        displayColors: false

                    }

                },

                scales: {

                    x: {

                        grid: {
                            display: false
                        },

                        border: {
                            display: false
                        }

                    },

                    y: {

                        beginAtZero: true,

                        grid: {
                            color: "rgba(255,255,255,.06)"
                        },

                        border: {
                            display: false
                        }

                    }

                }

            }

        });

    }


    /* =====================================================
       WEIGHT
    ===================================================== */

    const weightCanvas =
        document.getElementById("weightChart");

    if (weightCanvas) {

        const weightGradient =
            weightCanvas
                .getContext("2d")
                .createLinearGradient(0, 0, 0, 300);

        weightGradient.addColorStop(
            0,
            "rgba(123,97,255,.30)"
        );

        weightGradient.addColorStop(
            1,
            "rgba(123,97,255,0)"
        );


        new Chart(weightCanvas, {

            type: "line",

            data: {

                labels: days,

                datasets: [{

                    data: window.analytics.weight,

                    borderColor: "#7b61ff",

                    backgroundColor: weightGradient,

                    fill: true,

                    tension: .4,

                    borderWidth: 3,

                    pointRadius: 5,

                    pointHoverRadius: 8,

                    pointBackgroundColor: "#7b61ff",

                    pointBorderColor: "#fff",

                    pointBorderWidth: 2

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                animation: {
                    duration: 1800,
                    easing: "easeOutQuart"
                },

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {

                        backgroundColor: "#101827",

                        titleColor: "#fff",

                        bodyColor: "#dce6f7",

                        borderColor: "rgba(123,97,255,.35)",

                        borderWidth: 1,

                        padding: 12,

                        displayColors: false

                    }

                },

                scales: {

                    x: {

                        grid: {
                            display: false
                        },

                        border: {
                            display: false
                        }

                    },

                    y: {

                        grid: {
                            color: "rgba(255,255,255,.06)"
                        },

                        border: {
                            display: false
                        }

                    }

                }

            }

        });

    }


    /* =====================================================
       GOAL COMPLETION
    ===================================================== */

    const goalCanvas =
        document.getElementById("goalChart");

    if (goalCanvas) {

        const completed =
            Number(window.analytics.goal.completed || 0);

        const remaining =
            Number(window.analytics.goal.remaining || 0);


        new Chart(goalCanvas, {

            type: "doughnut",

            data: {

                labels: [
                    "Completed",
                    "Remaining"
                ],

                datasets: [{

                    data: [
                        completed,
                        remaining
                    ],

                    backgroundColor: [
                        "#00ff9f",
                        "#2c3a4f"
                    ],

                    borderWidth: 0,

                    hoverOffset: 8

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                cutout: "72%",

                animation: {

                    duration: 1600,

                    easing: "easeOutQuart"

                },

                plugins: {

                    legend: {

                        position: "bottom",

                        labels: {

                            color: "#fff",

                            padding: 18,

                            usePointStyle: true,

                            pointStyle: "circle"

                        }

                    },

                    tooltip: {

                        backgroundColor: "#101827",

                        padding: 12

                    }

                }

            }

        });

    }


    /* =====================================================
       FITNESS SCORE RING
    ===================================================== */

    const ring =
        document.querySelector(".fitness-circle .progress");

    if (ring) {

        const score =
            Math.max(
                0,
                Math.min(
                    100,
                    Number(ring.dataset.score || 0)
                )
            );

        const circumference = 440;

        const offset =
            circumference -
            (score / 100) * circumference;

        ring.style.strokeDashoffset =
            circumference;

        setTimeout(() => {

            ring.style.strokeDashoffset =
                offset;

        }, 500);

    }


    /* =====================================================
       AI FITNESS REPORT
    ===================================================== */

    const aiBtn =
        document.querySelector(".ai-btn");

    const modal =
        document.querySelector(".ai-modal");

    const closeBtn =
        document.getElementById("closeAI");

    const report =
        document.getElementById("aiReport");


    if (aiBtn && modal && report) {

        aiBtn.addEventListener("click", () => {

            modal.style.display = "flex";

            report.innerHTML = `

                <div class="typing-loader">

                    <span></span>
                    <span></span>
                    <span></span>

                </div>

            `;

            setTimeout(() => {

                report.innerHTML = `

                    <h3>Weekly Fitness Summary</h3>

                    <p>
                        You completed
                        <strong>${window.analytics.workouts ?? 0}</strong>
                        workouts this week.
                    </p>

                    <p>
                        Your hydration is showing
                        steady improvement. Keep drinking
                        consistently throughout the day.
                    </p>

                    <p>
                        Your current fitness performance
                        is trending positively. Keep your
                        workout streak alive.
                    </p>

                    <strong style="color:#00f5ff;">
                        Keep pushing. You're getting stronger.
                    </strong>

                `;

            }, 1800);

        });

    }


    if (closeBtn && modal) {

        closeBtn.addEventListener("click", () => {

            modal.style.display = "none";

        });

    }


    /* Close modal when clicking outside */

    if (modal) {

        modal.addEventListener("click", (event) => {

            if (event.target === modal) {

                modal.style.display = "none";

            }

        });

    }


    /* =====================================================
       ACHIEVEMENT ANIMATION
    ===================================================== */

    document
        .querySelectorAll(".achievement-card")
        .forEach((card, index) => {

            card.style.opacity = "0";
            card.style.transform = "translateY(25px)";

            setTimeout(() => {

                card.style.transition =
                    "opacity .5s ease, transform .5s ease";

                card.style.opacity = "1";

                card.style.transform =
                    "translateY(0)";

            }, index * 180);

        });


    /* =====================================================
       AI RISK PREDICTOR
    ===================================================== */

    const riskFill =
        document.getElementById("riskFill");

    const riskPercent =
        document.getElementById("riskPercent");


    if (riskFill && riskPercent) {

        /*
         * Your current design uses 18% as the
         * displayed LOW risk score.
         */

        const score = 18;

        let current = 0;

        riskFill.style.width = "0%";

        setTimeout(() => {

            riskFill.style.width =
                score + "%";

        }, 600);


        const timer =
            setInterval(() => {

                current++;

                riskPercent.textContent =
                    current + "%";

                if (current >= score) {

                    clearInterval(timer);

                }

            }, 35);

    }


    /* =====================================================
       LEADERBOARD ANIMATION
    ===================================================== */

    document
        .querySelectorAll(".leader-row")
        .forEach((row, index) => {

            row.style.opacity = "0";

            row.style.transform =
                "translateX(-40px)";

            setTimeout(() => {

                row.style.transition =
                    "opacity .6s ease, transform .6s ease";

                row.style.opacity = "1";

                row.style.transform =
                    "translateX(0)";

            }, index * 180);

        });

});