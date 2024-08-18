.PHONY: up up-d app npm-dev pint

up:
	docker compose up

up-d:
	docker compose up

app:
	docker compose exec app bash -c "cd /var/www/html/laravel && bash"

db:
	docker compose exec db bash -c "mysql -uuser -ppassword -hdb -P3306 laravel"

npm-dev:
	docker compose exec app bash -c "cd /var/www/html/laravel && npm run dev"

pint:
	docker compose exec app bash -c "cd /var/www/html/laravel && ./vendor/bin/pint --repair"