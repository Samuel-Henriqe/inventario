# 🚀 Sistema de Inventário IFPR Campus Astorga - Documentação Completa
**Versão:** 1.0 | **Data:** 24/10/2025  
**Equipe:** Asael (Backend), Samuel (Frontend), Jeferson (Database), Joao (Documentação)

---

## 📋 Sumário Executivo
**Visão do Projeto:**  
Sistema web de gestão de inventário para o IFPR Campus Astorga, substituindo processos manuais por uma solução automatizada com rastreabilidade via QR Code.

**Equipe de Desenvolvimento:**
- Samuel – Líder de Projeto / Desenvolvedor
- Jeferson – Desenvolvedor Backend
- João – Desenvolvedor Frontend
- Asael – Analista de QA / Documentação

**Cronograma Geral:** 12 semanas (08/09/2025 a 30/11/2025)  
Metodologia: Iterativa com entregas semanais (POC)

---

## 🎯 Objetivos Estratégicos
**Objetivo Principal:**  
✅ Reduzir em 70% o tempo gasto em conferências anuais com MVP funcional.

**Objetivos Específicos:**
- Digitalizar 100% do cadastro de itens patrimoniais  
- Sistema de rastreamento via QR Code  
- Redução de perdas em 50% no primeiro ano  
- Capacitação da equipe do almoxarifado em 2 semanas  
- Relatórios automáticos para auditoria  

---

## 📊 Análise de Requisitos

### Personas

**Almoxarife (Administrador)**  
- Nome: Carlos Silva  
- Responsabilidades: Gestão completa, cadastro/baixa de itens, geração de relatórios, controle de usuários  
- Necessidades: Sistema intuitivo, relatórios precisos, controle de movimentações, geração de QR Code  

**Conferencista (Usuário Comum)**  
- Nome: Ana Oliveira  
- Responsabilidades: Conferência anual, leitura QR Code, registro de localizações  
- Necessidades: Mobile-friendly, leitura rápida, listas organizadas  

---

### 📝 Requisitos Funcionais

**Módulos:**  
1. Autenticação (RF001-RF005)  
2. Gestão de Itens (RF006-RF015)  
3. Localizações (RF016-RF020)  
4. Relatórios (RF021-RF025)  

| ID | Requisito | Prioridade | Sprint |
|----|-----------|------------|--------|
| RF001 | Login SIAPE | Alta | Semana 4 |
| RF002 | Controle de permissões (Admin/Usuário) | Alta | Semana 4 |
| RF003 | Recuperação de senha | Média | Semana 10 |
| RF004 | Logout automático | Baixa | Semana 10 |
| RF005 | Auditoria de logins | Média | Semana 9 |
| RF006 | Cadastro de itens com número de tombamento | Alta | Semana 5 |
| RF007 | Edição e exclusão de itens | Alta | Semana 5 |
| RF008 | Pesquisa e filtros avançados | Alta | Semana 5 |
| RF009 | Geração de QR Code único | Alta | Semana 7 |
| RF010 | Controle de status (Disponível/Em Uso/Manutenção/Descartado) | Alta | Semana 5 |
| RF011 | Histórico completo de movimentações | Alta | Semana 8 |
| RF012 | Importação em lote via CSV | Média | Semana 11 |
| RF013 | Upload de fotos dos itens | Baixa | Semana 12 |
| RF014 | Validação de número de patrimônio único | Alta | Semana 5 |
| RF015 | Notificação por email na troca de responsável | Média | Semana 11 |
| RF016 | Cadastro de salas e setores | Alta | Semana 6 |
| RF017 | Associação item-localização | Alta | Semana 6 |
| RF018 | Mapa visual de localizações | Baixa | Semana 12 |
| RF019 | Relatório por localização | Alta | Semana 8 |
| RF020 | Histórico de ocupação por local | Média | Semana 11 |
| RF021 | Relatório de bens por setor | Alta | Semana 8 |
| RF022 | Relatório de bens por responsável | Alta | Semana 8 |
| RF023 | Exportação CSV/Excel | Alta | Semana 8 |
| RF024 | Dashboard com métricas | Média | Semana 10 |
| RF025 | Relatório de auditoria | Média | Semana 9 |

---

### 🛡️ Requisitos Não-Funcionais

**Desempenho:**  
- RNF001: Tempo de resposta <3 segundos  
- RNF002: Suporte 50 usuários simultâneos  
- RNF003: 10.000 itens sem degradação  
- RNF004: Relatórios <30 segundos  
- RNF005: Interface responsiva mobile/desktop  

**Segurança:**  
- RNF006: Senhas criptografadas (bcrypt)  
- RNF007: Proteção SQL Injection  
- RNF008: Validação frontend/backend  
- RNF009: Logs de auditoria  
- RNF010: Backup diário automático  

**Usabilidade:**  
- RNF011: Interface intuitiva (curva aprendizado <1h)  
- RNF012: Navegação por teclado  
- RNF013: QR Code legível a 30cm  
- RNF014: Documentação contextual  
- RNF015: Mensagens de erro claras  

---

## 🏗️ Arquitetura do Sistema

**Diagrama ASCII**



**Stack Tecnológica**
- Frontend: HTML5, CSS3, JS, Bootstrap, Chart.js, HTML5 QR Scanner  
- Backend: PHP 8.2+, PDO, DomPDF, Simple-QRCode  
- Banco: MySQL 8.0, InnoDB, utf8mb4  

Semanas: 1   2   3   4   5   6   7   8   9   10  11  12
Fase 1: ███ ███ ███
Fase 2:         ████ ████ ████ ████ ████
Fase 3:                         ████ ████ ████ ████
Módulo Login:         ██
CRUD Itens:               ██
Localizações:                 ██
QR Code:                        ██
Relatórios:                         ██
Testes:                               ██
Implantação:                                  ██
Entrega Final:                                      ██


Funcionalidade: Login
  Cenário: Sucesso
    Dado que estou na página de login
    Quando insiro SIAPE e senha válidos
    Então sou redirecionado ao dashboard
  Cenário: Falha
    Dado que estou na página de login
    Quando insiro SIAPE inválido
    Então vejo mensagem de erro


Funcionalidade: Cadastro de Item
  Cenário: Admin cadastra item válido
    Dado que sou admin
    Quando preencho todos os campos
    Então o item é salvo no sistema e vejo mensagem de sucesso
    E um QR Code único é gerado para o item
    E o histórico de movimentações inicia com o cadastro

---

## Casos de Uso (com fluxos principais)

1. Cadastro de Item
   - Ator: Almoxarife (Admin)
   - Pré-condição: Usuário autenticado com permissão de admin
   - Fluxo principal: Preencher formulário → Validar campos → Inserir no banco → Gerar QR → Mostrar confirmação
   - Pós-condição: Item criado com status inicial "Disponível"

2. Edição de Item
   - Ator: Almoxarife (Admin)
   - Fluxo: Abrir item → Editar campos permitidos → Validar → Salvar → Registrar auditoria

3. Baixa / Exclusão de Item
   - Ator: Almoxarife (Admin)
   - Fluxo: Selecionar item → Marcar como "Descartado" ou remover logicamente → Registrar responsável e motivo → Atualizar histórico

4. Conferência via QR (Conferencista)
   - Ator: Conferencista
   - Pré-condição: Acesso mobile com leitor QR
   - Fluxo: Ler QR → Mostrar detalhes → Validar localização → Registrar presença/movimentação

5. Importação em lote (CSV)
   - Ator: Admin
   - Fluxo: Fazer upload CSV → Validar cada linha (tombamento único) → Inserir/Atualizar → Relatório de falhas

6. Geração de Relatórios
   - Ator: Admin
   - Fluxo: Selecionar filtros → Gerar relatório (PDF/CSV) → Baixar/Enviar por email

---

## Modelagem de Dados (resumo)

- users
  - id INT PK, siape VARCHAR UNIQUE, nome VARCHAR, email VARCHAR, senha VARCHAR, role ENUM('admin','user'), created_at, updated_at
- items
  - id INT PK, tombamento VARCHAR UNIQUE, nome VARCHAR, descricao TEXT, categoria VARCHAR, status ENUM('Disponível','Em Uso','Manutenção','Descartado'), foto_path VARCHAR NULL, qr_code VARCHAR UNIQUE, local_id INT FK, responsavel_id INT FK, created_at, updated_at
- locations
  - id INT PK, nome VARCHAR, setor VARCHAR, descricao TEXT, created_at, updated_at
- movements
  - id INT PK, item_id INT FK, de_local INT NULL, para_local INT NULL, responsavel_from INT NULL, responsavel_to INT NULL, tipo ENUM('transferencia','conferencia','baixa','entrada'), observacao TEXT, created_by INT FK, created_at
- audits
  - id INT PK, user_id INT FK, action VARCHAR, resource_type VARCHAR, resource_id INT, ip VARCHAR, user_agent VARCHAR, created_at

Índices: tombamento, qr_code, siape, (item_id, created_at) para histórico.

---

## API / Endpoints (proposta REST)

- POST /api/auth/login — Autenticação SIAPE
- POST /api/auth/logout — Logout
- GET /api/users — Listar usuários (admin)
- POST /api/items — Criar item (admin)
- GET /api/items — Listar itens (filtros)
- GET /api/items/{id} — Obter item
- PUT /api/items/{id} — Atualizar item (admin)
- DELETE /api/items/{id} — Marcar como descartado (admin)
- POST /api/items/import — Importação CSV (admin)
- GET /api/items/{id}/qr — Gerar/baixar QR Code
- POST /api/movements — Registrar movimentação
- GET /api/reports/{type} — Gerar relatórios (PDF/CSV)

Autenticação: JWT ou sessão PHP; autorização por role.

---

## Testes (sugestões)

- Unitários (PHPUnit):
  - Criação de item com tombamento único
  - Validação de campos obrigatórios
  - Geração correta de QR Code
- Integração:
  - Fluxo de importação CSV (vias endpoints)
  - Registro de movimentação e histórico
- E2E:
  - Login SIAPE → Acesso ao dashboard → Criar item → Conferir QR via página mobile

Exemplo: criar testes em /tests com PHPUnit e usações de Factory/fixtures.

---

## Instalação local (Windows / XAMPP)

Requisitos:
- Windows 10/11, XAMPP (Apache + MySQL), PHP 8.2+, Composer, Node (opcional)

Passos:
1. Copiar projeto para C:\xampp\htdocs\inventario1
2. Criar DB MySQL (ex: inventario1) e importar schema em /database/schema.sql (criar se necessário)
   - No terminal: mysql -u root -p inventario1 < database\schema.sql
3. Copiar .env.example → .env e ajustar DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD
4. Rodar composer install (se houver composer.json)
   - Abra CMD em c:\xampp\htdocs\inventario1
   - composer install
5. Ajustar permissões na pasta de uploads (Windows normalmente ok)
6. Iniciar Apache e MySQL via XAMPP Control Panel
7. Acessar http://localhost/inventario1

Observação: para geração de PDF/QR instale bibliotecas PHP (dompdf, simplesoftwareio/simple-qrcode) via composer.

---

## Backup e Rotina de Manutenção

- Backup diário do banco via job (mysqldump) e salvar em pasta segura:
  - Exemplo agendado com Task Scheduler: mysqldump -u root -p inventario1 > C:\backups\inventario_%DATE%.sql
- Rotina semanal: rever logs de auditoria, rodar testes automatizados
- Retenção: manter últimas 30 cópias diárias

---

## Segurança e Boas Práticas

- Senhas com bcrypt / password_hash
- Prepared statements (PDO) para evitar SQL Injection
- Validação no frontend e backend
- Rate limiting para endpoints de login
- HTTPS em produção

---

## Roadmap & Prioridades (próximas 4 semanas)

- Sprint A (1 semana): Implementar autenticação SIAPE + controle de roles
- Sprint B (2 semanas): CRUD de itens + validação de tombamento único
- Sprint C (1 semana): Geração QR e leitura mobile + relatórios básicos

---

## Responsáveis / Contatos

- Backend: Jeferson
- Frontend: João
- QA / Documentação: Asael
- Líder / Coordenação: Samuel

---

Se quiser, aplico essas alterações diretamente no arquivo README/documentação (acrescento seções adicionais ou gero o schema SQL). Qual parte deseja que eu complete primeiro?

