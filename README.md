# Task DIGILAND

Features :
- Laravel : 11v
- ThirdParty : Laravel Scout
- Driver : MeiliSearch
- Services : Blog Post
- Auth : JWT-AUTH ( Tymon )

Up & Running : 

- Copy .env.example To .env
- Docker Compose up -d
- docker exec : php artisan migrate:fresh --seed   OR    import Dump in SQL Folder To Database
- docker exec : php artisan scout:sync-index-settings
- docker exec : php artisan scout:index posts
