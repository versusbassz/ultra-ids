jjj:
	@ echo "There is no default task"

## Tests
test:
	make test-wpunit
	make test-e2e

test-wpunit:
	cd ./custom/dev-env && \
	docker-compose exec -w "/project" test_php vendor/bin/phpunit

test-e2e:
	cd ./custom/dev-env && \
	docker-compose exec -w "/project" test_php vendor/bin/codecept build && \
	docker-compose exec -w "/project" test_php vendor/bin/codecept run acceptance

vnc:
	# sudo apt-get -y install tigervnc-common xtightvncviewer
	# vncpasswd ./tests/e2e/.vnc-passwd
	# password is "secret" (default for Selenium docker-images)
	vncviewer -passwd ./tests/e2e/.vnc-passwd localhost::5900 &

dev-env--shell-test:
	cd ./custom/dev-env && docker-compose exec test_php bash

## Development environment

### Setup
dev-env--up:
	make wp-core-download
	make wp-tests-lib-download
	make dev-env--up-quickly

dev-env--up-quickly:
	make dev-env--download
	cd ./custom/dev-env && make up
	@ echo "\nWaiting for mysql..."
	sleep 5
	make dev-env--install

wp-core-download:
	rm -rf ./custom/wp-core
	git clone --depth=1 --branch=5.9 git@github.com:WordPress/WordPress.git ./custom/wp-core
	rm -rf ./custom/wp-core/.git

wp-tests-lib-download:
	mkdir -p ./custom
	rm -rf ./custom/wp-tests-lib
	svn co https://develop.svn.wordpress.org/tags/5.9/tests/phpunit/includes ./custom/wp-tests-lib/includes
	svn co https://develop.svn.wordpress.org/tags/5.9/tests/phpunit/data     ./custom/wp-tests-lib/data
	svn co https://develop.svn.wordpress.org/tags/5.9/tests/phpunit/tests    ./custom/wp-tests-lib/tests

dev-env--download:
	rm -fr ./custom/dev-env && \
	mkdir -p ./custom/dev-env && \
	cd ./custom/dev-env && \
	git clone -b 5.4.42 --depth=1 -- git@github.com:wodby/docker4wordpress.git . && \
	rm ./docker-compose.override.yml && \
	cp ../../tools/dev-env/docker-compose.yml . && \
	cp ../../tools/dev-env/.env . && \
	cp ../../tools/dev-env/wp-config.php ../wp-core/ && \
	cp ../../tools/dev-env/sunrise.php ../wp-core/wp-content/

dev-env--install:
	cd ./custom/dev-env && \
	\
	docker-compose exec php wp core multisite-install --url="http://id.docker.local:8000/" --title="Dev site" --admin_user="admin" --admin_password="admin" --admin_email="admin@docker.local" --skip-email --skip-config && \
	docker-compose exec php wp plugin activate hh-sortable --network && \
	docker-compose exec php wp rewrite flush --url=id.docker.local:8000 && \
	\
	docker-compose exec mariadb mysql -uroot -ppassword -e "create database wordpress_test;" && \
	docker-compose exec mariadb mysql -uroot -ppassword -e "GRANT ALL PRIVILEGES ON wordpress_test.* TO 'wordpress'@'%';" && \
	\
	docker-compose exec test_php wp core multisite-install --url="http://test.id.docker.local:8000/" --title="Testing site" --admin_user="admin" --admin_password="admin" --admin_email="admin@docker.local" --skip-email --skip-config && \
	docker-compose exec test_php wp plugin activate hh-sortable --network && \
	docker-compose exec test_php wp rewrite flush --url=test.id.docker.local:8000

### Regular commands
dev-env--start:
	cd ./custom/dev-env && make start

dev-env--stop:
	cd ./custom/dev-env && make stop

dev-env--prune:
	cd ./custom/dev-env && make prune

dev-env--restart:
	cd ./custom/dev-env && make stop
	cd ./custom/dev-env && make start

dev-env--recreate:
	make dev-env--prune && make dev-env--up

dev-env--shell:
	cd ./custom/dev-env && make shell
