<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }
        .container {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="email"], input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #2e8b57;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background: #246b45;
        }
        .message {
            text-align: center;
            margin-top: 10px;
            color: #444;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Redefinir Senha</h2>

        <!-- Enviar código -->
        <form id="form-envio">
            <input type="email" name="email" placeholder="Seu e-mail" required>
            <button type="submit">Enviar Código</button>
        </form>

        <!-- Validar código -->
        <form id="form-validacao">
            <input type="email" name="email" placeholder="Seu e-mail" required>
            <input type="text" name="codigo" placeholder="Código recebido" required>
            <button type="submit">Validar Código</button>
        </form>

        <!-- Atualizar senha -->
        <form id="form-senha">
            <input type="email" name="email" placeholder="Seu e-mail" required>
            <input type="password" name="senha" placeholder="Nova senha" required>
            <input type="password" name="confirma_senha" placeholder="Confirme a senha" required>
            <button type="submit">Atualizar Senha</button>
        </form>

        <div class="message" id="mensagem"></div>
    </div>

    <script>
        // Função genérica de envio
        async function enviarFormulario(form, extraData) {
            const formData = new FormData(form);
            for (const key in extraData) {
                formData.append(key, extraData[key]);
            }

            const response = await fetch("update_senha_usuario.php", {
                method: "POST",
                body: formData
            });
            const texto = await response.text();
            document.getElementById('mensagem').innerText = texto;
        }

        // Envio de código
        document.getElementById('form-envio').addEventListener('submit', function(e) {
            e.preventDefault();
            enviarFormulario(this, { enviar_codigo: true });
        });

        // Validação do código
        document.getElementById('form-validacao').addEventListener('submit', function(e) {
            e.preventDefault();
            enviarFormulario(this, { validar_codigo: true });
        });

        // Atualização da senha
        document.getElementById('form-senha').addEventListener('submit', function(e) {
            e.preventDefault();
            enviarFormulario(this, { update_senha: true });
        });
    </script>
</body>
</html>
>