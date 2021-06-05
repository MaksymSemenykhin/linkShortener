#!/bin/bash
source output.sh

bash ./stop.sh

#print_title "Stopping conteiners"
#docker-compose stop
#
#print_title "Removving conteiners"
#docker-compose rm -f
#
#print_title "Pruning conteiners"
#docker system prune -f

#print_title "Save worlds"
#bash backupWorlds.sh

print_title "Building conteiners"
docker-compose build &&

print_title "Starting conteiners"
docker-compose up -d
