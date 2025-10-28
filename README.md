# プロジェクト名　
実践学習ターム 模擬案件初級_フリマアプリ
# <h2>概要</h2>
このアプリは、ユーザーが商品を出品・購入できるフリマアプリです。  
Laravelを用いて認証機能、商品管理機能、購入機能を実装しています。
# <h2>機能一覧</h2>
- ユーザー登録・ログイン機能
- 商品出品・編集・削除機能
- 商品購入機能
- カテゴリ検索機能
- 商品画像アップロード機能
# <h2> 使用技術 </h2>
PHP 8.1.33
Laravel Framework 8.83.29
Composer 2.8.11
MySQL (MariaDB 10.8.3)
JavaScript
Docker / Docker Compose
# <h2> 環境構築手順 </h2>
1.コンテナ起動（ビルド）
docker compose up -d --build
2.依存関係インストール（PHP / Node）
docker compose exec php composer install
docker compose exec php php -v
docker compose exec php npm install
docker compose exec php npm run build 
3..env 作成 & アプリキー発行
cp src/.env.example src/.env
docker compose exec php php artisan key:generate
4.ストレージリンク & マイグレーション
docker compose exec php php artisan storage:link
docker compose exec php php artisan migrate
