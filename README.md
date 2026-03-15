# BeTalent Tech - Teste Prático Back-end (API de Pagamentos)

Este repositório contém a solução parcial para o desafio técnico da BeTalent Tech. O projeto foi desenvolvido em **PHP com Laravel**, buscando atingir os requisitos do **Nível 2**, com forte foco em arquitetura, segurança e Test-Driven Development (TDD).

---

## 🚀 O que foi implementado

O foco desta entrega foi construir uma base estrutural sólida, segura e testada. Até o encerramento do prazo, as seguintes funcionalidades foram validadas e entregues:

* **Modelagem do Banco de Dados:** Estrutura inicial criada contemplando as tabelas `users`, `gateways`, `clients`, `products` e `transactions`.
* **Autenticação e Segurança:**
    * Implementação do **Laravel Sanctum** para emissão e validação de tokens (Bearer Token).
    * Criação da rota pública de Login (`POST /api/login`).
    * Estruturação da base para Controle de Acesso Baseado em Perfis (RBAC), com a adição da coluna `role` na tabela de usuários (preparando o terreno para futuras rotas administrativas).
* **Gestão de Transações:**
    * Criação do Controller, Model e relacionamentos (Eloquent) para as transações.
    * Rota estruturada para listagem de transações (`GET /api/transactions`).
* **Test-Driven Development (TDD):**
    * Cobertura de testes de integração (Feature Tests) para o fluxo de Autenticação (`UserFeatureTest`), validando com sucesso a emissão de tokens e a rejeição de credenciais inválidas (Status 401).
    * Cobertura de testes para o fluxo de listagem (`TransactionFeatureTest`), garantindo o contrato da API, integridade do banco de testes e a estrutura exata do JSON retornado.

---

## ⏳ O que ficou pendente e Justificativa

Devido à limitação de tempo para a execução do desafio, optei por uma abordagem de qualidade em vez de quantidade. Priorizei garantir que o código escrito estivesse perfeitamente coberto por testes, com rotas blindadas e com os fundamentos do framework aplicados corretamente (Injeção de dependências, Facades, Eloquent Relationships).

Por focar nessa base de qualidade, as seguintes regras de negócio específicas do Nível 2 ficaram pendentes:
* Lógica de cálculo do valor da compra com base no produto e quantidade via back-end.
* Integração via HTTP client com os Mocks dos Gateways disponibilizados via Docker (incluindo o envio dos tokens de autenticação exigidos por eles).
* Lógica algorítmica de *fallback* e tentativa de cobrança seguindo a prioridade entre o Gateway 1 e Gateway 2.

---

## 📂 Estrutura do Projeto

A arquitetura segue os padrões da comunidade Laravel, com destaque para:

* **`app/Http/Controllers/`**: Contém o `AuthController` (responsável pela validação e emissão de tokens via Sanctum) e o `TransactionController`.
* **`app/Models/`**: Modelos configurados com liberação de *Mass Assignment* (`$fillable`) e traits de autenticação.
* **`routes/api.php`**: Centralização do roteamento, documentando as portas de entrada da aplicação.
* **`tests/Feature/`**: Onde reside o coração da qualidade do projeto. Testes automatizados que recriam o banco de dados em memória (`RefreshDatabase`) para validar persistência e respostas HTTP.

---

## 💻 Como instalar e rodar o projeto

**Pré-requisitos:** PHP 8.2+, Composer e MySQL.

1. **Clone o repositório:**
   ```bash
   git clone [COLOQUE_SEU_LINK_AQUI]
   cd [NOME_DA_PASTA]
   Instale as dependências:

2. **Instale as dependências:**
    ```bash
    composer install

3. **Configure o ambiente**
    Copie o arquivo de exemplo e gere a chave de segurança da aplicação. Em seguida, configure suas credenciais de banco de dados MySQL no arquivo .env
    ```bash
    cp .env.example .env
    php artisan key:generate

4. **Prepare o BD**
    Rode as migrations para criar a estrutura de tabelas, incluindo as tabelas nativas do Sanctum.
    ```bash
    php artisan migrate

5. **Inicie o servidor local**
    ```Bash
    php artisan serve
    Rodando os testes automatizados (TDD):

6. **Rodando os testes automatizados (TDD):**
    Para atestar a integridade das rotas desenvolvidas, execute a suíte de testes:
    ```Bash
    php artisan test

Só copiar e colar! Desejo muito sucesso nessa entrega. Quer que eu te ajude com mais alguma revisão no código antes de você subir isso para o GitHub?