// Validação de datas e cálculo de total
document.addEventListener('DOMContentLoaded', function() {
    const inicio = document.getElementById("data_evento_inicio");
    const fim = document.getElementById("data_evento_fim");
    const erroData = document.getElementById("erroData");

    if (inicio && fim && erroData) {
        inicio.addEventListener("change", () => {
            fim.min = inicio.value;
            validarDatas();
        });

        fim.addEventListener("change", validarDatas);
    }

    function validarDatas() {
        if (inicio.value && fim.value && fim.value < inicio.value) {
            erroData.style.display = "block";
            fim.value = "";
        } else {
            erroData.style.display = "none";
        }
    }

    function calcularTotal() {
        let convidados = parseInt(document.getElementById("numero_participantes_est").value) || 0;
        let dataInicio = new Date(inicio.value);
        let dataFim = new Date(fim.value);
        let dias = 1;

        if (!isNaN(dataInicio) && !isNaN(dataFim) && dataFim > dataInicio) {
            let diff = Math.ceil((dataFim - dataInicio) / (1000 * 60 * 60 * 24));
            dias = diff > 0 ? diff + 1 : 1;
        }

        let total = 0;

        document.querySelectorAll('input[name="servicos[]"]:checked').forEach(serv => {
            let preco = parseFloat(serv.getAttribute("data-preco"));
            if (serv.value === "buffet") {
                total += preco * convidados;
            } else {
                total += preco;
            }
        });

        total += 2000 * dias; // valor base diário do salão
        total += convidados * 10; // custo adicional por convidado

        document.getElementById("total").innerText = total.toFixed(2);
        document.getElementById("total_previsto").value = total.toFixed(2);
    }

    const formReserva = document.getElementById("formReserva");
    if (formReserva) {
        formReserva.addEventListener("input", calcularTotal);
    }
});
