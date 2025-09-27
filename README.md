# お問い合わせフォーム

## 環境構築
- Dockerのビルドからマイグレーション、シーディングまでを記述する

docker compose up -d --build
docker compose exec php bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed

## 使用技術(実行環境)
- 例) Laravel 8.x(言語やフレームワーク、バージョンなどが記載されていると良い)
  
PHP 8.x
Laravel 8.*
MySQL 8.0.26

## ER図
< - - - 作成したER図の画像 - - - >
<img width="531" height="411" alt="image" src="https://github.com/user-attachments/assets/406f83a8-75ce-46c6-a270-6ac06cc11069" />


## URL
開発環境：http://localhost/
/ … お問い合わせフォーム入力ページ
/confirm … 確認ページ
/thanks … サンクスページ
/login … ログインページ
/register … 登録ページ
/admin … 管理画面
