#!/bin/bash
source output.sh

print_title "Stopping conteiners"
docker-compose stop

print_title "Removving conteiners"
docker-compose rm -f

print_title "Pruning conteiners"
docker system prune -f
