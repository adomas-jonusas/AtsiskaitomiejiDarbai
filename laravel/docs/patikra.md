# Projekto patikra

Data: 2026-10-27.

## Pirmas patikrinimas

- Perskaitytos visų 13 oficialaus kurso pamokų tekstinės dalys ir kodo pavyzdžiai. Pakeitimai atlikti jų eilės tvarka, įskaitant laikiną anoniminį CRUD prieš autentifikacijos pamokas.
- 4 pamoka pakeista pagal mokytojo nurodymą: vietinis paleidimas, README ir GitHub kodas, be Laravel Cloud ar viešo programos diegimo.
- `php artisan route:list`: maršrutai užregistruoti, apsaugotiems veiksmams priskirtas `auth` middleware.
- `php artisan migrate:status`: visos 4 migracijos įvykdytos.
- `php artisan test`: 35 testai, 149 patikrinimai, visi sėkmingi.
- `npm run build` ir Laravel Pint patikra sėkmingi. `composer validate`, `composer audit` ir npm priklausomybių patikra klaidų nerado.
- Vietiniame HTTP serveryje atskirai patikrintos registracijos, prisijungimo, atsijungimo, kūrimo, redagavimo ir trynimo užklausos su tikrais sesijos slapukais. Be CSRF žetono gaunamas 419 atsakymas, svetimų žinučių veiksmams – 403. Tuščios ir per ilgos žinutės atmetamos.
- Naršyklėje atlikta registracija, žinutės sukūrimas ir redagavimas. Patikrintas pavadinimas, autorius, spalvos ir 390 px pločio puslapis su porašte. Automatizavimo įrankis sustojo ties JavaScript trynimo patvirtinimo langu; trynimas, prisijungimas ir atsijungimas pilnai patikrinti HTTP užklausomis ir Laravel testais.
- `git check-ignore` patvirtina `.env`, vietinės duomenų bazės, priklausomybių, logų ir surinktų resursų ignoravimą. Šių failų Git indekse nėra.

## Antras patikrinimas iš švaraus GitHub klono

Saugykla iš naujo klonuota į atskirą laikiną katalogą. Tikrinta `ee7075c` versija iš GitHub, joje buvo 26 šio darbo commit'ai, po 2 kiekvienai iš 13 pamokų.

Be jau įdiegtų projekto priklausomybių, `.env` ar SQLite failo įvykdyta README nurodyta seka: `composer install`, `npm install`, `.env.example` kopijavimas, rakto generavimas, SQLite failo sukūrimas, migracijos, `npm run build` ir serverio paleidimas. Antram serveriui parinktas vietinis 8001 prievadas.

Rezultatai:

- Visos 4 migracijos įvykdytos. Atskirai išbandytas `chirps` migracijos atšaukimas ir pakartotinis pritaikymas.
- `php artisan test`: 35 testai, 149 patikrinimai, visi sėkmingi. Pint ir resursų surinkimas taip pat sėkmingi.
- Atskirai per tikrą HTTP serverį dar kartą atlikti registracijos, prisijungimo, atsijungimo ir viso CRUD scenarijai. Patikrinta CSRF apsauga, svečių nukreipimas į prisijungimą, kito vartotojo 403 atsakymai ir žinutės validacija.
- Patikrintas tikras GitHub failų medis: 87 Laravel šaltinio ir dokumentacijos failai; `.env`, SQLite, `vendor`, `node_modules`, logų ir privačių raktų nėra.
- Visų 26 pamokų commit'ų pakeitimai netušti ir liečia tik `laravel/`. Ankstesnių mokyklinių darbų Git medžiai sutampa su pradine `bbaf2a3` versija.
- Švaraus klono šaltiniai po diegimo ir testavimo nepakito. Ignoravimo taisyklės veikia ir jame.

## Vertinimas pagal užduoties kriterijus

| Kriterijus | Maksimumas | Patikrinta |
|---|---:|---|
| Oficialus Laravel kursas | 5 | 13 pamokų, veikiantis CRUD, duomenų bazė ir autentifikacija |
| Individualūs pakeitimai | 2 | Pavadinimas, vardas, klasė, Blade poraštė ir mėlynas dizainas |
| Git ir GitHub | 2 | Bent 26 nuoseklūs commit'ai, esama saugykla, teisingas katalogas, privatūs failai ignoruojami |
| Struktūra ir README | 1 | Laravel struktūra ir praktiškai pakartota Windows paleidimo instrukcija |
| Iš viso | 10 | Visi išvardyti kriterijai patikrinti; galutinį pažymį skiria mokytojas |
