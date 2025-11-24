document.getElementById("formLogin").addEventListener("submit", function (e) {
    const email = document.querySelector("input[name='email']").value.trim();
    const senha = document.querySelector("input[name='senha']").value.trim();
    const erro = document.getElementById("erro");

    erro.textContent = "";

    if (email === "" || senha === "") {
        e.preventDefault();
        erro.textContent = "Preencha todos os campos.";
        return;
    }

    if (!email.includes("@")) {
        e.preventDefault();
        erro.textContent = "Digite um e-mail válido.";
        return;
    }

    if (senha.length < 4) {
        e.preventDefault();
        erro.textContent = "A senha deve ter pelo menos 4 caracteres.";
        return;
    }
});
