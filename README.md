# Sistema de Reservas - Mel Eventos

Sistema simplificado de gerenciamento de reservas de eventos, baseado no padrão CRUD simples.

## Estrutura do Projeto

### Arquivos Principais
- `index.php` - Página principal com formulário de nova reserva e listagem
- `conexao.php` - Arquivo de conexão com o banco de dados
- `login.php` - Página de login
- `register.php` - Página de cadastro
- `logout.php` - Logout do sistema

### CRUD de Reservas
- `create_reserva.php` - Criar nova reserva
- `edit_reserva.php` - Editar reserva existente
- `update_reserva.php` - Atualizar reserva
- `delete_reserva.php` - Excluir reserva

### Arquivos de Processamento
- `login_process.php` - Processar login
- `register_process.php` - Processar cadastro

### Frontend
- `crud/style.css` - Estilos CSS clássicos e profissionais
- `crud/style2.css` - Estilos CSS modernos com efeitos visuais avançados
- `js/reservas.js` - JavaScript para validações e cálculos

## Características

✅ **Simplicidade**: Baseado no padrão da pasta "crud professor"  
✅ **Dois Estilos Disponíveis**: CSS clássico e profissional com efeitos visuais  
✅ **JavaScript Separado**: Lógica frontend em arquivo dedicado  
✅ **Fácil Manutenção**: Estrutura simples e organizada  
✅ **Responsivo**: Design adaptável para diferentes telas  
✅ **Efeitos Visuais**: Gradientes, animações e glassmorphism no style2.css  

## Como Usar

### Versão Clássica (style.css)
1. Acesse `login.php` para fazer login
2. Na página principal (`index.php`) você pode:
   - Criar novas reservas
   - Visualizar todas as suas reservas
   - Editar reservas existentes
   - Excluir reservas

### Versão Profissional (style2.css)
1. Acesse `login_profissional.php` para fazer login
2. Na página principal (`index_profissional.php`) você pode:
   - Criar novas reservas com efeitos visuais
   - Visualizar reservas com design moderno
   - Editar reservas com animações fluidas
   - Excluir reservas com confirmações elegantes

### Comparação de Estilos
- Acesse `comparacao_estilos.php` para ver as diferenças entre os dois estilos

## Banco de Dados

O sistema utiliza as tabelas:
- `usuario` - Usuários do sistema
- `Salao` - Salões disponíveis
- `Reserva` - Reservas de eventos

## Tecnologias

- PHP 7.4+
- MySQL/MariaDB
- HTML5
- CSS3
- JavaScript ES6+
