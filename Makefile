up:
	docker-compose up -d

down:
	docker-compose down

stop:
	docker-compose stop

ps:
	docker-compose ps

app:
	docker-compose exec app ash

tinker:
	docker-compose exec app php artisan tinker

web:
	docker-compose exec web ash

node:
	docker-compose exec node ash

db:
	docker-compose exec db ash

db_wp:
	docker-compose exec db_wp ash

watch:
	npm run watch --prefix ./src

prod:
	npm run production --prefix ./src

log:
	tail -f ./src/storage/logs/laravel.log

test-feature:
	docker-compose exec app composer feature-test

reset:
	docker-compose exec app php artisan migrate:fresh --seed

cache:
	docker-compose exec app php artisan cache:clear