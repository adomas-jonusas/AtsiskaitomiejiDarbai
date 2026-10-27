# Trumpai apie mano Chirper

| Sąvoka | Paprastas paaiškinimas | Ką parodyti projekte |
|---|---|---|
| Laravel | PHP karkasas, kuris duoda programos struktūrą ir paruoštus įrankius. | `composer.json`, `bootstrap/app.php` |
| Route | Susieja adresą ir HTTP metodą su veiksmu. | `routes/web.php` |
| Controller | Priima užklausą, patikrina duomenis ir grąžina atsakymą. | `app/Http/Controllers/ChirpController.php` |
| Model | Leidžia dirbti su duomenų bazės įrašais kaip su PHP objektais. | `app/Models/Chirp.php` |
| Migration | PHP faile aprašyta lentelės struktūra, kurią sukuria `php artisan migrate`. | `database/migrations/2026_10_27_174145_create_chirps_table.php` |
| Blade | HTML šablonai su PHP duomenimis, ciklais ir komponentais. | `resources/views/home.blade.php`, `resources/views/components/footer.blade.php` |
| CRUD | Sukurti, perskaityti, atnaujinti ir ištrinti duomenis. | `app/Http/Controllers/ChirpController.php` |

Atidarius `/`, maršrutas iškviečia `ChirpController::index`. Valdiklis per `Chirp` modelį paima žinutes ir perduoda jas `home.blade.php`. Blade kiekvieną žinutę parodo per `x-chirp` komponentą.

Registracijos valdiklis `app/Http/Controllers/Auth/Register.php` patikrina formą, išsaugo slaptažodžio maišą ir prijungia vartotoją. Prisijungimui naudojamas `Auth/Login.php`, atsijungimui – `Auth/Logout.php`. Sesija leidžia prisiminti prisijungusį vartotoją tarp užklausų.

`auth` middleware saugo kūrimo, redagavimo ir trynimo adresus. `app/Policies/ChirpPolicy.php` tikrina, ar žinutė priklauso prisijungusiam vartotojui. Vien paslėpti mygtuką neužtektų, todėl leidimas tikrinamas ir valdiklyje.

Formose `@csrf` sukuria apsaugos žetoną. `@method('PUT')` ir `@method('DELETE')` leidžia paprastomis HTML formomis siųsti atnaujinimo ir trynimo užklausas. Žinutės tekstas tikrinamas serveryje ir turi būti nuo 1 iki 255 simbolių.

Poraštė yra `x-footer` komponentas bendrame `x-layout`. Vardas ir klasė į HTML įrašomi serveryje iš `config/chirper.php`.

Toliau būtų galima pridėti paiešką arba srauto puslapiavimą. Šiame atsiskaityme paliktas paprastas kurso funkcionalumas. Naujos žinutės matomos atnaujinus puslapį.
