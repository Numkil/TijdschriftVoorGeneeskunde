#!/bin/sh

if [ "$(id -u)" != "0" ]; then
  echo "Please run as root"
  exit
fi

# MAC SUPPORT
if [ $SUDO_USER ]; then
    user=$SUDO_USER;
else
    user=`whoami`;
fi
if [ `uname` = "Darwin" ]; then
    if [ `which brew` ]; then
        if [ ! `which greadlink` ]; then
            su $SUDO_USER -c 'brew install coreutils'
            echo "utils"
        fi

        alias readlink=greadlink
    else
        echo "Homebrew is necessary to install greadlink"
        exit
    fi
fi

SOURCE=$(dirname $(readlink -f $0))

php ${SOURCE}/../app/console doctrine:cache:clear-metadata && php ${SOURCE}/../app/console doctrine:cache:clear-query && php ${SOURCE}/../app/console doctrine:cache:clear-result
php ${SOURCE}/../app/console doctrine:database:drop --force && php ${SOURCE}/../app/console doctrine:database:create && php ${SOURCE}/../app/console doctrine:schema:update --force
php ${SOURCE}/../app/console doctrine:fixture:load