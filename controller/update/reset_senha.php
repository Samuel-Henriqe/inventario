<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Teste Redefinição de Senha</title>
<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    form { margin-bottom: 30px; padding: 15px; border: 1px solid #ccc; width: 350px; }
    input { width: 100%; padding: 8px; margin: 5px 0; }
    button { padding: 8px 12px; margin-top: 5px; }
    h2 { margin-top: 0; }
    #resultado { margin-top: 20px; color: green; }
</style>
</head>
<body>

<h1>Teste Redefinição de Senha</h1>

<!-- 1) Enviar Código -->
<form id="formEnviarCodigo">
    <h2>Enviar Código</h2>
    <input type="email" name="email" placeholder="Digite seu e-mail" required>
    <button type="submit">Enviar Código</button>
</form>

<!-- 2) Validar Código -->
<form id="formValidarCodigo">
    <h2>Validar Código</h2>
    <input type="email" name="email" placeholder="Digite seu e-mail" required>
    <input type="text" name="codigo" placeholder="Digite o código" required>
    <button type="submit">Validar Código</button>
</form>

<!-- 3) Atualizar Senha -->
<form id="formAtualizarSenha">
    <h2>Atualizar Senha</h2>
    <input type="email" name="email" placeholder="Digite seu e-mail" required>
    <input type="password" name="senha" placeholder="Nova senha" required>
    <input type="password" name="confirma_senha" placeholder="Confirme a nova senha" required>
    <button type="submit">Atualizar Senha</button>
</form>

<div id="resultado"></div>

<script>
const resultado = document.getElementById('resultado');

function enviarFormulario(form, actionName) {
    form.addEventListener('submit', function(e){
        e.preventDefault();
        const formData = new FormData(form);
        formData.append(actionName, '1');

        fetch('update_senha_usuario.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(text => resultado.textContent = text)
        .catch(err => resultado.textContent = 'Erro: ' + err);
    });
}

// Enviar código
enviarFormulario(document.getElementById('formEnviarCodigo'), 'enviar_codigo');

// Validar código
enviarFormulario(document.getElementById('formValidarCodigo'), 'validar_codigo');

// Atualizar senha
enviarFormulario(document.getElementById('formAtualizarSenha'), 'update_senha');
</script>

</body>
</html>
