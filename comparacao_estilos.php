<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparação de Estilos - Mel Eventos</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #1e293b;
            margin-bottom: 40px;
            font-size: 2.5rem;
        }
        .comparison {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        .style-card {
            background: #f8fafc;
            border-radius: 15px;
            padding: 30px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        .style-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .style-card h2 {
            color: #1e293b;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }
        .style-card p {
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .features {
            list-style: none;
            padding: 0;
        }
        .features li {
            padding: 8px 0;
            color: #64748b;
            position: relative;
            padding-left: 25px;
        }
        .features li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #10b981;
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin: 10px 10px 10px 0;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        .btn-professional {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .btn-professional:hover {
            box-shadow: 0 10px 20px rgba(240, 147, 251, 0.3);
        }
        .demo-section {
            text-align: center;
            margin-top: 40px;
            padding-top: 40px;
            border-top: 2px solid #e2e8f0;
        }
        .demo-section h3 {
            color: #1e293b;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        @media (max-width: 768px) {
            .comparison {
                grid-template-columns: 1fr;
            }
            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎨 Comparação de Estilos</h1>
        
        <div class="comparison">
            <div class="style-card">
                <h2>📱 Style.css - Clássico</h2>
                <p>Design limpo e funcional, perfeito para sistemas corporativos tradicionais.</p>
                <ul class="features">
                    <li>Cores neutras e profissionais</li>
                    <li>Animações sutis</li>
                    <li>Layout responsivo</li>
                    <li>Fácil manutenção</li>
                    <li>Compatibilidade ampla</li>
                </ul>
                <a href="login.php" class="btn">Ver Login Clássico</a>
                <a href="index.php" class="btn">Ver Sistema Clássico</a>
            </div>
            
            <div class="style-card">
                <h2>✨ Style2.css - Profissional</h2>
                <p>Design moderno com efeitos visuais impressionantes e animações fluidas.</p>
                <ul class="features">
                    <li>Gradientes vibrantes</li>
                    <li>Glassmorphism e blur effects</li>
                    <li>Animações avançadas</li>
                    <li>Efeitos hover sofisticados</li>
                    <li>Design futurístico</li>
                </ul>
                <a href="login_profissional.php" class="btn btn-professional">Ver Login Profissional</a>
                <a href="index_profissional.php" class="btn btn-professional">Ver Sistema Profissional</a>
            </div>
        </div>
        
        <div class="demo-section">
            <h3>🚀 Escolha seu Estilo</h3>
            <p style="color: #64748b; margin-bottom: 30px;">
                Ambos os estilos estão totalmente funcionais e podem ser usados em produção. 
                O style.css é ideal para ambientes corporativos, enquanto o style2.css é perfeito 
                para projetos que precisam impressionar visualmente.
            </p>
            
            <div style="background: #f1f5f9; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <h4 style="color: #1e293b; margin-bottom: 15px;">💡 Como Trocar de Estilo:</h4>
                <p style="color: #64748b; margin: 0;">
                    Para usar o style2.css, simplesmente altere a linha do CSS nos arquivos PHP de:<br>
                    <code style="background: #e2e8f0; padding: 2px 6px; border-radius: 4px;">&lt;link rel="stylesheet" href="crud/style.css"&gt;</code><br>
                    para:<br>
                    <code style="background: #e2e8f0; padding: 2px 6px; border-radius: 4px;">&lt;link rel="stylesheet" href="crud/style2.css"&gt;</code>
                </p>
            </div>
        </div>
    </div>
</body>
</html>

