copy-env:
	php -r "copy('.env.example', '.env');"

dependencies:
	composer install
	composer dump-autoload
	npm install
	npm run build
	php artisan key:generate

docker-up:
	docker-compose up -d

docker-stop:
	docker-compose stop
	
db:
	docker-compose exec php php artisan migrate
	docker-compose exec php php artisan db:seed
	
styles:
	vendor\bin\phpcbf
	vendor\bin\phpcs

tests-run:
	docker-compose exec php php artisan test --testsuit=Integrate
	docker-compose exec php php artisan test --testsuit=Unit
	docker-compose exec php php artisan test --testsuit=Feature

queue:
	docker-compose exec php php artisan aws:upload