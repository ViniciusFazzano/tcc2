<p>Você solicitou a recuperação de senha.</p>
<p>Clique no link abaixo para redefinir sua senha:</p>
<a href="{{ url('http://localhost:5173/refresh-password?token=' . $token . '&email=' . $email) }}">
    Redefinir Senha
</a>