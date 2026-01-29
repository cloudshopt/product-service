## product-service
- **Purpose:** Product catalog (list + detail).
- **Base path:** `/api/products`

### Create product database
```
kubectl -n cloudshopt exec -it cloudshopt-mysql-0 -- bash

# mysql -u root -prootpass

CREATE DATABASE cloudshopt_products CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'users'@'%' IDENTIFIED BY 'CHANGE_ME_PASSWORD';
GRANT ALL PRIVILEGES ON cloudshopt_products.* TO 'users'@'%';
FLUSH PRIVILEGES;
```

### Migrations

```
kubectl exec -n cloudshopt -it deploy/product-service -c app -- sh
# php artisan migrate
```
