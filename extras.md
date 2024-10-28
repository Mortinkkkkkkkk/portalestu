<!-- Frameworks -->
    Ion Icons
     - cdn:
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    Bootstrap
<!-- Comandos -->
Comando do docker-compose
 docker-compose up -d
Comandos dentro do container php
 docker exec portalestudante docker-php-ext-install mysqli
 docker exec portalestudante chmod -R 777 /var/