# Rebuild your local dev db from the migrations
refresh-db:
	bin/console do:da:dr --force --if-exists && bin/console do:da:cr && bin/console do:mi:mi -n

refresh-integration-db:
	bin/console --env=integration do:da:dr --force --if-exists
	bin/console --env=integration do:da:cr
	bin/console --env=integration do:mi:mi -n

# Stop the http service
http-stop:
	symfony server:stop

# Start the http service
http-start:
	symfony server:start --port=9000 -d

# Restart the http service
http-restart:
	make http-stop
	make http-start

# Completely nuke all running containers, images and volumes.
dev-down:
	make http-stop
	./docker-down.sh

# Bring up our dev environment
dev-up:
	make dev-down
	make http-restart
	docker-compose -f ./docker-compose.db.yml up -d
	# We need to sleep for 15 seconds to give the docker container a chance to fully boot
	sleep 15
	make refresh-db

# Run quality tools - static analysers, unit tests, integration tests etc
quality:
	vendor/bin/phpstan analyze --level=max ./src
	vendor/bin/phpcs --standard=./phpcs.xml ./src/ -p --colors
	vendor/bin/phpunit tests
	make refresh-integration-db
	vendor/bin/behat --suite=StudentAttendanceRecord

# Run PHPCS fixers to correct common issues.
quality-fix:
	./vendor/bin/phpcbf --standard=./phpcs.xml ./src/ -p --colors

test-coverage:
	phpdbg -qrr -dmemory_limit=-1 ./vendor/bin/phpunit --coverage-php coverage/phpunit.php \
		&& make refresh-integration-db \
		&& phpdbg -qrr -dmemory_limit=-1 ./vendor/bin/behat \
		&& cd coverage \
		&& php combine.php integration.php phpunit.php \
		&& cd ../

phpdocs:
	phpdocs -d ./src -t docs/api

# Fire a total of 10 requests, 10 times
load-test-low:
	make refresh-db
	./load-test.sh -c 10 -r 10 \
    	-a http://localhost:9000/api/student/attendance/record \
        -X POST \
        -H "api-key: does-not-matter" \
        -H "Content-Type: application/json" \
        -d '{"matriculationNumber":"load-test","attended":true}'

# Fire a total of 100 requests, 10 times
load-test-medium:
	make refresh-db
	./load-test.sh -c 10 -r 100 \
    	-a http://localhost:9000/api/student/attendance/record \
        -X POST \
        -H "api-key: does-not-matter" \
        -H "Content-Type: application/json" \
        -d '{"matriculationNumber":"load-test","attended":true}'

# Fire a total of 100 requests, 100 times
load-test-high:
	make refresh-db
	./load-test.sh -c 100 -r 100 \
    	-a http://localhost:9000/api/student/attendance/record \
        -X POST \
        -H "api-key: does-not-matter" \
        -H "Content-Type: application/json" \
        -d '{"matriculationNumber":"load-test","attended":true}'