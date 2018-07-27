#!/usr/bin/env bash

docker pull phpunit/phpunit

sudo sh -c "printf \"#!/bin/sh
 export PATH=/sbin:/bin:/usr/sbin:/usr/bin:/usr/local/sbin:/usr/local/bin
 docker run -v $(pwd):/app --rm phpunit/phpunit run \\\$@
 \" > /usr/local/bin/phpunit"
sudo chmod +x /usr/local/bin/phpunit

docker-compose up -d


