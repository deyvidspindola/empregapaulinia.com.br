<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Confirmação de Candidatura</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #2563eb;">Candidatura Enviada com Sucesso!</h2>
        
        <p>Olá <strong>{{ $application->user->name }}</strong>,</p>

        <p>Obrigado por se candidatar à vaga: <strong>{{ $application->jobPosting->title }}</strong>.</p>
        
        <p>Nós recebemos sua candidatura com sucesso e a equipe de recrutamento irá revisá-la em breve.</p>
        
        <div style="background-color: #f3f4f6; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p style="margin: 5px 0;"><strong>Data da Candidatura:</strong> {{ $application->created_at->format('d/m/Y H:i') }}</p>
            <p style="margin: 5px 0;"><strong>Vaga:</strong> {{ $application->jobPosting->title }}</p>
        </div>
        
        <p>Boa sorte!</p>
        
        <p style="margin-top: 30px;">
            Atenciosamente,<br>
            <strong>Equipe {{ $portal_name }}</strong>
        </p>
    </div>
</body>
</html>
