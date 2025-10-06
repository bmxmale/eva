# EVA

EVA is API endpoint application for E-VISA Assignment system. This is only PoC, do not use in production.

## Quick start

- Requirements:
  - PHP 8.4+
  - Composer
  - Docker (optional, for local environment)

- Install dependencies:
  - composer install

- Run locally (examples):
  - docker-compose up -d
  - ddev start

- Run tests:
  - ./vendor/bin/phpunit

## Documentation

Full documentation is maintained in two places:

- From JetBrains IDE with Writerside plugin
- Compiled PDF/HTML in the `docs/` directory
  - PDF [docs/pdfSourceEVA.pdf](docs/pdfSourceEVA.pdf) 
  - HTML [docs/pdfSourceEVA.html](docs/pdfSourceEVA.html)

## Project structure

- src/ — application source code (controllers, entities, repositories, etc.)
- config/ — Symfony configuration
- public/ — web entry point
- tests/ — test suite
- Writerside/ — Writerside documentation sources
- docs/ — built documentation exports

