<?php
session_start();
include "conexao.php";

// Verifica se está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_nome = $_SESSION['usuario_nome'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mel Eventos - Página Inicial</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Navegação Superior -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <h1>🎉 Mel Eventos</h1>
            </div>
            <ul class="nav-menu">
                <li><a href="#inicio" class="nav-link">Início</a></li>
                <li><a href="#sobre" class="nav-link">Sobre</a></li>
                <li><a href="#servicos" class="nav-link">Serviços</a></li>
                <li><a href="#contato" class="nav-link">Contato</a></li>
                <li class="user-info">
                    <span>👤 <?= htmlspecialchars($usuario_nome) ?></span>
                    <a href="logout.php" class="btn-logout">Sair</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Seção Início -->
    <section id="inicio" class="hero">
        <div class="container">
            <div class="hero-content">
                <h2 class="hero-title">Bem-vindo ao Mel Eventos</h2>
                <p class="hero-subtitle">Sua plataforma completa para gerenciar eventos inesquecíveis</p>
                <a href="gerenciar_eventos.php" class="btn-primary">Gerenciar Eventos</a>
            </div>
        </div>
    </section>

    <!-- Seção Sobre -->
    <section id="sobre" class="section">
        <div class="container">
            <h2 class="section-title">Sobre Nós</h2>
            <div class="about-content">
                <div class="about-card">
                    <h3>🎯 Nossa Missão</h3>
                    <p>Facilitar o gerenciamento de eventos, oferecendo uma plataforma intuitiva e completa para reservas de salões e planejamento de eventos.</p>
                </div>
                <div class="about-card">
                    <h3>✨ Nossos Valores</h3>
                    <p>Compromisso com a excelência, simplicidade na utilização e suporte total ao cliente em cada etapa do processo.</p>
                </div>
                <div class="about-card">
                    <h3>🚀 Tecnologia</h3>
                    <p>Utilizamos as melhores tecnologias para garantir segurança, performance e uma experiência única para nossos usuários.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Seção Serviços -->
    <section id="servicos" class="section section-alt">
        <div class="container">
            <h2 class="section-title">Nossos Serviços</h2>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">🏛️</div>
                    <h3>Reserva de Salões</h3>
                    <p>Escolha entre diversos salões disponíveis, com diferentes capacidades e ambientes.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">📅</div>
                    <h3>Planejamento de Eventos</h3>
                    <p>Gerencie datas, horários e detalhes do seu evento de forma simples e organizada.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">💰</div>
                    <h3>Cálculo de Custos</h3>
                    <p>Sistema automático de cálculo de valores com base em serviços e participantes.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">📊</div>
                    <h3>Gestão Completa</h3>
                    <p>Acompanhe todas as suas reservas, edite informações e mantenha tudo organizado.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Seção Contato -->
    <section id="contato" class="section">
        <div class="container">
            <h2 class="section-title">Entre em Contato</h2>
            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-item">
                        <span class="contact-icon">📧</span>
                        <div>
                            <h4>E-mail</h4>
                            <p>contato@meleventos.com.br</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">📱</span>
                        <div>
                            <h4>Telefone</h4>
                            <p>(11) 9999-9999</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">📍</span>
                        <div>
                            <h4>Endereço</h4>
                            <p>São Paulo, SP - Brasil</p>
                        </div>
                    </div>
                </div>
                <div class="contact-cta">
                    <h3>Pronto para começar?</h3>
                    <p>Gerencie seus eventos agora mesmo!</p>
                    <a href="gerenciar_eventos.php" class="btn-primary">Gerenciar Eventos</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Rodapé -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Mel Eventos. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>

