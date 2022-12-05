# Docker compose上のMySQLからデータバックアップする方法とバックアップしたSQLDUMPファイルからデータベース情報とデータをインポートする方法
## Docker compose上のMySQLからデータバックアップする方法

※docker composeを起動しておいてください。

```
// docker composeを起動する
docker-compose up -d
```

バックアップを取るためのシェルスクリプトを実行します。  

```
// シェルスクリプトがあるディレクトリに移動する
cd sql

// SQLDUMPファイルをエクスポートするシェルスクリプトを実行
./exportSqldump.sh 
```

`/sql/export`ディレクトリにSQLDUMPファイルが作られます。

## Docker compose上のMySQLにバックアップしたSQLDUMPファイルからデータベース情報とデータをインポートする方法

※docker composeを起動しておいてください。

```
// docker composeを起動する
docker-compose up -d
```

SQLDUMPファイルをインポートするシェルスクリプトを実行します。

```
// シェルスクリプトがあるディレクトリに移動する
cd sql

// SQLDUMPファイルからデータベース情報とデータをインポートするシェルスクリプトを実行
./importSqldump.sh
```

インポートしたら

## 参考
[Docker Compose データベースのバックアップとリストア方法](https://qiita.com/ucan-lab/items/5fb4d53e180dc8c6b22f)