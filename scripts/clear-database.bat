@ECHO OFF

set $SOURCE=%~dp0

php %$SOURCE%/../app/console doctrine:cache:clear-metadata && php %$SOURCE%/../app/console doctrine:cache:clear-query && php %$SOURCE%/../app/console doctrine:cache:clear-result
php %$SOURCE%/../app/console doctrine:database:drop --env=dev --force && php %$SOURCE%/../app/console doctrine:database:create && php %$SOURCE%/../app/console doctrine:schema:update --force
php %$SOURCE%/../app/console doctrine:fixture:load