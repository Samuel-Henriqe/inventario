# 🚀 Inventário IFPR — Aplicação Web

**Versão:** 1.0 • **Data:** 24/10/2025

Resumo: Sistema web de gestão de inventário para IFPR Campus Astorga — cadastro de bens patrimoniais, rastreabilidade por QR Code, movimentações e relatórios.

---

## 🧭 Navegação / Páginas da Aplicação

### **📱 Páginas Implementadas:**
- `index.php` - Login email corporativo + senha, recuperar senha
- `view/home.php` - Dashboard com cards de navegação
- `view/cadastro-lista-itens.php` - CRUD completo de itens + listagem
- `view/localizacao.php` - Gestão de localizações/setores
- `view/etiqueta.php` - Geração de etiquetas QR individuais

### **🚧 Páginas em Desenvolvimento:**
- `view/movimento.php` - Movimentações de itens
- `view/usuarios.php` - Gestão de usuários  
- `view/categorias.php` - Gestão de categorias
- `view/relatorios.php` - Relatórios e exportações
- `view/item.php` - Detalhamento individual de item

---

## ✅ Funcionalidades Implementadas

- ✅ **Autenticação:** Login email corporativo + senha com sessões PHP
- ✅ **CRUD de Itens:** Cadastro, listagem, edição e exclusão completos
- ✅ **Gestão de Localizações:** CRUD de locais/setores
- ✅ **QR Code:** Geração de etiquetas individuais para impressão
- ✅ **Interface Responsiva:** Menu lateral desktop + offcanvas mobile
- ✅ **Validações:** Frontend (JavaScript) + backend (PHP)

## 🚧 Funcionalidades em Desenvolvimento

- 🚧 **Movimentações:** Transferência de itens entre locais
- 🚧 **Usuários:** Gestão completa de usuários e permissões  
- 🚧 **Categorias:** CRUD de categorias de itens
- 🚧 **Relatórios:** Exportação PDF/CSV e dashboards
- 🚧 **Auditoria:** Histórico de alterações

---

## 🛠️ Tecnologias

- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5.3.2, SweetAlert2
- **Backend:** PHP 8.2+, PDO (prepared statements), Sessões PHP
- **Bibliotecas JavaScript:** QRCode.js (geração QR), SweetAlert2 (alerts)
- **Bibliotecas PHP:** PHPMailer (envio emails), Composer (em uso)
- **Banco:** MySQL 8.0 (InnoDB, utf8mb4)
- **Ambiente:** XAMPP (Apache + MySQL + PHP)
- **Versionamento:** Git + GitHub
- **Segurança:** Prepared statements, escape HTML, validação frontend/backend


---

## 📁 Estrutura atual do repositório

```
inventario/
├── controller/
│   ├── PHPMailer/          # Biblioteca para envio de emails
│   ├── relatorios/         # Controllers de relatórios
│   ├── select/             # Controllers de consulta
│   ├── insert/            # Controllers de inserção
│   ├── update/            # Controllers de atualização
│   ├── delete/            # Controllers de exclusão
│   ├── conecta_bd.php     # Conexão com banco de dados
│   └── login.php          # Autenticação
├── view/
│   ├── js/                # Scripts JavaScript
│   ├── home.php           # Dashboard principal
│   ├── cadastro-lista-itens.php  # CRUD de itens
│   ├── localizacao.php    # Gestão de localizações
│   ├── usuarios.php       # Gestão de usuários
│   ├── movimento.php      # Movimentações (em desenvolvimento)
│   ├── relatorios.php     # Relatórios (em desenvolvimento)
│   ├── categorias.php     # Categorias (em desenvolvimento)
│   └── styles.css         # Estilos principais
├── qrcode/                # Biblioteca QR Code
├── vendor/                # Dependências Composer
├── documentação/          # Documentação completa
└── index.php              # Página de login
```

---

## 🚀 Instalação local (Windows / XAMPP)

1. **Clonar o repositório:**
   ```bash
   git clone https://github.com/Samuel-Henriqe/inventario.git C:\xampp\htdocs\inventario
   ```

2. **Configurar banco de dados:**
   - Criar database `db_inventario` no MySQL
   - Ajustar conexão em `controller/conecta_bd.php` se necessário

3. **Instalar dependências (se necessário):**
   ```bash
   cd C:\xampp\htdocs\inventario
   composer install
   ```

4. **Iniciar serviços:**
   - Apache e MySQL via XAMPP Control Panel

5. **Acessar aplicação:**
   - URL: `http://localhost/inventario`
   - Login: usar dados de usuário cadastrado no banco

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
 -d '{"email corporativo":"012345","password":"senha"}'
```

Criar item:
```http
POST /api/items
Content-Type: application/json

{
  "numero_patrimonio":"IFPR-0001",
  "nome_item":"Computador Dell",
  "descricao":"Computador Desktop Dell Inspiron 3020",
  "status":"Disponivel",
  "data_aquisicao":"2025-01-15",
  "id_categoria":1,
  "id_localizacao":1
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

- **Líder do Projeto:**
- **Desenvolvimento:** Asael celeghim barbão, Jerferson rodrigo, João Caio, Samuel henrique
- **GitHub:** [Samuel-Henriqe/inventario](https://github.com/Samuel-Henriqe/inventario)

---

## ⚖️ Licença

Adicionar LICENSE (ex.: MIT) no repositório.

---

Se desejar, aplico este README.md no caminho c:\xampp\htdocs\inventario1\README.md ou ajusto para incluir screenshots, exemplos de curl detalhados ou schema SQL gerado.
