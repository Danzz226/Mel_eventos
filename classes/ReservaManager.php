<?php
/**
 * Classe para gerenciar reservas com encapsulamento
 * Implementa operações CRUD com validações
 */
class ReservaManager {
    private $conn;
    
    /**
     * Construtor da classe
     * @param mysqli $conn Conexão com o banco de dados
     */
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    /**
     * Valida dados de uma reserva
     * @param array $dados Dados da reserva
     * @return array Array com 'valido' (boolean) e 'erros' (array)
     */
    private function validarDados($dados) {
        $erros = [];
        
        // Validação de ID do usuário
        if (empty($dados['id_usuario']) || !is_numeric($dados['id_usuario'])) {
            $erros[] = "ID do usuário inválido";
        }
        
        // Validação de ID do salão
        if (empty($dados['id_salao']) || !is_numeric($dados['id_salao'])) {
            $erros[] = "ID do salão inválido";
        }
        
        // Validação de datas
        if (empty($dados['data_evento_inicio'])) {
            $erros[] = "Data de início é obrigatória";
        }
        
        if (empty($dados['data_evento_fim'])) {
            $erros[] = "Data de fim é obrigatória";
        }
        
        // Verificar se data de fim é maior que data de início
        if (!empty($dados['data_evento_inicio']) && !empty($dados['data_evento_fim'])) {
            $dataInicio = strtotime($dados['data_evento_inicio']);
            $dataFim = strtotime($dados['data_evento_fim']);
            
            if ($dataFim <= $dataInicio) {
                $erros[] = "Data de fim deve ser maior que data de início";
            }
        }
        
        // Validação de número de participantes
        if (empty($dados['numero_participantes_est']) || !is_numeric($dados['numero_participantes_est']) || $dados['numero_participantes_est'] < 1) {
            $erros[] = "Número de participantes deve ser maior que zero";
        }
        
        // Validação de total previsto
        if (empty($dados['total_previsto']) || !is_numeric($dados['total_previsto']) || $dados['total_previsto'] < 0) {
            $erros[] = "Total previsto inválido";
        }
        
        return [
            'valido' => empty($erros),
            'erros' => $erros
        ];
    }
    
    /**
     * Sanitiza dados para prevenir SQL Injection
     * @param mixed $dado Dado a ser sanitizado
     * @return mixed Dado sanitizado
     */
    private function sanitizar($dado) {
        if (is_string($dado)) {
            return $this->conn->real_escape_string($dado);
        }
        return $dado;
    }
    
    /**
     * Lista todas as reservas de um usuário
     * @param int $id_usuario ID do usuário
     * @return array Array com as reservas
     */
    public function listarReservas($id_usuario) {
        $id_usuario = $this->sanitizar($id_usuario);
        
        $sql = "SELECT 
                    r.id_reserva,
                    s.nome AS salao_nome,
                    r.data_evento_inicio,
                    r.data_evento_fim,
                    r.status,
                    r.total_previsto,
                    r.numero_participantes_est,
                    r.observacoes
                FROM Reserva r
                JOIN Salao s ON r.id_salao = s.id_salao
                WHERE r.id_usuario = $id_usuario
                ORDER BY r.data_evento_inicio DESC";
        
        $result = $this->conn->query($sql);
        
        if (!$result) {
            return ['erro' => $this->conn->error];
        }
        
        $reservas = [];
        while ($row = $result->fetch_assoc()) {
            $reservas[] = $row;
        }
        
        return $reservas;
    }
    
    /**
     * Busca uma reserva por ID
     * @param int $id_reserva ID da reserva
     * @return array|null Dados da reserva ou null se não encontrada
     */
    public function buscarReserva($id_reserva) {
        $id_reserva = $this->sanitizar($id_reserva);
        
        $sql = "SELECT r.*, s.nome AS salao_nome 
                FROM Reserva r 
                JOIN Salao s ON r.id_salao = s.id_salao 
                WHERE r.id_reserva = $id_reserva";
        
        $result = $this->conn->query($sql);
        
        if (!$result || $result->num_rows == 0) {
            return null;
        }
        
        return $result->fetch_assoc();
    }
    
    /**
     * Cria uma nova reserva
     * @param array $dados Dados da reserva
     * @return array Array com 'sucesso' (boolean) e 'mensagem' (string)
     */
    public function criarReserva($dados) {
        $validacao = $this->validarDados($dados);
        
        if (!$validacao['valido']) {
            return [
                'sucesso' => false,
                'mensagem' => implode(', ', $validacao['erros'])
            ];
        }
        
        // Sanitizar dados
        $id_usuario = $this->sanitizar($dados['id_usuario']);
        $id_salao = $this->sanitizar($dados['id_salao']);
        $data_evento_inicio = $this->sanitizar($dados['data_evento_inicio']);
        $data_evento_fim = $this->sanitizar($dados['data_evento_fim']);
        $numero_participantes_est = $this->sanitizar($dados['numero_participantes_est']);
        $observacoes = isset($dados['observacoes']) ? $this->sanitizar($dados['observacoes']) : '';
        $total_previsto = $this->sanitizar($dados['total_previsto']);
        $status = isset($dados['status']) ? $this->sanitizar($dados['status']) : 'pendente';
        
        $sql = "INSERT INTO Reserva (
                    id_usuario, 
                    id_salao, 
                    data_evento_inicio, 
                    data_evento_fim, 
                    numero_participantes_est, 
                    observacoes, 
                    total_previsto, 
                    status
                ) VALUES (
                    '$id_usuario',
                    '$id_salao',
                    '$data_evento_inicio',
                    '$data_evento_fim',
                    '$numero_participantes_est',
                    '$observacoes',
                    '$total_previsto',
                    '$status'
                )";
        
        if ($this->conn->query($sql)) {
            return [
                'sucesso' => true,
                'mensagem' => 'Reserva criada com sucesso!',
                'id_reserva' => $this->conn->insert_id
            ];
        } else {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao criar reserva: ' . $this->conn->error
            ];
        }
    }
    
    /**
     * Atualiza uma reserva existente
     * @param int $id_reserva ID da reserva
     * @param array $dados Novos dados da reserva
     * @return array Array com 'sucesso' (boolean) e 'mensagem' (string)
     */
    public function atualizarReserva($id_reserva, $dados) {
        $validacao = $this->validarDados($dados);
        
        if (!$validacao['valido']) {
            return [
                'sucesso' => false,
                'mensagem' => implode(', ', $validacao['erros'])
            ];
        }
        
        // Verificar se a reserva existe
        $reserva = $this->buscarReserva($id_reserva);
        if (!$reserva) {
            return [
                'sucesso' => false,
                'mensagem' => 'Reserva não encontrada'
            ];
        }
        
        // Sanitizar dados
        $id_salao = $this->sanitizar($dados['id_salao']);
        $data_evento_inicio = $this->sanitizar($dados['data_evento_inicio']);
        $data_evento_fim = $this->sanitizar($dados['data_evento_fim']);
        $numero_participantes_est = $this->sanitizar($dados['numero_participantes_est']);
        $observacoes = isset($dados['observacoes']) ? $this->sanitizar($dados['observacoes']) : '';
        $total_previsto = $this->sanitizar($dados['total_previsto']);
        $status = isset($dados['status']) ? $this->sanitizar($dados['status']) : 'pendente';
        
        $sql = "UPDATE Reserva SET
                    id_salao = '$id_salao',
                    data_evento_inicio = '$data_evento_inicio',
                    data_evento_fim = '$data_evento_fim',
                    numero_participantes_est = '$numero_participantes_est',
                    observacoes = '$observacoes',
                    total_previsto = '$total_previsto',
                    status = '$status'
                WHERE id_reserva = " . $this->sanitizar($id_reserva);
        
        if ($this->conn->query($sql)) {
            return [
                'sucesso' => true,
                'mensagem' => 'Reserva atualizada com sucesso!'
            ];
        } else {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao atualizar reserva: ' . $this->conn->error
            ];
        }
    }
    
    /**
     * Exclui uma reserva
     * @param int $id_reserva ID da reserva
     * @return array Array com 'sucesso' (boolean) e 'mensagem' (string)
     */
    public function excluirReserva($id_reserva) {
        // Verificar se a reserva existe
        $reserva = $this->buscarReserva($id_reserva);
        if (!$reserva) {
            return [
                'sucesso' => false,
                'mensagem' => 'Reserva não encontrada'
            ];
        }
        
        $id_reserva = $this->sanitizar($id_reserva);
        
        $sql = "DELETE FROM Reserva WHERE id_reserva = $id_reserva";
        
        if ($this->conn->query($sql)) {
            return [
                'sucesso' => true,
                'mensagem' => 'Reserva excluída com sucesso!'
            ];
        } else {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao excluir reserva: ' . $this->conn->error
            ];
        }
    }
}

