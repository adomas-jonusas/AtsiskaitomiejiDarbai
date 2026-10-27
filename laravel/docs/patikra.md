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

Antras nepriklausomas paleidimas iš naujo GitHub klono bus užfiksuotas po šios patikros.
