-- FILMUKAI: 22 užduoties užklausos. Pirma importuokite Importas.sql.
-- phpMyAdmin pasirinkite importo duomenų bazę ir SQL kortelėje vykdykite
-- norimą numeruotą bloką. Visos užklausos yra tik skaitymo.

-- 01. Visi „Vertigo“ aktoriai ir jų personažai.
SELECT a.vardas_pavarde AS aktorius, v.personazas
FROM filmai f
JOIN vaidmenys v ON v.filmas_id = f.filmas_id
JOIN asmenys a ON a.asmuo_id = v.asmuo_id
WHERE f.pavadinimas = 'Vertigo'
ORDER BY a.vardas_pavarde, v.personazas;

-- 02. Visi filmų „Eyes Wide Shut“ režisierių filmai (įskaitant patį filmą).
SELECT DISTINCT f.pavadinimas, f.metai
FROM filmai f
JOIN filmu_rezisieriai fr ON fr.filmas_id = f.filmas_id
WHERE fr.asmuo_id IN (
    SELECT fr2.asmuo_id
    FROM filmu_rezisieriai fr2
    JOIN filmai f2 ON f2.filmas_id = fr2.filmas_id
    WHERE f2.pavadinimas = 'Eyes Wide Shut'
)
ORDER BY f.pavadinimas;

-- 03. Ne UK sukurti filmai. Nežinoma valstybė nebūtų laikoma „ne UK“.
SELECT f.pavadinimas, f.metai, s.kodas AS valstybe
FROM filmai f
JOIN valstybes s ON s.valstybe_id = f.valstybe_id
WHERE s.kodas <> 'UK'
ORDER BY f.pavadinimas;

-- 04. „No name“ įvertinti filmai su režisieriais ir aktoriais.
-- Atskiros agregacijos nepadaugina aktorių dėl kelių režisierių.
SELECT f.pavadinimas, f.metai, f.premjera,
       (SELECT GROUP_CONCAT(a.vardas_pavarde ORDER BY a.vardas_pavarde SEPARATOR ', ')
        FROM filmu_rezisieriai fr JOIN asmenys a ON a.asmuo_id = fr.asmuo_id
        WHERE fr.filmas_id = f.filmas_id) AS rezisieriai,
       (SELECT GROUP_CONCAT(DISTINCT a.vardas_pavarde ORDER BY a.vardas_pavarde SEPARATOR ', ')
        FROM vaidmenys v JOIN asmenys a ON a.asmuo_id = v.asmuo_id
        WHERE v.filmas_id = f.filmas_id) AS aktoriai
FROM filmai f
WHERE EXISTS (
    SELECT 1 FROM ivertinimai i
    JOIN kritikai k ON k.kritikas_id = i.kritikas_id
    WHERE i.filmas_id = f.filmas_id AND k.anoniminis = 1
)
ORDER BY f.pavadinimas;

-- 05. Visi Woody Allen filmai: režisuoti ARBA tie, kuriuose jis vaidino.
SELECT f.pavadinimas, f.metai
FROM filmai f
WHERE EXISTS (
    SELECT 1 FROM filmu_rezisieriai fr
    JOIN asmenys a ON a.asmuo_id = fr.asmuo_id
    WHERE fr.filmas_id = f.filmas_id AND a.vardas_pavarde = 'Woody Allen'
) OR EXISTS (
    SELECT 1 FROM vaidmenys v
    JOIN asmenys a ON a.asmuo_id = v.asmuo_id
    WHERE v.filmas_id = f.filmas_id AND a.vardas_pavarde = 'Woody Allen'
)
ORDER BY f.pavadinimas;

-- 06. Geriausias Mystery filmas pagal kritikų vertinimų vidurkį.
-- Jei geriausi vidurkiai lygūs, grąžinami visi pirmą vietą užėmę filmai.
SELECT f.pavadinimas, ROUND(fv.vidurkis, 2) AS ivertinimas
FROM filmai f
JOIN filmu_vidurkiai fv ON fv.filmas_id = f.filmas_id
WHERE EXISTS (
    SELECT 1 FROM filmu_zanrai fz JOIN zanrai z ON z.zanras_id = fz.zanras_id
    WHERE fz.filmas_id = f.filmas_id AND z.pavadinimas = 'Mystery'
) AND fv.vidurkis = (
    SELECT MAX(fv2.vidurkis)
    FROM filmu_vidurkiai fv2
    WHERE EXISTS (
        SELECT 1 FROM filmu_zanrai fz2 JOIN zanrai z2 ON z2.zanras_id = fz2.zanras_id
        WHERE fz2.filmas_id = fv2.filmas_id AND z2.pavadinimas = 'Mystery'
    )
)
ORDER BY f.pavadinimas;

-- 07. Daugiau nei 2 skirtingus filmus įvertinę žinomi kritikai.
SELECT k.vardas, k.pavarde, COUNT(DISTINCT i.filmas_id) AS filmu_skaicius
FROM kritikai k
JOIN ivertinimai i ON i.kritikas_id = k.kritikas_id
WHERE k.anoniminis = 0
GROUP BY k.kritikas_id, k.vardas, k.pavarde
HAVING COUNT(DISTINCT i.filmas_id) > 2
ORDER BY k.pavarde, k.vardas;

-- 08. Metai, kai bent vienas filmas gavo bent vieną įvertinimą >= 5.
SELECT DISTINCT f.metai
FROM filmai f
JOIN ivertinimai i ON i.filmas_id = f.filmas_id
WHERE i.zvaigzdutes >= 5
ORDER BY f.metai ASC;

-- 09. Visi kritikų vertinimai, rikiuojami nurodyta laukų tvarka.
-- Anoniminis įrašas pateikiamas kaip „No name“, o jo pavardė lieka NULL.
SELECT f.pavadinimas, i.zvaigzdutes,
       CASE WHEN k.anoniminis = 1 THEN 'No name' ELSE k.vardas END AS vardas,
       k.pavarde
FROM ivertinimai i
JOIN filmai f ON f.filmas_id = i.filmas_id
JOIN kritikai k ON k.kritikas_id = i.kritikas_id
ORDER BY k.pavarde ASC, vardas ASC, i.zvaigzdutes ASC, f.pavadinimas ASC;

-- 10. Filmai, kuriuose tas pats žmogus buvo režisierius ir aktorius.
SELECT f.pavadinimas, a.vardas_pavarde AS rezisierius_ir_aktorius
FROM filmai f
JOIN filmu_rezisieriai fr ON fr.filmas_id = f.filmas_id
JOIN asmenys a ON a.asmuo_id = fr.asmuo_id
WHERE EXISTS (
    SELECT 1 FROM vaidmenys v
    WHERE v.filmas_id = f.filmas_id AND v.asmuo_id = fr.asmuo_id
)
ORDER BY f.pavadinimas, a.vardas_pavarde;

-- 11. „American Beauty“ kritikai ir jų įvertinimai.
SELECT CASE WHEN k.anoniminis = 1 THEN 'No name' ELSE k.vardas END AS vardas,
       k.pavarde, i.zvaigzdutes AS ivertinimas
FROM filmai f
JOIN ivertinimai i ON i.filmas_id = f.filmas_id
JOIN kritikai k ON k.kritikas_id = i.kritikas_id
WHERE f.pavadinimas = 'American Beauty'
ORDER BY k.pavarde, vardas;

-- 12. Visi duomenyse esantys pastatymo metai ir Mystery filmų skaičius.
-- Metai be šio žanro filmų gauna 0. Tarpiniai, duomenyse nesantys metai nepridedami.
SELECT f.metai, COUNT(DISTINCT CASE WHEN z.pavadinimas = 'Mystery'
                                  THEN f.filmas_id END) AS mystery_filmu_skaicius
FROM filmai f
LEFT JOIN filmu_zanrai fz ON fz.filmas_id = f.filmas_id
LEFT JOIN zanrai z ON z.zanras_id = fz.zanras_id
GROUP BY f.metai
ORDER BY f.metai;

-- 13. Tik vienas geriausias filmas pagal vidurkį; lygybę išsprendžia pavadinimas ir ID.
SELECT f.pavadinimas,
       (SELECT GROUP_CONCAT(a.vardas_pavarde ORDER BY a.vardas_pavarde SEPARATOR ', ')
        FROM filmu_rezisieriai fr JOIN asmenys a ON a.asmuo_id = fr.asmuo_id
        WHERE fr.filmas_id = f.filmas_id) AS rezisieriai,
       f.premjera, ROUND(fv.vidurkis, 2) AS vidutines_zvaigzdutes
FROM filmai f
JOIN filmu_vidurkiai fv ON fv.filmas_id = f.filmas_id
ORDER BY fv.vidurkis DESC, f.pavadinimas ASC, f.filmas_id ASC
LIMIT 1;

-- 14. Visų filmų vidurkiai didėjančia tvarka, po to pavadinimas didėjančia.
-- Neįvertinti filmai yra gale, su NULL (ne su 0).
SELECT f.pavadinimas, ROUND(fv.vidurkis, 2) AS vidutinis_ivertinimas
FROM filmai f
LEFT JOIN filmu_vidurkiai fv ON fv.filmas_id = f.filmas_id
ORDER BY (fv.vidurkis IS NULL), fv.vidurkis ASC, f.pavadinimas ASC;

-- 15. Filmai, kurių bent vienas aktorius vaidina ir kitame filme.
SELECT f.pavadinimas
FROM filmai f
WHERE EXISTS (
    SELECT 1 FROM vaidmenys v
    WHERE v.filmas_id = f.filmas_id AND EXISTS (
        SELECT 1 FROM vaidmenys v2
        WHERE v2.asmuo_id = v.asmuo_id AND v2.filmas_id <> v.filmas_id
    )
)
ORDER BY f.pavadinimas;

-- 16. Sean Maguire personažą turėjusio filmo režisierių filmai.
-- Naudojamas šaltinis: personažas priskirtas „Titanic“.
SELECT DISTINCT f.pavadinimas, f.metai
FROM filmai f
JOIN filmu_rezisieriai fr ON fr.filmas_id = f.filmas_id
WHERE fr.asmuo_id IN (
    SELECT fr2.asmuo_id
    FROM filmu_rezisieriai fr2
    JOIN vaidmenys v ON v.filmas_id = fr2.filmas_id
    WHERE v.personazas = 'Sean Maguire'
)
ORDER BY f.pavadinimas;

-- 17. Aktoriai, vaidinę filmuose <= 1990 m. IR >= 2000 m.
SELECT a.vardas_pavarde AS aktorius
FROM asmenys a
JOIN vaidmenys v ON v.asmuo_id = a.asmuo_id
JOIN filmai f ON f.filmas_id = v.filmas_id
GROUP BY a.asmuo_id, a.vardas_pavarde
HAVING MIN(f.metai) <= 1990 AND MAX(f.metai) >= 2000
ORDER BY a.vardas_pavarde;

-- 18. Režisieriaus filmų skaičius pagal žanrą; daugelio žanrų filmas skaičiuojamas kiekviename.
-- Filmas be žanro rodomas atskiroje „Nenurodyta“ eilutėje.
SELECT a.vardas_pavarde AS rezisierius,
       COALESCE(z.pavadinimas, 'Nenurodyta') AS zanras,
       COUNT(DISTINCT fr.filmas_id) AS filmu_skaicius
FROM filmu_rezisieriai fr
JOIN asmenys a ON a.asmuo_id = fr.asmuo_id
LEFT JOIN filmu_zanrai fz ON fz.filmas_id = fr.filmas_id
LEFT JOIN zanrai z ON z.zanras_id = fz.zanras_id
GROUP BY a.asmuo_id, a.vardas_pavarde, z.zanras_id, z.pavadinimas
ORDER BY a.vardas_pavarde, zanras;

-- 19. Kiekvieno žanro filmų vidutinė trukmė minutėmis.
SELECT z.pavadinimas AS zanras, ROUND(AVG(f.trukme_min), 2) AS vidutine_trukme_min
FROM zanrai z
JOIN filmu_zanrai fz ON fz.zanras_id = z.zanras_id
JOIN filmai f ON f.filmas_id = fz.filmas_id
GROUP BY z.zanras_id, z.pavadinimas
ORDER BY z.pavadinimas;

-- 20. Metų filmų vidurkių vidurkis. Kiekvienas įvertintas filmas turi vienodą svorį.
SELECT f.metai, ROUND(AVG(fv.vidurkis), 4) AS metu_ivertinimas,
       COUNT(*) AS ivertintu_filmu_skaicius
FROM filmai f
JOIN filmu_vidurkiai fv ON fv.filmas_id = f.filmas_id
GROUP BY f.metai
ORDER BY AVG(fv.vidurkis) ASC, f.metai ASC;

-- 21. Kiekvieno filmo didžiausias vertinimas ir jį pateikęs kritikas.
-- Lygių geriausių vertinimų atveju rodomi visi kritikai; neįvertintiems laukų reikšmė NULL.
SELECT f.pavadinimas,
       CASE WHEN k.anoniminis = 1 THEN 'No name' ELSE k.vardas END AS vardas,
       k.pavarde, i.zvaigzdutes AS geriausias_ivertinimas
FROM filmai f
LEFT JOIN ivertinimai i ON i.filmas_id = f.filmas_id
    AND i.zvaigzdutes = (SELECT MAX(i2.zvaigzdutes)
                        FROM ivertinimai i2 WHERE i2.filmas_id = f.filmas_id)
LEFT JOIN kritikai k ON k.kritikas_id = i.kritikas_id
ORDER BY f.pavadinimas, k.pavarde, vardas;

-- 22. Režisierių reitingas pagal jų filmų vidurkių vidurkį.
-- Įtraukiami bent vieną įvertintą filmą turintys režisieriai; nėra dirbtinio filmų minimumo.
SELECT a.vardas_pavarde AS rezisierius,
       ROUND(AVG(fv.vidurkis), 4) AS rezisieriaus_ivertinimas,
       COUNT(*) AS ivertintu_filmu_skaicius
FROM filmu_rezisieriai fr
JOIN asmenys a ON a.asmuo_id = fr.asmuo_id
JOIN filmu_vidurkiai fv ON fv.filmas_id = fr.filmas_id
GROUP BY a.asmuo_id, a.vardas_pavarde
ORDER BY AVG(fv.vidurkis) DESC, a.vardas_pavarde ASC;