.PHONY: phpstan fix composer-vaid yaml twig container doctrine analyze qa run-dev

phpstan:
	php vendor/bin/phpstan analyse -c phpstan.neon
fix:
	php vendor/bin/php-cs-fixer fix
composer-valid:
	composer valid
yaml:
	php bin/console lint:yaml config --parse-tags
twig:
	php bin/console lint:twig templates
container:
	php bin/console lint:container
doctrine:
	php bin/console doctrine:schema:valid --skip-sync

analyze: twig yaml composer-valid container doctrine phpstan

qa: fix analyze

run-dev:
	symfony server:start -d
	#php bin/console messenger:consume async
	yarn dev-server
