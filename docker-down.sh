#!/bin/bash
docker kill $(docker ps -q) -f >> /dev/null 2>&1
docker rm $(docker ps -a -q) -f >> /dev/null 2>&1
docker rmi $(docker images -q) -f >> /dev/null 2>&1
docker volume prune -f >> /dev/null 2>&1