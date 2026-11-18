CosmoBeleza — Sistema de E-commerce (Projeto de Extensão)

Desenvolvimento de uma loja virtual própria para a marca CosmoBeleza(antiga 'estetikaecia'), empreendimento digital do segmento de estética e autocuidado no Rio de Janeiro. O projeto visa reduzir a dependência de marketplaces externos, eliminar altas taxas de comissão por venda e dar autonomia de gestão à proprietária.

Evolução do Projeto

Primeira etapa(2EXT — Modelo Navegável e Validação de Fluxos):
  Definição da identidade visual, vitrine integrada ao catálogo inicial, carrinho de compras com cupom promocional (`COSMO10`), checkout com destaque para PIX e interface administrativa de gestão de produtos.
Segunda etapa(3EXT — Evolução Arquitetural e Persistência):
  Refatoração da estrutura de página única (SPA) para páginas independentes (MPA), implementação de autenticação e validação na inserção de dados em todos os formulários, controle de acesso restrito ao painel administrativo e persistência completa de clientes, pedidos e pagamentos no MySQL.

Tecnologias Utilizadas
  Frontend: HTML5, CSS3 e JavaScript
  Backend e Banco de Dados: PHP 8.x e MySQL / MariaDB
  Ambiente Local: XAMPP (Apache + phpMyAdmin)

Como Executar Localmente:
  1. Inicie os módulos Apache e MySQL no painel de controle do XAMPP.
  2. Acesse `http://localhost/phpmyadmin`, crie um banco de dados chamado `loja_estetica` e importe o arquivo `loja_estetica.sql`.
  3. Copie os arquivos deste repositório para uma pasta dentro de `C:\xampp\htdocs\` (ex.: `C:\xampp\htdocs\cosmobeleza`).
  4. Acesse no navegador: `http://localhost/cosmobeleza/loja.php`.
