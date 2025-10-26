# 🚀 Inventário IFPR — Aplicação Web

**Versão:** 1.0 • **Data:** 24/10/2025

Resumo: Sistema web de gestão de inventário para IFPR Campus Astorga — cadastro de bens patrimoniais, rastreabilidade por QR Code, movimentações e relatórios.

---

## 🧭 Navegador / Fluxo da Aplicação (visão por rotas)

- /  
  - Landing / resumo do sistema, CTA: Entrar
- /login  
  - Formulário SIAPE + senha — Recuperar senha
- /dashboard  
  - Cards: total itens, status; gráficos e atalhos rápidos
- /items  
  - Lista com busca, filtros (tombamento, status, local). Ações: Novo, Importar CSV, Exportar
- /items/{id}  
  - Detalhe: tombamento, foto, QR (gerar/baixar), histórico, ações (editar, transferir, baixa)
- /locations  
  - Gerenciar salas/setores
- /reports  
  - Gerar relatórios PDF/CSV por filtros
- /scan  
  - Leitor QR (mobile) → redireciona para /items/{id}

---

## ✅ Funcionalidades Principais

- Autenticação SIAPE com roles (admin / user)
- CRUD de itens com validação de tombamento único
- Geração e download de QR Code por item
- Histórico completo de movimentações e auditoria
- Importação CSV com relatório de erros
- Relatórios exportáveis (PDF / CSV)
- Controle de permissões por role

---

## 🛠️ Tecnologias

- Frontend: HTML5, CSS3, JavaScript, Bootstrap, Chart.js
- Backend: PHP 8.2+, PDO (prepared statements), JWT ou sessão
- Bibliotecas: dompdf, simplesoftwareio/simple-qrcode (Composer)
- Banco: MySQL 8.0 (InnoDB, utf8mb4)
- Ambiente local sugerido: XAMPP (Windows)

---

## 📁 Estrutura sugerida do repositório

- public/ — assets, ponto de entrada
- src/ — controllers, models, services
- routes/ — definições de rotas web/api
- database/ — schema.sql, seeds
- storage/uploads — fotos e QR
- tests/ — PHPUnit
- documentação/ — inventario.md

---

## 🚀 Instalação local (Windows / XAMPP)

1. Copiar para C:\xampp\htdocs\inventario1  
2. Criar DB e importar schema:
   - Abra CMD:  
     mysql -u root -p inventario1 < C:\xampp\htdocs\inventario1\database\schema.sql
3. Copiar .env.example → .env e ajustar DB_*, APP_URL  
4. Instalar dependências (Composer):
   - Abra CMD em C:\xampp\htdocs\inventario1  
     composer install
5. Iniciar Apache e MySQL via XAMPP Control Panel  
6. Acessar: http://localhost/inventario1

Observação: Instale dompdf e simplesoftwareio/simple-qrcode via composer para PDFs/QR.

---

## 🔐 Segurança e boas práticas

- Senhas: password_hash (bcrypt)
- Prepared statements (PDO) — evitar SQL Injection
- Validação frontend + backend
- Rate limit no login
- HTTPS em produção
- Backups regulares (mysqldump)

---

## 🧪 Testes

- Unitários (PHPUnit): validação de tombamento, criação de item, geração de QR
- Integração: importação CSV, endpoints de movimentação
- E2E: fluxo login → criar item → scan QR

Exemplo: instalar phpunit e rodar:
```batch
composer require --dev phpunit/phpunit
vendor\bin\phpunit --configuration phpunit.xml
```

---

## 📡 Exemplos rápidos de API

Autenticar:
```bash
curl -X POST http://localhost/inventario1/api/auth/login \
 -H "Content-Type: application/json" \
 -d '{"siape":"012345","password":"senha"}'
```

Criar item:
```http
POST /api/items
Content-Type: application/json

{
  "tombamento":"IFPR-0001",
  "nome":"Computador Dell",
  "categoria":"TI",
  "local_id":1,
  "responsavel_id":2
}
```

---

## 💾 Backup (exemplo Windows Task Scheduler)

Comando:
```batch
mysqldump -u root -p inventario1 > C:\backups\inventario_%DATE:~6,4%%DATE:~3,2%%DATE:~0,2%.sql
```

---

## 📐 Contribuição e branches

- Criar branch: feature/descrição
- Abrir PR com descrição e testes
- Revisão e CI executam testes

---

## 👥 Contatos / Responsáveis

- Backend: Jeferson  
- Frontend: João  
- QA / Documentação: Asael  
- Líder: Samuel

---

## ⚖️ Licença

Adicionar LICENSE (ex.: MIT) no repositório.

---

Se desejar, aplico este README.md no caminho c:\xampp\htdocs\inventario1\README.md ou ajusto para incluir screenshots, exemplos de curl detalhados ou schema SQL gerado.
