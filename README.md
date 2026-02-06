# ☕ Café Premium

## 📌 Descrição
Projeto acadêmico desenvolvido como trabalho interno do 3 semestre da faculdade.  
O sistema consiste em um site de **assinaturas de café**, onde usuários podem escolher planos, gerenciar assinaturas.

## 🎯 Objetivo
O objetivo do projeto é aplicar na prática os conhecimentos adquiridos em **Laravel**, **MVC**, **banco de dados** e **desenvolvimento web**, simulando uma aplicação real de e-commerce por assinatura.

## 🚀 Funcionalidades
- Cadastro e login de usuários
- Escolha de planos de assinatura de café
- Gerenciamento de assinaturas
- Área administrativa para gerenciamento de produtos e planos
- Histórico de assinaturas

## 🛠 Tecnologias Utilizadas
- PHP
- Laravel
- Blade
- SQLite
- HTML, CSS, JavaScript

## ▶️ Como executar o projeto
```bash
# Clone o repositório
git clone https://github.com/seuusuario/nome-do-repositorio

# Acesse a pasta do projeto
cd nome-do-repositorio

# Instale as dependências
composer install

# Copie o arquivo de ambiente
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate

# Configure o banco de dados no arquivo .env

# Rode as migrations
php artisan migrate

# Inicie o servidor
php artisan serve
