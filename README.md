# Tic-Tac-Toe Game with Leaderboard

## Setup Instructions

[requirements]:

- PHP 8.1
- Composer
- Node.js
- NPM

### 1. Clone the Repository

```bash
git clone <repository-url>
cd <project-directory>
```

### 2. Install the Required Packages

```bash
composer install
npm install
```

### 3. Create a copy of the `.env` file from the `.env.example` file

```bash
cp .env.example .env
```

### 4. Generate a new application key

```bash
php artisan key:generate
```
### 5. Run the migrations

```bash
php artisan migrate
```
### 6. Start the backend server:

```bash
php artisan serve
```
### 7. Start the frontend server:

```bash
npm run dev
```

