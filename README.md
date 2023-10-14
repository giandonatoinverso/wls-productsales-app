PHP application of a basic wholesaling ERP that allows users to authenticate with a custom OAuth server: https://github.com/giandonatoinverso/wls-backend-server and manages different functions based on different access privileges (called scopes).

# Setup
You can use the example docker compose file that creates the complete stack

```bash
docker compose build --no-cache && docker compose -p wslStack up -d
```

# Usage
Browse to http://localhost:8888 and login with those accounts:

- root
  - root@company.com
  - root
- admin
  - admin@company.com
  - admin
- user
  - user@company.com
  - user

After login, based on the user you can test each functionality provided thanks to the backend API present in the same OAuth server: https://github.com/giandonatoinverso/wls-backend-server

## Context

This repository is part of a set of four interconnected projects created as part of my work for the security exam for service-oriented architectures: https://www.unimi.it/it/corsi/insegnamenti-dei-corsi-di-laurea/2024/sicurezza-delle-architetture-orientate-ai-servizi

1. [wls-productsales-app](https://github.com/giandonatoinverso/wls-productsales-app): PHP ERP application with custom OAuth authentication for role-based access privileges.

2. [wls-auth-client](https://github.com/giandonatoinverso/wls-auth-client): A PHP application for OAuth authentication, returning authorization codes and usernames for authenticated users to an editable endpoint

3. [wls-backend-server](https://github.com/giandonatoinverso/wls-backend-server): OAuth authentication server and wholesale system backend in TypeScript

4. [wsl-db](https://github.com/giandonatoinverso/wsl-db): Database