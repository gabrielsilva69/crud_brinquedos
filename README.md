# Sistema de Gestão de Brinquedos

CRUD simples desenvolvido em PHP e MySQL para cadastrar, listar, editar e excluir brinquedos de uma loja.

## Funcionalidades

- Cadastrar brinquedo
- Listar brinquedos
- Editar brinquedo
- Excluir brinquedo
- Validação básica dos dados
- Prepared Statements nas operações de cadastro, edição e exclusão
- Tratamento básico de erros

## Campos

Cada brinquedo possui:

- Nome
- Categoria
- Faixa etária
- Preço
- Quantidade em estoque

## Como executar no XAMPP

1. Copie a pasta `crud_brinquedos` para `C:\xampp\htdocs\`.
2. Abra o XAMPP e inicie Apache e MySQL.
3. Entre no phpMyAdmin.
4. Importe o arquivo `banco.sql`.
5. Confira em `conexao.php` se usuário, senha e nome do banco estão corretos.
6. Abra no navegador:

`http://localhost/crud_brinquedos/`

## Estrutura

```text
crud_brinquedos/
├── css/
│   └── style.css
├── banco.sql
├── conexao.php
├── index.php
├── cadastrar.php
├── editar.php
├── excluir.php
└── README.md
```

## Prepared Statements

Os valores enviados pelo usuário nas operações de INSERT, UPDATE e DELETE são enviados usando `prepare()` e `bind_param()`, evitando montar SQL com concatenação de dados do formulário.
