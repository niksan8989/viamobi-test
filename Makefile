docker-up:
	docker-compose up -d

docker-build:
	docker-compose up --build -d

docker-down:
	docker-compose down

docker-clear:
	docker-compose down -v --remove-orphans

install: perm
	docker-compose exec php-cli composer install
	docker-compose exec php-cli php artisan migrate

perm:
	sudo chgrp -R www-data storage
	sudo chmod -R ug+rwx storage
test-unit:
	docker-compose run --rm php-cli composer test -- --testsuite=Unit
