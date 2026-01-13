# Configuração do Google reCAPTCHA v2

## Implementação Concluída ✅

Foi implementado o Google reCAPTCHA v2 no formulário de contato do site para proteger contra spam e bots.

## Como Configurar

### 1. Obter as Chaves do reCAPTCHA

1. Acesse o [Google reCAPTCHA Admin](https://www.google.com/recaptcha/admin)
2. Faça login com sua conta Google
3. Clique em "+" para adicionar um novo site
4. Preencha os dados:
   - **Label**: Emprega Paulínia (ou nome desejado)
   - **Tipo de reCAPTCHA**: Selecione "reCAPTCHA v2" → "Checkbox 'Não sou um robô'"
   - **Domínios**: Adicione seus domínios (exemplo: `empregapaulinia.com.br`, `localhost` para desenvolvimento)
5. Aceite os termos e clique em "Enviar"
6. Você receberá duas chaves:
   - **Site Key** (Chave do Site)
   - **Secret Key** (Chave Secreta)

### 2. Configurar no Arquivo .env

Adicione as chaves no seu arquivo `.env`:

```env
# Google reCAPTCHA v2
RECAPTCHA_SITE_KEY=sua_chave_do_site_aqui
RECAPTCHA_SECRET_KEY=sua_chave_secreta_aqui
```

**Importante**: 
- Nunca compartilhe a `RECAPTCHA_SECRET_KEY` publicamente
- Adicione o arquivo `.env` no `.gitignore`

### 3. Testar a Implementação

1. Acesse a página de contato: `/contato`
2. Preencha o formulário
3. Marque o checkbox "Não sou um robô"
4. Envie o formulário

**Chaves de Teste** (funcionam apenas em localhost):
```env
RECAPTCHA_SITE_KEY=6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI
RECAPTCHA_SECRET_KEY=6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe
```

## Arquivos Modificados

1. **config/services.php** - Configuração das chaves
2. **app/Rules/Recaptcha.php** - Regra de validação customizada
3. **app/Http/Controllers/Web/ContactMessageController.php** - Validação no controller
4. **resources/views/contact.blade.php** - Widget reCAPTCHA no formulário
5. **resources/views/layouts/inc/head.blade.php** - Script do Google
6. **.env.example** - Variáveis de ambiente de exemplo

## Como Funciona

1. **Frontend**: O script do Google adiciona um widget de checkbox na página
2. **Validação**: Quando o usuário marca o checkbox, o Google gera um token
3. **Backend**: O token é enviado junto com o formulário
4. **Verificação**: O Laravel valida o token com a API do Google
5. **Resultado**: Se válido, a mensagem é salva no banco e o e-mail é enviado

## Benefícios

- ✅ Proteção contra bots e spam
- ✅ Mensagens de contato salvas no banco de dados
- ✅ Validação server-side segura
- ✅ Fácil configuração
- ✅ Gratuito para a maioria dos sites

## Troubleshooting

### O reCAPTCHA não aparece
- Verifique se as chaves estão configuradas no `.env`
- Confirme se o domínio está registrado no console do Google
- Verifique o console do navegador para erros JavaScript

### Erro "Falha na verificação do reCAPTCHA"
- Verifique se a `RECAPTCHA_SECRET_KEY` está correta
- Confirme se o servidor tem acesso à internet (para chamar a API do Google)
- Limpe o cache do Laravel: `php artisan config:cache`

### Para desenvolvimento local
- Use as chaves de teste fornecidas acima, ou
- Adicione `localhost` e `127.0.0.1` nos domínios permitidos no console do Google

## Documentação Oficial

- [Google reCAPTCHA](https://www.google.com/recaptcha/about/)
- [Documentação de Desenvolvedores](https://developers.google.com/recaptcha/docs/display)
