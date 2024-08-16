.PHONY: up up-d app npm-dev

up:
	docker compose up

up-d:
	docker compose up

app:
	docker compose exec app bash -c "cd /var/www/html/laravel && bash"

npm-dev:
	docker compose exec app bash -c "cd /var/www/html/laravel && npm run dev"
