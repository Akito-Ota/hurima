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
- 取引後のチャット機能
- ユーザー同士の評価機能
- メール送信機能

##  使用技術 
- PHP 8.1.33
- Laravel Framework 8.83.29
- Composer 2.8.11
- MySQL (MariaDB 10.8.3)
- JavaScript
- Docker Engine : 28.1.1
- Docker Compose : 2.36.0
- Mailtrap
- window.Alpine

## 開発環境構築

### 1. 必要環境
本アプリを動作させるには、以下のツールがインストールされている必要があります
git clone https://github.com/Akito-Ota/hurima.git
cd hurima

### 2. リポジトリのクローン

bash
- git clone https://github.com/Akito-Ota/hurima.git
- cd hurima

### 3. 環境変数ファイル（.env）の作成
.env.example をコピーして .env を作成します。
cp .env.example .env
その後、データベース接続情報を以下のように編集してください
- DB_CONNECTION=mysql
- DB_HOST=mysql
- DB_PORT=3306
- DB_DATABASE=laravel_db
- DB_USERNAME=laravel_user
- DB_PASSWORD=laravel_pass

### 4.Docker コンテナの起動

docker compose up -d --build

### 5.Laravel の初期設定

- docker compose exec php composer install
- docker compose exec php php artisan key:generate
- docker compose exec php php artisan migrate --seed
- docker compose exec php chmod -R 777 storage bootstrap/cache


## Seeding（開発用データ）
本アプリでは、画面動作確認を行うために
以下の条件でユーザーデータをシーディングしています。
また、商品ID１〜５はuserA商品ID６〜１０はuserBに付随しています

### ユーザーデータの内容
- ユーザー名
- メールアドレス
- 発送先となる住所及び郵便番号
- 出品情報
### 実行方法
以下のコマンドで、データベースを初期化し、
テスト用ユーザーおよび商品データを投入できます。

php artisan migrate:fresh --seed

### テスト用ユーザーアカウント(A~C)
- ログイン画面URL：（http://localhost/login）
- ユーザー名：userA
- メールアドレス:userA@example.com
- パスワード：password
- ユーザー名：userB
- メールアドレス:userB@example.com
- パスワード：password
- ユーザー名：userC
- メールアドレス:userC@example.com
- パスワード：password

## メール設定(Mailtrap)
本プロジェクトでは、開発環境でのメール送信テストに [Mailtrap]((https://mailtrap.io)) を使用しています。

### アカウント作成と認証情報の取得
1. Mailtrap にログインし、`Email Testing` > `Inboxes` を開きます。
2. `My Inbox` をクリックし、`SMTP Settings` の `Integrations` から **Laravel 9+** を選択します。
3. 表示される認証情報（Username, Password 等）を確認します。

### .env の編集
プロジェクト直下の `.env` ファイルに、取得した内容を反映させてください。

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=（取得したユーザー名）
MAIL_PASSWORD=（取得したパスワード）
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="no-reply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```
## ER図及びMailtrapのスクリーンショット

docs/er.pngにても表示してあります
<img width="1123" height="1031" alt="Untitled (5)" src="https://github.com/user-attachments/assets/f85ffeb1-f240-44c6-9e6c-a8a210577fca" />

## <img width="1366" height="918" alt="スクリーンショット 2026-01-11 23 33 11" src="https://github.com/user-attachments/assets/0b8f29cf-0cfc-4fd1-9331-ad621d774b19" />


