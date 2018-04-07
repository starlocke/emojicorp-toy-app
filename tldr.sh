#!/bin/bash

echo "-> Build the PHP image"
docker-compose build

echo "-> Launch the containers (db, php)"
docker-compose up -d

echo "-> Sleeping 45, waiting for DB to be ready"
sleep 15

echo "-> Sleeping 30, waiting for DB to be ready"
sleep 15

echo "-> Sleeping 15, waiting for DB to be ready"
sleep 15

echo "-> Initialize (wipe, reset) the database schema"
docker-compose exec db /schema/reset.sh

echo "-> If you saw 'Can't connect to MySQL server' above, then run this after waiting more:"
echo "docker-compose exec db /schema/reset.sh"

echo "-> You should now be good to browse http://localhost:8816"
