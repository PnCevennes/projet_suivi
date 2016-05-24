#!/bin/bash
DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
echo $DIR
cd $DIR

cp app/config/parameters.yml.dist app/config/parameters.yml
echo "run composer install"
curl -s https://getcomposer.org/installer | php
php composer.phar update
php composer.phar install


echo "Configuration des droits des répertoires de l'application..."
chmod -R 777 app/logs app/cache
php app/console cache:clear --env=prod
chmod -R 777 app/logs app/cache


