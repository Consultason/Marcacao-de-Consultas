document.getElementById("formLogin").addEventListener("submit", function (e) {
    // Adiciona um evento ao formulário para capturar o envio (submit)

    const email = document.querySelector("input[name='email']").value.trim();
    // Pega o valor do campo de e-mail e remove espaços extras

    const senha = document.querySelector("input[name='senha']").value.trim();
    // Pega o valor do campo de senha e remove espaços extras

    const erro = document.getElementById("erro");
    // Elemento onde as mensagens de erro serão exibidas

    erro.textContent = "";
    // Limpa qualquer erro anterior antes de validar

    if (email === "" || senha === "") {
        // Verifica se algum campo está vazio
        e.preventDefault(); 
        // Impede o envio do formulário
        erro.textContent = "Preencha todos os campos.";
        return;
    }

    if (!email.includes("@")) {
        // Verifica se o e-mail contém o símbolo @
        e.preventDefault();
        erro.textContent = "Digite um e-mail válido.";
        return;
    }

    if (senha.length < 4) {
        // Verifica se a senha tem menos de 4 caracteres
        e.preventDefault();
        erro.textContent = "A senha deve ter pelo menos 6 caracteres.";
        return;
    }
});
