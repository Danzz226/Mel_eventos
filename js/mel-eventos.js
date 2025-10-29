// Sistema Mel Eventos - JavaScript Unificado
// Funcionalidades comuns para todo o sistema

// Validação de formulários
function validarFormulario(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.style.borderColor = '#dc3545';
            isValid = false;
        } else {
            field.style.borderColor = '#ccc';
        }
    });
    
    return isValid;
}

// Validação de datas
function validarDatas(dataInicio, dataFim) {
    const inicio = new Date(dataInicio);
    const fim = new Date(dataFim);
    
    if (fim <= inicio) {
        alert('⚠️ A data de fim deve ser posterior à data de início!');
        return false;
    }
    return true;
}

// Cálculo de total para reservas
function calcularTotalReserva() {
    const participantes = parseInt(document.getElementById('numero_participantes_est')?.value) || 0;
    const inicio = document.getElementById('data_evento_inicio')?.value;
    const fim = document.getElementById('data_evento_fim')?.value;
    
    let dias = 1;
    if (inicio && fim) {
        const dataInicio = new Date(inicio);
        const dataFim = new Date(fim);
        
        if (!isNaN(dataInicio) && !isNaN(dataFim) && dataFim > dataInicio) {
            const diff = Math.ceil((dataFim - dataInicio) / (1000 * 60 * 60 * 24));
            dias = diff > 0 ? diff : 1;
        }
    }
    
    // Cálculo: R$ 2000 por dia + R$ 50 por participante
    const total = (2000 * dias) + (participantes * 50);
    
    const totalElement = document.getElementById('total');
    const totalInput = document.getElementById('total_previsto');
    
    if (totalElement) {
        totalElement.textContent = total.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
    
    if (totalInput) {
        totalInput.value = total;
    }
    
    return total;
}

// Formatação de moeda brasileira
function formatarMoeda(valor) {
    return valor.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });
}

// Formatação de data brasileira
function formatarData(data) {
    return new Date(data).toLocaleDateString('pt-BR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Confirmação de exclusão
function confirmarExclusao(mensagem = 'Tem certeza que deseja excluir este item?') {
    return confirm(mensagem);
}

// Auto-hide de mensagens de sucesso/erro
function autoHideMessages() {
    const messages = document.querySelectorAll('.success, .error');
    messages.forEach(msg => {
        setTimeout(() => {
            msg.style.opacity = '0';
            setTimeout(() => {
                msg.remove();
            }, 300);
        }, 3000);
    });
}

// Inicialização quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide de mensagens
    autoHideMessages();
    
    // Validação de datas em formulários de reserva
    const inicioInput = document.getElementById('data_evento_inicio');
    const fimInput = document.getElementById('data_evento_fim');
    
    if (inicioInput && fimInput) {
        inicioInput.addEventListener('change', function() {
            fimInput.min = inicioInput.value;
            calcularTotalReserva();
        });
        
        fimInput.addEventListener('change', function() {
            if (fimInput.value < inicioInput.value) {
                alert('⚠️ A data de fim não pode ser anterior à data de início!');
                fimInput.value = '';
            }
            calcularTotalReserva();
        });
    }
    
    // Cálculo automático quando mudar participantes
    const participantesInput = document.getElementById('numero_participantes_est');
    if (participantesInput) {
        participantesInput.addEventListener('input', calcularTotalReserva);
    }
    
    // Validação de formulários antes do envio
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validarFormulario(form.id)) {
                e.preventDefault();
                alert('⚠️ Por favor, preencha todos os campos obrigatórios!');
            }
        });
    });
});

// Funções utilitárias para uso global
window.MelEventos = {
    validarFormulario,
    validarDatas,
    calcularTotalReserva,
    formatarMoeda,
    formatarData,
    confirmarExclusao
};

