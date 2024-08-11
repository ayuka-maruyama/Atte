# Atte（アット）
企業の勤怠管理システム  
![スクリーンショット 2024-06-19 141636](https://github.com/ayuka-maruyama/Atte/assets/155651611/86686fdd-fbbe-4d98-8105-684f6dc3ba17)  
  

## 作成した目的
勤怠管理システムを利用して人事評価を行うため  
  

## アプリケーションURL  
http://13.230.4.95/  
  

## 機能一覧
*会員登録機能 
*ログイン機能  
*ログアウト機能  
*勤務開始機能  
*勤務終了機能  
*休憩開始機能  
*休憩終了機能  
*日付別勤怠情報取得機能  
*ページネーション機能  
*メール認証機能  
*ユーザーページ    
  

## 使用技術（実行環境）  
Laravel Framework 8.83.8  
  

## テーブル設計  
![スクリーンショット 2024-06-19 150716](https://github.com/ayuka-maruyama/Atte/assets/155651611/47818cae-9358-496e-9bd1-a84d13ed342c)  
  

## ER図  
![スクリーンショット 2024-06-19 151201](https://github.com/ayuka-maruyama/Atte/assets/155651611/e8ab0c04-b5da-4e92-9fd6-e735de944f66)
  

# 環境構築  
**Dockerビルド**
1.`git clone https://github.com/ayuka-maruyama/Atte.git`  
2.Docker Desktopアプリを立ち上げる  
3.`docker-compose up -d --build`  
  
**Laravel環境構築**  
1.`docker-compose exec php bash`でPHPコンテナへログイン  
2.`composer install`  
3.「.env.example」ファイルを「.env」ファイルに命名を変更。新しく.envファイルを作成  
4.「.env」に以下の環境変数を追加  
```text
DB_CONNECTION=mysql
DB_HOST=mysql  
DB_PORT=3306  
DB_DATABASE=laravel_db  
DB_USERNAME=laravel_user  
DB_PASSWORD=laravel_pass

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=info@example.com

```
5.アプリケーションキーの作成  
``` bash
php artisan key:generate
```

6.マイグレーションの実行  
``` bash
php artisan migrate
```
  
7.シーディングの実行  
``` bash
php artisan db:seed
```  
  
  
## その他
テストユーザー  
メールアドレス test@example.com  
パスワード password  
