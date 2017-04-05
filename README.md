PHP Challenge
===============

Instruções de instalação
- Fazer o clone do repositório
- Executar o comando "composer install"
- Executar comando abaixo no prompt para criar o banco de dados
-- php app/console doctrine:database:create
- Em seguida, executar o comando abaixo para gerar a estrutura de banco de dados de acordo com as entidades mapeadas
-- php app/console doctrine:schema:create
- Iniciar servidor embutido do Symfony para rodar o projeto a partir do comando abaixo
-- php app/console server:run
