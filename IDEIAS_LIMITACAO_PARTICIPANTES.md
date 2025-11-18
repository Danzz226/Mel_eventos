# 💡 Ideias para Limitar Participantes pela Capacidade do Salão

Este documento apresenta várias abordagens para implementar a limitação do número de participantes baseado na capacidade máxima do salão selecionado.

## 🎯 Abordagens Possíveis

### 1. **Validação no Front-end (JavaScript) - RECOMENDADO**

#### Implementação:
- Adicionar atributo `data-capacidade` nas opções do select de salões
- Usar JavaScript para atualizar o atributo `max` do input de participantes dinamicamente
- Validar em tempo real enquanto o usuário digita

#### Vantagens:
- Feedback imediato ao usuário
- Melhor experiência do usuário
- Não requer alterações no banco de dados

#### Código Exemplo:
```javascript
// No gerenciar_eventos.php, adicionar data-capacidade:
<option value="<?= $s['id_salao'] ?>" data-capacidade="<?= $s['capacidade_max'] ?? '' ?>">
    <?= $s['nome'] ?>
</option>

// No JavaScript (reservas.js):
const selectSalao = document.getElementById("id_salao");
const inputParticipantes = document.getElementById("numero_participantes_est");

selectSalao.addEventListener('change', function() {
    const capacidade = this.options[this.selectedIndex].getAttribute('data-capacidade');
    if (capacidade && capacidade !== '') {
        inputParticipantes.setAttribute('max', capacidade);
        inputParticipantes.setAttribute('title', `Máximo: ${capacidade} pessoas`);
    } else {
        inputParticipantes.removeAttribute('max');
    }
});
```

---

### 2. **Validação no Back-end (PHP) - OBRIGATÓRIO**

#### Implementação:
- Validar na classe `ReservaManager` antes de inserir/atualizar
- Buscar capacidade do salão no banco de dados
- Retornar erro se exceder a capacidade

#### Vantagens:
- Segurança: não pode ser burlado
- Validação definitiva
- Pode retornar mensagens específicas

#### Código Exemplo (em ReservaManager.php):
```php
private function validarCapacidade($id_salao, $numero_participantes) {
    $sql = "SELECT capacidade_max FROM Salao WHERE id_salao = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id_salao);
    $stmt->execute();
    $result = $stmt->get_result();
    $salao = $result->fetch_assoc();
    
    if ($salao['capacidade_max'] && $numero_participantes > $salao['capacidade_max']) {
        return [
            'valido' => false,
            'mensagem' => "Este salão suporta no máximo {$salao['capacidade_max']} pessoas. Você informou {$numero_participantes}."
        ];
    }
    
    return ['valido' => true];
}

// No método criarReserva:
$validacaoCapacidade = $this->validarCapacidade($dados['id_salao'], $dados['numero_participantes_est']);
if (!$validacaoCapacidade['valido']) {
    return ['sucesso' => false, 'mensagem' => $validacaoCapacidade['mensagem']];
}
```

---

### 3. **Constraint no Banco de Dados (MySQL)**

#### Implementação:
- Criar trigger ou stored procedure
- Adicionar CHECK constraint (MySQL 8.0.16+)

#### Vantagens:
- Validação no nível do banco
- Impossível burlar mesmo com acesso direto ao banco

#### Código SQL:
```sql
-- Opção 1: Trigger (compatível com versões antigas)
DELIMITER $$
CREATE TRIGGER verificar_capacidade_antes_insert
BEFORE INSERT ON Reserva
FOR EACH ROW
BEGIN
    DECLARE capacidade_max INT;
    SELECT capacidade_max INTO capacidade_max 
    FROM Salao 
    WHERE id_salao = NEW.id_salao;
    
    IF capacidade_max IS NOT NULL AND NEW.numero_participantes_est > capacidade_max THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = CONCAT('Capacidade máxima excedida. Máximo: ', capacidade_max);
    END IF;
END$$
DELIMITER ;

-- Opção 2: CHECK Constraint (MySQL 8.0.16+)
ALTER TABLE Reserva
ADD CONSTRAINT check_capacidade
CHECK (
    numero_participantes_est IS NULL OR
    numero_participantes_est <= (
        SELECT capacidade_max 
        FROM Salao 
        WHERE Salao.id_salao = Reserva.id_salao
    )
);
```

**Nota**: A constraint com subquery pode não funcionar em todas as versões do MySQL.

---

### 4. **Validação Híbrida (Front + Back + Banco)**

#### Implementação:
- JavaScript para UX (feedback imediato)
- PHP para validação de segurança
- Trigger no banco como última camada de proteção

#### Vantagens:
- Máxima segurança
- Melhor experiência do usuário
- Proteção em múltiplas camadas

---

## 🔧 Modificações Necessárias no Banco de Dados

### Se quiser garantir que todos os salões tenham capacidade:

```sql
-- Atualizar salões sem capacidade para ter um valor padrão
UPDATE Salao 
SET capacidade_max = 100 
WHERE capacidade_max IS NULL;

-- Ou definir um valor específico por salão
UPDATE Salao 
SET capacidade_max = 300 
WHERE nome = 'Salão Principal';

UPDATE Salao 
SET capacidade_max = 80 
WHERE nome = 'Salão de Festas Kids';

UPDATE Salao 
SET capacidade_max = 50 
WHERE nome = 'Salão VIP';
```

### Adicionar índice para melhor performance:

```sql
-- Já existe na estrutura, mas verificar:
ALTER TABLE Salao 
ADD INDEX idx_capacidade (capacidade_max);
```

---

## 📋 Checklist de Implementação

- [ ] Adicionar `data-capacidade` nas opções do select
- [ ] Implementar validação JavaScript em tempo real
- [ ] Adicionar método `validarCapacidade()` na classe ReservaManager
- [ ] Validar em `criarReserva()` e `atualizarReserva()`
- [ ] Criar trigger no banco de dados (opcional, mas recomendado)
- [ ] Atualizar mensagens de erro para serem mais claras
- [ ] Testar com diferentes capacidades
- [ ] Testar com salões sem capacidade (NULL)

---

## 🎨 Melhorias de UX

### Feedback Visual:
```javascript
// Mostrar mensagem informativa
if (capacidade) {
    const infoDiv = document.createElement('small');
    infoDiv.id = 'infoCapacidade';
    infoDiv.textContent = `Capacidade máxima: ${capacidade} pessoas`;
    infoDiv.style.color = '#666';
    inputParticipantes.parentElement.appendChild(infoDiv);
}

// Validar em tempo real
inputParticipantes.addEventListener('input', function() {
    const valor = parseInt(this.value);
    if (valor > capacidade) {
        this.style.borderColor = '#dc3545';
        // Mostrar erro
    } else {
        this.style.borderColor = '';
    }
});
```

---

## ⚠️ Considerações Importantes

1. **Salões sem capacidade**: Decidir se permite número ilimitado ou define um padrão
2. **Performance**: Se houver muitos salões, considerar cache da capacidade
3. **Mensagens**: Tornar as mensagens de erro claras e úteis
4. **Acessibilidade**: Garantir que usuários com leitores de tela recebam feedback

---

## 🚀 Recomendação Final

**Implementar a Abordagem Híbrida (Opção 4)**:
1. JavaScript para validação em tempo real (melhor UX)
2. PHP na classe ReservaManager (segurança)
3. Trigger no banco (proteção extra)

Isso garante máxima segurança e melhor experiência do usuário.

