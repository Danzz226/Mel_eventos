# Sistema de Reservas - EventHub

Sistema completo de gerenciamento de reservas de eventos com área administrativa, baseado no padrão CRUD com encapsulamento e validações.

## 📁 Estrutura do Projeto

### Organização de Pastas

```
Mel_eventos/
├── pages/              # Páginas principais do sistema
│   ├── home.php        # Página inicial com navegação
│   ├── login.php       # Página de login
│   ├── register.php    # Página de cadastro
│   ├── login_process.php
│   ├── register_process.php
│   └── logout.php
│
├── admin/              # Área administrativa
│   ├── login.php       # Login administrativo
│   ├── login_process.php
│   ├── logout.php      # Logout admin
│   └── executivos.php  # Painel administrativo
│
├── crud_operations/   # Operações CRUD
│   ├── gerenciar_eventos.php  # Formulário de criação
│   ├── create_reserva.php     # Criar reserva
│   ├── edit_reserva.php       # Editar reserva
│   ├── update_reserva.php     # Atualizar reserva
│   └── delete_reserva.php     # Excluir reserva
│
├── services/           # Páginas de serviços
│   ├── saloes.php
│   ├── planejamento.php
│   ├── calculo.php
│   └── gestao.php
│
├── includes/           # Arquivos de configuração
│   └── conexao.php     # Conexão com banco de dados
│
├── classes/            # Classes PHP
│   └── ReservaManager.php  # Classe com encapsulamento
│
├── assets/             # Recursos estáticos
│   ├── css/
│   │   └── style.css  # Estilos principais
│   └── js/
│       ├── main.js    # JavaScript geral
│       └── reservas.js # Validações e cálculos
│
├── index.php          # Redirecionador principal
└── crud_eventos.sql   # Script do banco de dados
```

## 🎯 Características

✅ **Estrutura Organizada**: Arquivos separados por funcionalidade  
✅ **Área Administrativa**: Login separado para administradores  
✅ **Encapsulamento**: Classe ReservaManager com métodos privados  
✅ **Validações**: Validação de dados no front-end e back-end  
✅ **Design Moderno**: Cores personalizadas (#DEEB50 e #000004)  
✅ **Google Fonts**: Fonte Poppins integrada  
✅ **Responsivo**: Design adaptável para diferentes telas  
✅ **Navegação Intuitiva**: Menu com acesso rápido à área admin  

## 🚀 Como Usar

### 1. Configuração Inicial

1. Importe o banco de dados `crud_eventos.sql` no MySQL/MariaDB
2. Configure a conexão em `includes/conexao.php` se necessário
3. Acesse `index.php` no navegador

### 2. Fluxo de Uso

#### Usuário Regular:
1. Acesse `pages/login.php` para fazer login
2. Na página inicial (`pages/home.php`):
   - Navegue pelas seções (Início, Sobre, Serviços, Contato)
   - Clique em "Gerenciar Eventos" para criar reservas
   - Use "Login Admin" no menu para acessar área administrativa

#### Administrador:
1. Faça login como usuário regular
2. Clique em "Login Admin" no menu (credenciais: `admin`/`admin`)
3. Acesse a "Área Executiva" para:
   - Visualizar todas as reservas
   - Editar reservas
   - Excluir reservas
   - Ver estatísticas do sistema

### 3. Navegação Admin

- **Menu Principal**: Botão "Minha Área" aparece quando autenticado como admin
- **Após Alterações**: Botões para voltar à Área Executiva ou Gerenciar Eventos
- **Logout Admin**: Mantém sessão de usuário, apenas remove autenticação admin

## 🗄️ Banco de Dados

### Tabelas Principais

- **`usuario`**: Usuários do sistema
- **`Salao`**: Salões disponíveis (com `capacidade_max`)
- **`Reserva`**: Reservas de eventos

### Estrutura da Tabela Salao

```sql
CREATE TABLE Salao (
  id_salao INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(255),
  descricao TEXT,
  capacidade_max INT,  -- Capacidade máxima de pessoas
  status ENUM('ativo', 'manutencao', 'inativo'),
  ...
);
```

## 🎨 Tecnologias Utilizadas

- **Back-end**: PHP 7.4+ com classes e objetos
- **Banco de Dados**: MySQL/MariaDB
- **Front-end**: HTML5 semântico, CSS3, JavaScript ES6+
- **Fontes**: Google Fonts (Poppins)
- **Padrões**: CRUD completo, encapsulamento, validações

## 📝 Requisitos Atendidos

### Front-end
✅ HTML5 semântico  
✅ CSS3 nativo  
✅ Google Fonts (Poppins)  
✅ Background da página  
✅ Interações com JavaScript  
✅ Navegação clara e intuitiva  
✅ Formulários funcionais (label e input)  
✅ Interação com usuário (botões, links)  
✅ Exibição correta de conteúdo  

### Back-end
✅ Listagem de dados do banco  
✅ Inclusão de registros via PHP  
✅ Exclusão de registros via PHP  
✅ Alteração de dados via PHP  
✅ Requisições POST/GET  
✅ Funções  
✅ Validação de dados  
✅ Classes e Objetos com encapsulamento  

## 🔐 Credenciais Padrão

- **Admin**: `admin` / `admin`
- **Usuários**: Criados através do sistema de registro

## 📌 Notas Importantes

- A área executiva requer login administrativo separado
- O sistema valida datas e calcula totais automaticamente
- Todas as operações CRUD passam pela classe ReservaManager
- O design utiliza cores personalizadas (#DEEB50 e #000004)
