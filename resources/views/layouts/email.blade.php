<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', '') }}</title>
    <style>
        :root {
            --primary-color: #3B4BF9;
            --primary-dark: #2A35E8;
            --secondary-color: #FF8243;
            --secondary-dark: #E6653A;
            --background-color: #f9f9f9;
            --text-color: #333333;
            --muted-color: #666666;
            --border-color: #e9ecef;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            font-size: 16px;
        }

        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background-color: var(--primary-color);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        .email-header .subtitle {
            margin: 8px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }

        .email-body {
            background-color: var(--background-color);
            padding: 30px;
        }

        .email-body h2 {
            color: var(--primary-color);
            margin-top: 0;
            font-size: 24px;
        }

        .email-body h3 {
            color: var(--dark-color);
            font-size: 20px;
            margin: 20px 0 10px 0;
        }

        .email-body h4 {
            color: var(--dark-color);
            font-size: 18px;
            margin: 15px 0 8px 0;
        }

        .button {
            display: inline-block;
            background-color: var(--primary-color);
            color: white !important;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: var(--secondary-color);
        }

        .button.secondary {
            background-color: var(--secondary-color);
        }

        .button.secondary:hover {
            background-color: var(--secondary-dark);
        }

        .info-box {
            background-color: white;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid var(--primary-color);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: var(--muted-color);
        }

        .email-footer {
            background-color: var(--light-color);
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: var(--muted-color);
            border-top: 1px solid var(--border-color);
        }

        .email-footer p {
            margin: 5px 0;
        }



        /* Responsividade */
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            
            .email-header, .email-body, .email-footer {
                padding: 20px 15px;
            }
            
            .button {
                display: block;
                text-align: center;
                margin: 15px 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>{{ config('app.name', '') }}</h1>
        </div>
        
        <div class="email-body">
            {{ $slot }}
        </div>
        
        <div class="email-footer">
            <p>© 2025 Emprega Paulínia - Conectando talentos às oportunidades.</p>
        </div>
    </div>
</body>
</html>
