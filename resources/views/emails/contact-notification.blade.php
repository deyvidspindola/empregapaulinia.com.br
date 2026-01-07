<p>Olá,</p>
<p>Você recebeu uma nova mensagem pelo formulário de contato do site Emprega Paulínia.</p>

<p><strong>Nome:</strong> {{ $messageData->name }}</p>
<p><strong>E-mail:</strong> {{ $messageData->email }}</p>
<p><strong>Assunto:</strong> {{ $messageData->subject }}</p>

<p><strong>Mensagem:</strong></p>
<p>{!! nl2br(e($messageData->message)) !!}</p>

<p><strong>Informações adicionais:</strong></p>
<p>IP: {{ $messageData->ip_address }}<br>
Data/Hora: {{ $messageData->created_at->format('d/m/Y H:i:s') }}</p>

<p>Atenciosamente,<br/>Sistema Emprega Paulínia</p>