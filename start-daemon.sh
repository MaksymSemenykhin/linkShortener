#!/bin/bash
source output.sh

bash ./stop.sh

print_title "Building conteiners"
docker-compose build &&

print_title "Starting conteiners"
docker-compose up -d
