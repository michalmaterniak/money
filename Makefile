rm-vendor:
	rm -f -R vendor/
	rm -f composer.lock
down:
	docker compose down
php82-up:
	docker compose up -d --remove-orphans php82

php82-sh: php82-up
	docker compose exec -it php82 bash

php82-test: rm-vendor php82-up
	docker compose exec -it php82 composer install
	docker compose exec -it php82 composer run-script tests