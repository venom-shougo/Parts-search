# リストア手順
# 1. git pull 後 docker-compose up -d 
# 2. docker stop parts_search_app-main_db_1 でDBコンテナストップ
# 3. /sqlディレクトリに backup.tar.gz がある事を確認
# 4. /sqlで以下のコマンドをターミナルで実行
docker run --rm -v parts_search_app-main_db-data:dest -v "$PWD":/src busybox tar xzf /src/backup.tar.gz -C /dest

# 5. ボリュームにデータがあるか確認、MySQLにログイン
docker compose exec db bash -c 'mysql -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE'

# 6. コマンドでデータ確認
SELECT * FROM users;
SELECT * FROM parts;
SELECT * FROM images;
SELECT * FROM order_history;

# docker内のボリュームを見るコマンド
docker volume ls