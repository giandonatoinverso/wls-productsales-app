PHP application of a basic wholesaling ERP that allows users to authenticate with a custom OAuth server: https://github.com/giandonatoinverso/wls-backend-server and manages different functions based on different access privileges (called scopes).

# Setup
You can use the example docker compose file that creates the complete stack

```bash
git clone <this_repository>
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

# Development

```bash
task publish-docker
```