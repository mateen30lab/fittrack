const form = document.getElementById("chatForm");
const input = document.getElementById("prompt");
const chatBox = document.getElementById("chatBox");
const typing = document.getElementById("typing");

document.querySelectorAll(".suggestion").forEach(btn => {
    btn.addEventListener("click", () => {
        input.value = btn.innerText;
        input.focus();
    });
});

function addMessage(message, sender) {

    const row = document.createElement("div");
    row.className = "message " + sender;

    const bubble = document.createElement("div");
    bubble.className = "bubble";

    bubble.innerHTML = message.replace(/\n/g, "<br>");

    row.appendChild(bubble);

    chatBox.appendChild(row);

    chatBox.scrollTop = chatBox.scrollHeight;
}

form.addEventListener("submit", async function(e){

    e.preventDefault();

    let prompt = input.value.trim();

    if(prompt === "") return;

    addMessage(prompt,"user");

    input.value="";

    typing.style.display="flex";

    try{

        const response = await fetch("/ai-coach",{

            method:"POST",

            headers:{

                "Content-Type":"application/json",

                "X-CSRF-TOKEN":document.querySelector('input[name="_token"]').value

            },

            body:JSON.stringify({

                prompt:prompt

            })

        });

        const data = await response.json();

        typing.style.display="none";

        addMessage(data.reply,"ai");

    }catch(error){

        typing.style.display="none";

        addMessage("⚠ Unable to connect to AI right now.","ai");

    }

});