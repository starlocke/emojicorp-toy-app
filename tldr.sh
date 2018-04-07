#!/bin/bash

echo "-> Build the PHP image"
docker-compose build

echo "-> Launch the containers (db, php)"
docker-compose up -d

echo "-> Sleeping 15, waiting for DB to be ready"
sleep 10

echo "-> Sleeping 5, waiting for DB to be ready"
sleep 5

./test.sh
