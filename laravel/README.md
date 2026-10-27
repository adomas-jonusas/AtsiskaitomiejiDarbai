# Chirper – Adomas Jonušas

Autorius: Adomas Jonušas

Klasė: 3PHP-1

Mokomasis trumpos žinutės programos projektas pagal [oficialų Laravel kursą](https://laravel.com/learn/getting-started-with-laravel).
Vartotojai galės registruotis, prisijungti ir skelbti iki 255 simbolių žinutes. Savo žinutes bus galima redaguoti ir ištrinti.

Naudosiu Laravel 12, PHP, Blade, SQLite ir Tailwind CSS. Programą paleisiu vietiniame kompiuteryje, o kodą saugosiu [esamoje GitHub saugykloje](https://github.com/adomas-jonusas/AtsiskaitomiejiDarbai/tree/main/laravel).

## Paleidimas Windows kompiuteryje

Reikia PHP 8.4 arba naujesnio (su `pdo_sqlite`, `sqlite3`, `mbstring`, `openssl`, `fileinfo`, `xml`, `curl` ir `zip` plėtiniais), Composer 2, Node.js 22 ar naujesnio ir Git. PHP bei Composer galima įdiegti pagal [Laravel instrukciją](https://laravel.com/docs/12.x/installation). Patikrinta su PHP 8.4 ir Node.js 24.

PowerShell lange:

```powershell
git clone https://github.com/adomas-jonusas/AtsiskaitomiejiDarbai.git
cd AtsiskaitomiejiDarbai\laravel
composer install
npm install
Copy-Item .env.example .env
php artisan key:generate
New-Item -ItemType File -Path database\database.sqlite -Force
php artisan migrate
npm run build
php artisan serve
```

Atidaryk [http://127.0.0.1:8000](http://127.0.0.1:8000). Serveris sustabdomas `Ctrl+C`. SQLite lentelės sukuriamos migracijomis; atskiro duomenų bazės serverio nereikia. `.env.example` jau parinktas `DB_CONNECTION=sqlite`.

Pakartotinai paleidžiant užtenka `php artisan serve`. Nekopijuok `.env` ir nekurk duomenų bazės iš naujo, jeigu nori išsaugoti vietinius duomenis. Keičiant CSS, pakartok `npm run build`, arba kūrimo metu naudok `composer run dev`.

## Patikra

```powershell
php artisan route:list
php artisan migrate:status
php artisan test
npm run build
```

Pagal mokytojo reikalavimą 4 pamokoje paruoštas vietinis paleidimas ir kodo saugojimas GitHub. Programa viešame serveryje nediegiama. `.env`, SQLite failas, priklausomybių katalogai ir surinkti resursai neįtraukiami į Git.
