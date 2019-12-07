up:	docker-up

docker-clear: down
	sudo rm -rf ./common/var/docker/postgres

down:
	docker-compose down --remove-orphans

init: docker-clear postgres-volume docker-up composer yii-init migration chmod

init-prod: docker-clear postgres-volume docker-up composer yii-init-prod migration chmod

docker-up:
	docker-compose up --build -d

postgres-volume:
	docker volume create --name=pgdata

yii-init:
	docker-compose exec php-cli php init --env=Development --overwrite=All

yii-init-prod:
	docker-compose exec php-cli php init --env=Production --overwrite=All

composer:
	docker-compose exec php-cli composer install

composer-update:
	docker-compose exec php-cli composer update

migration:
	docker-compose exec php-cli php yii migrate --interactive=0

chmod:
	sudo chmod -R 777 vendor/
