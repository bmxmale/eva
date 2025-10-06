# A) Docker Compose

## Prerequisites

Before you begin, ensure that you have the following prerequisites installed on your machine:

- Docker: Install Docker from [https://www.docker.com/get-started](https://www.docker.com/get-started)
- Docker Compose: Follow the installation instructions for your operating system
  from [https://docs.docker.com/compose/install/](https://docs.docker.com/compose/install/)

## Quick start

<procedure>
<step>
Run command
<code-block lang="shell">
docker-compose up -d
</code-block>
</step>
<step>
Switch to container shell
<code-block lang="shell">
docker-compose exec php sh
</code-block>
</step>
<step>
Install dependencies
<code-block lang="shell">
composer install
</code-block>   
</step>
<step>
Migrate database by running command
<code-block lang="shell">
bin/console doctrine:migrations:migrate
</code-block>
</step>
</procedure>

## Testing

To run tests, execute the following command:
<code-block lang="shell">
docker-compose exec php ./vendor/bin/phpunit
</code-block>
