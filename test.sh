#!/bin/bash

echo "-> Launch the containers (db, php)"
docker-compose up -d

echo "-> Initialize (wipe, reset) the database schema"
docker-compose exec db /schema/reset.sh
