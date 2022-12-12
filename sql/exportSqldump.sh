#!/bin/bash

# バックアップをとる

docker run --rm -v parts_search_app-main_db-data:/src -v "$PWD":/dest busybox tar czf /dest/backup.tar.gz -C /src .

# docker compose exec db bash -c 'mysqldump --no-tablespaces -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE > //dump.sql'
# docker compose cp db:/tmp/dump.sql sql/export/dump.sql


