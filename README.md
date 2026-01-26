# Product service

## Create product database + user on mysql server
```
kubectl -n cloudshopt exec -it cloudshopt-mysql-0 -- bash

mysql -u root -prootpass
```

```
CREATE DATABASE cloudshopt_products CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'users'@'%' IDENTIFIED BY 'userspass';
GRANT ALL PRIVILEGES ON cloudshopt_products.* TO 'users'@'%';
FLUSH PRIVILEGES;
```

Ustvari še bazo za *dev* okolje
```
CREATE DATABASE cloudshopt_products_dev CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'users_dev'@'%' IDENTIFIED BY 'userspass';
GRANT ALL PRIVILEGES ON cloudshopt_products_dev.* TO 'users_dev'@'%';
FLUSH PRIVILEGES;
```

## Crete external secrets for prod and dev
prod:
```
kubectl -n cloudshopt create secret generic product-service-secrets \
  --from-literal=DB_PASSWORD="userspass" \
  --from-literal=REDIS_PASSWORD="redispass" \
  --dry-run=client -o yaml | kubectl apply -f -
```

dev:
```
kubectl -n cloudshopt-dev create secret generic product-service-secrets \
  --from-literal=DB_PASSWORD="userspass" \
  --from-literal=REDIS_PASSWORD="redispass" \
  --dry-run=client -o yaml | kubectl apply -f -
```

check for secrets:
```
kubectl get secret -n cloudshopt product-service-secrets
kubectl get secret -n cloudshopt-dev product-service-secrets
```

## Install product-service for prod and dev
prod:
```
helm upgrade --install product-service ./helm/product-service \
-n cloudshopt \ 
-f helm/product-service/values.yaml
```

dev:
```
helm upgrade --install product-service-dev ./helm/product-service \
-n cloudshopt-dev \ 
-f helm/product-service/values-dev.yaml
```



## Migrations

run migrations:
```
kubectl exec -n cloudshopt-dev -it deploy/product-service-dev -c app -- sh

# php artisan migrate
```
