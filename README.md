## 💻 How to Run Locally

1. **Clone the repository:**
   ```bash
   git clone <>
   ```
2. **Install Composer dependencies:**
   ```bash
   composer install
   ```
3. **Create and configure `.env` file:**
   ```bash
   cp .env.example .env
   ```
   *(Configure your database settings inside the `.env` file)*
4. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```
5. **Run Migrations & Seeders:**
   ```bash
   php artisan migrate
   ```
6. **Start the local server:**
   ```bash
   php artisan serve
   ```

## 💻 Others packed with Laravel
7. **Sanctum installation:**
   * **Laravel 10 or down:**
     ```bash
     composer require laravel/sanctum
     ```
   * **Laravel 11 or up:**     
    ```bash
    php artisan install:api
    ```