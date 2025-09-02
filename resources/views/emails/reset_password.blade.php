<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f9fc;
            color: #121214;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #121214;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #5ae3a7;
        }
        p {
            font-size: 15px;
            line-height: 1.6;
            color: #ffffff;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            background-color: #5ae3a7;
            color: #121214 !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Recuperação de Senha</h2>
        <p>Olá,</p>
        <p>Você solicitou a recuperação de senha para sua conta.</p>
        <p>Clique no botão abaixo para redefinir sua senha:</p>

        <a href="{{ url('http://localhost:5173/refresh-password?token=' . $token . '&email=' . $email) }}" class="btn">
            Redefinir Senha
        </a>

        <div class="footer">
            <p>Se você não solicitou a redefinição, pode ignorar este e-mail.</p>
            <p>&copy; {{ date('Y') }} Seu Sistema - Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>
