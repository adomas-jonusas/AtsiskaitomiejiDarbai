# FILMUKAI – duomenų bazė

Duomenų bazės užduotis pagal pateiktą `data.xlsx` failą. Sudaryta schema, 10 tarpusavyje susietų lentelių ir 22 SQL užklausos.

## Failai

- **Importas.sql** – lentelės, ryšiai ir duomenys. Importavus sukuriamas ir filmų įvertinimų vidurkių rodinys.
- **Užklausos.sql** – visos 22 užduoties užklausos, sunumeruotos nuo 1 iki 22.
- **Schema.svg** – duomenų bazės diagrama.
- **Schema.mmd** – tos pačios diagramos Mermaid aprašymas.
- **Rezultatai.md** – užklausų atsakymai pagal pateiktus duomenis.

## Kaip paleisti

1. Atidaryk **phpMyAdmin** ir susikurk tuščią duomenų bazę, pvz., `filmukai`.
2. Pasirink šią bazę, eik į **Importuoti** ir įkelk `Importas.sql`.
3. Kai importas baigsis, turi būti **10 lentelių** ir rodinys `filmu_vidurkiai`.
4. Atidaryk **SQL** ir vykdyk užklausas iš `Užklausos.sql` (atskirais numeruotais blokais).

Duomenų patikrai: `filmai` lentelėje yra **28 filmai**, o `ivertinimai` – **36 įvertinimai**.

**Pastaba.** Užduoties pradiniai duomenys palikti tokie, kokie pateikti „Excel“ faile. Jei ten aktorius, filmas ar personažas neatitinka tikrovės, SQL atsakymas vis tiek remiasi pateiktais duomenimis.

## Duomenų bazės ryšiai

```mermaid
erDiagram
    kalbos o|--o{ filmai : kalba
    valstybes o|--o{ filmai : valstybe
    filmai ||--o{ filmu_rezisieriai : turi
    asmenys ||--o{ filmu_rezisieriai : rezisuoja
    filmai ||--o{ vaidmenys : turi
    asmenys ||--o{ vaidmenys : vaidina
    filmai ||--o{ filmu_zanrai : priskirtas
    zanrai ||--o{ filmu_zanrai : apibudina
    filmai ||--o{ ivertinimai : gauna
    kritikai ||--o{ ivertinimai : vertina
    kalbos {
        int kalba_id PK
        varchar pavadinimas UK
    }
    valstybes {
        int valstybe_id PK
        varchar kodas UK
    }
    filmai {
        int filmas_id PK
        varchar pavadinimas
        smallint metai
        smallint trukme_min
        int kalba_id FK "NULL leidziamas"
        date premjera "NULL leidziamas"
        int valstybe_id FK "NULL leidziamas"
    }
    asmenys {
        int asmuo_id PK
        varchar vardas_pavarde
        char lytis "NULL leidziamas"
    }
    filmu_rezisieriai {
        int filmas_id PK,FK
        int asmuo_id PK,FK
    }
    vaidmenys {
        int filmas_id PK,FK
        int asmuo_id PK,FK
        varchar personazas PK
    }
    zanrai {
        int zanras_id PK
        varchar pavadinimas UK
    }
    filmu_zanrai {
        int filmas_id PK,FK
        int zanras_id PK,FK
    }
    kritikai {
        int kritikas_id PK
        varchar vardas "NULL leidziamas"
        varchar pavarde "NULL leidziamas"
        boolean anoniminis
    }
    ivertinimai {
        int filmas_id PK,FK
        int kritikas_id PK,FK
        decimal zvaigzdutes "0 iki 10"
    }
```
