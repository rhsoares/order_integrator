PHP Challenge
===============

Requisitos
- Ambiente com PHP e servidor MySql rodando.

Instruções de instalação
- Fazer o clone do repositório em uma pasta de sua escolha, dentro de seu servidor web
- Executar o comando "composer install"
- Replicar arquivo /app/config/parameters.yml.dist para /app/config/parameters.yml
- Se necessário, alterar os dados conexão de banco de dados (mysql)
- Caso não possua um banco de dados pré criado, executar comando seguinte no prompt para criar o banco de dados
-- php app/console doctrine:database:create
- Em seguida, executar o comando seguinte para gerar a estrutura de banco de dados de acordo com as entidades mapeadas
-- php app/console doctrine:schema:create
- Iniciar servidor embutido do Symfony para rodar o projeto a partir do comando seguinte
-- php app/console server:run
-- Acessar http://localhost:8000 (padrão do server embutido Symfony2)
