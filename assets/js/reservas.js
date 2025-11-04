/**
 * JavaScript para validação e cálculos de reservas
 */
document.addEventListener('DOMContentLoaded', function() {
    const inicio = document.getElementById("data_evento_inicio");
    const fim = document.getElementById("data_evento_fim");
    const erroData = document.getElementById("erroData");
    const formReserva = document.getElementById("formReserva");

    // Validação de datas
    if (inicio && fim && erroData) {
        inicio.addEventListener("change", () => {
            fim.min = inicio.value;
            validarDatas();
        });

        fim.addEventListener("change", validarDatas);

        function validarDatas() {
            if (inicio.value && fim.value && fim.value < inicio.value) {
                erroData.style.display = "block";
                erroData.style.color = "#dc3545";
                fim.value = "";
                fim.style.borderColor = "#dc3545";
            } else {
                erroData.style.display = "none";
                if (fim) fim.style.borderColor = "";
            }
        }
    }

    // Cálculo do total
    function calcularTotal() {
        let convidados = parseInt(document.getElementById("numero_participantes_est")?.value) || 0;
        let dataInicio = inicio ? new Date(inicio.value) : null;
        let dataFim = fim ? new Date(fim.value) : null;
        let dias = 1;

        if (dataInicio && dataFim && !isNaN(dataInicio) && !isNaN(dataFim) && dataFim > dataInicio) {
            let diff = Math.ceil((dataFim - dataInicio) / (1000 * 60 * 60 * 24));
            dias = diff > 0 ? diff + 1 : 1;
        }

        let total = 0;

        // Calcular serviços extras
        document.querySelectorAll('input[name="servicos[]"]:checked').forEach(serv => {
            let preco = parseFloat(serv.getAttribute("data-preco"));
            if (serv.value === "buffet") {
                total += preco * convidados;
            } else {
                total += preco;
            }
        });

        // Valor base do salão (R$ 2000 por dia)
        total += 2000 * dias;
        
        // Custo adicional por convidado (R$ 10 por pessoa)
        total += convidados * 10;

        const totalElement = document.getElementById("total");
        const totalPrevisto = document.getElementById("total_previsto");
        
        if (totalElement) {
            totalElement.innerText = total.toFixed(2);
        }
        
        if (totalPrevisto) {
            totalPrevisto.value = total.toFixed(2);
        }
    }

    // Atualizar total quando houver mudanças
    if (formReserva) {
        formReserva.addEventListener("input", calcularTotal);
        formReserva.addEventListener("change", calcularTotal);
        
        // Calcular total inicial
        calcularTotal();
    }

    // Validação do formulário antes de enviar
    if (formReserva) {
        formReserva.addEventListener("submit", function(e) {
            const totalPrevisto = document.getElementById("total_previsto");
            
            // Validar datas
            if (inicio && fim && inicio.value && fim.value) {
                const dataInicio = new Date(inicio.value);
                const dataFim = new Date(fim.value);
                
                if (dataFim <= dataInicio) {
                    e.preventDefault();
                    alert("⚠️ A data de fim deve ser maior que a data de início!");
                    return false;
                }
            }
            
            // Validar total
            if (totalPrevisto && (!totalPrevisto.value || parseFloat(totalPrevisto.value) <= 0)) {
                e.preventDefault();
                alert("⚠️ Por favor, selecione ao menos um serviço ou verifique os dados!");
                return false;
            }
            
            // Mostrar feedback visual
            const btnSubmit = formReserva.querySelector('.btn-submit');
            if (btnSubmit) {
                btnSubmit.textContent = "Processando...";
                btnSubmit.disabled = true;
            }
        });
    }

    // Adicionar efeitos visuais aos inputs
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });

    // Animar tabela ao carregar
    const tableRows = document.querySelectorAll('.table-reservas tbody tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        row.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        
        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, index * 100);
    });
});

