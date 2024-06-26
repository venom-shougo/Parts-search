# Parts-search
会社の物品管理アプリ 開発途中(現在中止)

# 開発理由
会社で消耗品、部品を購入する手順
①ファイリングされた書類から見つけ出し業者に見積もりを取り注文する。
　　　問題：大量のファイルから大量の書類の中から目当ての書類を見つけ出すのに時間がかかる。
②カタログから探し見積もりを取り注文する。
　　　カタログでは似たような物も複数あり似た物を間違って注文するミスもある。
③業者に来てもらい現物確認し見積もりを取り注文する。
　　　業者に来てもらうも時間がかかる、２、３日後とか。
   
これらの問題により社内で使う物だけを管理するアプリを作れば発注間違いや探し出す時間短縮になる。
何より注文が面倒だから他の従業員が自分に頼んでくる事が減り、自分の業務を圧迫しない。

# 機能
・新規登録機能、ログイン機能
・部品詳細登録機能
・管理者ログインで部品詳細変更機能
・管理者ログインで部品削除機能
・部品検索機能、部品の写真から（使用機械から検索は実装中）
・ユーザログイン者、部品購入手続き機能
・会社フォーマット購入用紙Excelに購入時の詳細を出力
・ユーザ毎に購入履歴表示（詳細検索機能）
・購入履歴から購入手続き可能

# 使用方法
docker-compose up -d でコンテナビルド、コンテナ起動

MySqlのログインは環境変数で見えないようにしているのでconfig.phpの定数に直接設定を書き起動する必要がある
