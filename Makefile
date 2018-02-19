composer:
	composer install

phpunit:
	./bin/phpunit

phpcs:
	./vendor/bin/php-cs-fixer fix --rules=@Symfony src

phpcs-dry-run:
	./vendor/bin/php-cs-fixer fix --dry-run --diff --rules=@Symfony src

docker-phpunit:
	$(MAKE) docker-command COMMAND="make phpunit"

docker-phpcs:
	$(MAKE) docker-command COMMAND="make phpcs"

docker-phpcs-dry-run:
	$(MAKE) docker-command COMMAND="make phpcs-dry-run"

docker-build:
	docker build -t talkspirit-bot-demo .

docker-command:
	docker run -it --rm --name my-running-script -v ${PWD}:/var/www -w /var/www talkspirit-bot-demo $(COMMAND)

.PHONY: composer phpunit phpcs docker-build docker-command
