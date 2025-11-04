/**
 * JavaScript principal para interatividade do site
 */

// Smooth scroll para links de navegação
document.addEventListener('DOMContentLoaded', function() {
    // Adicionar smooth scroll aos links de navegação
    const navLinks = document.querySelectorAll('.nav-link[href^="#"]');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                targetSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Atualizar URL sem recarregar a página
                history.pushState(null, null, targetId);
            }
        });
    });
    
    // Animação de entrada para cards
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observar elementos para animação
    const animatedElements = document.querySelectorAll('.about-card, .service-card, .contact-item');
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
    
    // Efeito parallax simples no hero
    const hero = document.querySelector('.hero');
    if (hero) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const heroContent = hero.querySelector('.hero-content');
            if (heroContent) {
                heroContent.style.transform = `translateY(${scrolled * 0.3}px)`;
            }
        });
    }
    
    // Adicionar classe ativa ao link de navegação atual
    const currentSection = window.location.hash || '#inicio';
    const activeLink = document.querySelector(`.nav-link[href="${currentSection}"]`);
    if (activeLink) {
        activeLink.style.color = 'var(--primary-color)';
    }
});

// Função para validar formulários
function validarFormulario(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let valido = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            valido = false;
            input.style.borderColor = '#dc3545';
            
            // Remover estilo de erro após o usuário começar a digitar
            input.addEventListener('input', function() {
                this.style.borderColor = '';
            });
        }
    });
    
    return valido;
}

// Função para mostrar mensagens de feedback
function mostrarMensagem(mensagem, tipo = 'success') {
    const mensagemDiv = document.createElement('div');
    mensagemDiv.className = `mensagem-flutuante ${tipo}`;
    mensagemDiv.textContent = mensagem;
    mensagemDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 5px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        animation: slideIn 0.3s ease;
        ${tipo === 'success' ? 'background-color: #28a745;' : 'background-color: #dc3545;'}
    `;
    
    document.body.appendChild(mensagemDiv);
    
    setTimeout(() => {
        mensagemDiv.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => mensagemDiv.remove(), 300);
    }, 3000);
}

// Adicionar animações CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

