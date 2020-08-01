docker-up:
	docker-compose up -d

docker-build:
	docker-compose up --build -d

docker-down:
	docker-compose down

docker-clear:
	docker-compose down -v --remove-orphans

install:
	docker-compose exec php-cli composer install
	docker-compose exec php-cli php artisan migrate

perm:
	sudo chgrp -R www-data bootstrap/cache
	sudo chmod -R ug+rwx bootstrap/cache
test-unit:
	docker-compose run --rm php-cli composer test -- --testsuite=Unit
