<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nova Candidatura de Emprego</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #2563eb;">Nova Candidatura Recebida</h2>
        
        <p>Uma nova candidatura de emprego foi recebida para a vaga: <strong>{{ $job->title }}</strong>.</p>
        
        <div style="background-color: #f3f4f6; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <h3 style="margin-top: 0;">Detalhes da Candidatura:</h3>
            <p style="margin: 5px 0;"><strong>Candidato:</strong> {{ $application->user->name }}</p>
            <p style="margin: 5px 0;"><strong>Email do Candidato:</strong> {{ $application->user->email }}</p>
            @if($application->cover_letter)
            <p style="margin: 5px 0;"><strong>Carta de Apresentação:</strong></p>
            <p style="margin: 10px 0; padding: 10px; background-color: #fff; border-left: 3px solid #2563eb;">
                {{ $application->cover_letter }}
            </p>
            @endif
        </div>
        
        <p>Por favor, faça o login no painel do empregador para revisar a candidatura.</p>
        
        <p style="margin-top: 30px;">
            Atenciosamente,<br>
            <strong>Equipe {{ $portal_name }}</strong>
        </p>
    </div>
</body>
</html>
