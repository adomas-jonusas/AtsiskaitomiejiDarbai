-- FILMUKAI. Šaltinis: data.xlsx, lapas duomenys, A4:L32.

-- MySQL / MariaDB importas. phpMyAdmin PIRMIAUSIA pasirinkite tuščią DB.

-- Esamos lentelės netrinamos. Failas skirtas vienkartiniam importui.

SET NAMES utf8mb4;

CREATE TABLE kalbos (
    kalba_id INT UNSIGNED PRIMARY KEY,
    pavadinimas VARCHAR(80) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE valstybes (
    valstybe_id INT UNSIGNED PRIMARY KEY,
    kodas VARCHAR(10) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE zanrai (
    zanras_id INT UNSIGNED PRIMARY KEY,
    pavadinimas VARCHAR(80) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE asmenys (
    asmuo_id INT UNSIGNED PRIMARY KEY,
    vardas_pavarde VARCHAR(160) NOT NULL,
    lytis CHAR(1) NULL,
    CONSTRAINT chk_asmenys_lytis CHECK (lytis IN ('M', 'F'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE kritikai (
    kritikas_id INT UNSIGNED PRIMARY KEY,
    vardas VARCHAR(100) NULL,
    pavarde VARCHAR(100) NULL,
    anoniminis BOOLEAN NOT NULL DEFAULT 0,
    CONSTRAINT chk_kritikai_tapatybe CHECK (
        (anoniminis = 1 AND vardas IS NULL AND pavarde IS NULL) OR
        (anoniminis = 0 AND vardas IS NOT NULL AND pavarde IS NOT NULL)
    )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE filmai (
    filmas_id INT UNSIGNED PRIMARY KEY,
    pavadinimas VARCHAR(200) NOT NULL,
    metai SMALLINT UNSIGNED NOT NULL,
    trukme_min SMALLINT UNSIGNED NOT NULL,
    kalba_id INT UNSIGNED NULL,
    premjera DATE NULL,
    valstybe_id INT UNSIGNED NULL,
    CONSTRAINT chk_filmai_trukme CHECK (trukme_min > 0),
    CONSTRAINT fk_filmai_kalba FOREIGN KEY (kalba_id) REFERENCES kalbos(kalba_id),
    CONSTRAINT fk_filmai_valstybe FOREIGN KEY (valstybe_id) REFERENCES valstybes(valstybe_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE filmu_rezisieriai (
    filmas_id INT UNSIGNED NOT NULL,
    asmuo_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (filmas_id, asmuo_id),
    CONSTRAINT fk_rezisieriai_filmas FOREIGN KEY (filmas_id) REFERENCES filmai(filmas_id),
    CONSTRAINT fk_rezisieriai_asmuo FOREIGN KEY (asmuo_id) REFERENCES asmenys(asmuo_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE vaidmenys (
    filmas_id INT UNSIGNED NOT NULL,
    asmuo_id INT UNSIGNED NOT NULL,
    personazas VARCHAR(200) NOT NULL,
    PRIMARY KEY (filmas_id, asmuo_id, personazas),
    CONSTRAINT fk_vaidmenys_filmas FOREIGN KEY (filmas_id) REFERENCES filmai(filmas_id),
    CONSTRAINT fk_vaidmenys_asmuo FOREIGN KEY (asmuo_id) REFERENCES asmenys(asmuo_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE filmu_zanrai (
    filmas_id INT UNSIGNED NOT NULL,
    zanras_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (filmas_id, zanras_id),
    CONSTRAINT fk_zanrai_filmas FOREIGN KEY (filmas_id) REFERENCES filmai(filmas_id),
    CONSTRAINT fk_zanrai_zanras FOREIGN KEY (zanras_id) REFERENCES zanrai(zanras_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE ivertinimai (
    filmas_id INT UNSIGNED NOT NULL,
    kritikas_id INT UNSIGNED NOT NULL,
    zvaigzdutes DECIMAL(4,2) NOT NULL,
    PRIMARY KEY (filmas_id, kritikas_id),
    CONSTRAINT chk_ivertinimas CHECK (zvaigzdutes BETWEEN 0 AND 10),
    CONSTRAINT fk_ivertinimai_filmas FOREIGN KEY (filmas_id) REFERENCES filmai(filmas_id),
    CONSTRAINT fk_ivertinimai_kritikas FOREIGN KEY (kritikas_id) REFERENCES kritikai(kritikas_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

START TRANSACTION;

INSERT INTO kalbos (kalba_id, pavadinimas) VALUES
(1, 'English'),
(2, 'Japanese');

INSERT INTO valstybes (valstybe_id, kodas) VALUES
(1, 'UK'),
(2, 'SW'),
(3, 'USA'),
(4, 'JP');

INSERT INTO zanrai (zanras_id, pavadinimas) VALUES
(1, 'Mystery'),
(2, 'Action'),
(3, 'Horror'),
(4, 'Drama'),
(5, 'Adventure'),
(6, 'War'),
(7, 'Thriller'),
(8, 'Crime'),
(9, 'Comedy'),
(10, 'Romance'),
(11, 'Biography'),
(12, 'Animation'),
(13, 'Music');

INSERT INTO asmenys (asmuo_id, vardas_pavarde, lytis) VALUES
(1, 'Alfred Hitchcock', NULL),
(2, 'James Stewart', NULL),
(3, 'Maggie Gyllenhaal', 'F'),
(4, 'Jack Clayton', NULL),
(5, 'Deborah Kerr', 'F'),
(6, 'David Lean', NULL),
(7, 'Peter OToole', 'M'),
(8, 'Michael Cimino', NULL),
(9, 'Robert De Niro', 'M'),
(10, 'Milos Forman', NULL),
(11, 'F. Murray Abraham', 'M'),
(12, 'Ridley Scott', NULL),
(13, 'Harrison Ford', 'M'),
(14, 'Stanley Kubrick', NULL),
(15, 'Nicole Kidman', 'F'),
(16, 'Bryan Singer', NULL),
(17, 'Stephen Baldwin', 'M'),
(18, 'Roman Polanski', NULL),
(19, 'Mark Wahlberg', 'M'),
(20, 'Paul Thomas Anderson', NULL),
(21, 'Woody Allen', 'M'),
(22, 'Claire Danes', 'F'),
(23, 'Hayao Miyazaki', NULL),
(24, 'Tim Robbins', NULL),
(25, 'Robin Williams', 'M'),
(26, 'Kevin Spacey', 'M'),
(27, 'Frank Darabont', NULL),
(28, 'Sam Mendes', NULL),
(29, 'Kate Winslet', 'F'),
(30, 'James Cameron', NULL),
(31, 'Gus Van Sant', NULL),
(32, 'Jon Voight', 'M'),
(33, 'John Boorman', NULL),
(34, 'Ewan McGregor', 'M'),
(35, 'Danny Boyle', NULL),
(36, 'Christopher Nolan', NULL),
(37, 'Dev Patel', 'M'),
(38, 'Richard Kelly', NULL),
(39, 'Sigourney Weaver', 'F'),
(40, 'Jack Nicholson', 'M'),
(41, 'Christian Bale', 'M'),
(42, 'Andrei Tarkovsky', NULL);

INSERT INTO kritikai (kritikas_id, vardas, pavarde, anoniminis) VALUES
(1, 'Righty', 'Sock', 0),
(2, 'Richard', 'Adams', 0),
(3, 'Jack', 'Malvern', 0),
(4, 'Brandt', 'Sponseller', 0),
(5, 'Flagrant', 'Baronessa', 0),
(6, 'Vincent', 'Cadena', 0),
(7, NULL, NULL, 1),
(8, 'Simon', 'Wright', 0),
(9, 'Hannah', 'Steele', 0),
(10, 'Neal', 'Wruck', 0),
(11, 'Paul', 'Monks', 0),
(12, 'Mike', 'Salvati', 0),
(13, NULL, NULL, 1),
(14, 'Scott', 'LeBrun', 0),
(15, 'Krug', 'Stillo', 0),
(16, 'Sasha', 'Goldshtein', 0),
(17, 'Josh', 'Cates', 0),
(18, 'Wesley S.', 'Walker', 0),
(19, 'Victor', 'Woeltjen', 0),
(20, 'Alec', 'Shaw', 0);

INSERT INTO filmai (filmas_id, pavadinimas, metai, trukme_min, kalba_id, premjera, valstybe_id) VALUES
(1, 'Vertigo', 1958, 128, 1, '1958-08-24', 1),
(2, 'The Innocents', 1961, 100, 1, '1962-02-19', 2),
(3, 'Lawrence of Arabia', 1962, 216, 1, '1962-12-11', 1),
(4, 'The Deer Hunter', 1978, 183, 1, '1979-03-08', 1),
(5, 'Amadeus', 1984, 160, 1, '1985-01-07', 1),
(6, 'Blade Runner', 1982, 117, 1, '1982-09-09', 1),
(7, 'Eyes Wide Shut', 1999, 159, 1, NULL, 1),
(8, 'The Usual Suspects', 1995, 106, 1, '1995-08-25', 1),
(9, 'Chinatown', 1974, 130, 1, '1974-08-09', 1),
(10, 'Boogie Nights', 1997, 155, 1, '1998-02-16', 1),
(11, 'Annie Hall', 1977, 93, 1, '1977-04-20', 3),
(12, 'Princess Mononoke', 1997, 134, 2, '2001-10-19', 1),
(13, 'The Shawshank Redemption', 1994, 142, 1, '1995-02-17', 1),
(14, 'American Beauty', 1999, 122, 1, NULL, 1),
(15, 'Titanic', 1997, 194, 1, '1998-01-23', 1),
(16, 'Good Will Hunting', 1997, 126, 1, '1998-06-03', 1),
(17, 'Deliverance', 1972, 109, 1, '1982-10-05', 1),
(18, 'Trainspotting', 1996, 94, 1, '1996-02-23', 1),
(19, 'The Prestige', 2006, 130, 1, '2006-11-10', 1),
(20, 'Donnie Darko', 2001, 113, 1, NULL, 1),
(21, 'Slumdog Millionaire', 2008, 120, 1, '2009-01-09', 1),
(22, 'Aliens', 1986, 137, 1, '1986-08-29', 1),
(23, 'Beyond the Sea', 2004, 118, 1, '2004-11-26', 1),
(24, 'Avatar', 2009, 162, 1, '2009-12-17', 1),
(25, 'Seven Samurai', 1954, 207, 2, '1954-04-26', 4),
(26, 'Spirited Away', 2001, 125, 2, '2003-09-12', 1),
(27, 'Back to the Future', 1985, 116, 1, '1985-12-04', 1),
(28, 'Braveheart', 1995, 178, 1, '1995-09-08', 1);

INSERT INTO filmu_rezisieriai (filmas_id, asmuo_id) VALUES
(1, 1),
(2, 4),
(3, 6),
(4, 8),
(5, 10),
(6, 12),
(7, 14),
(8, 16),
(8, 4),
(9, 18),
(10, 20),
(11, 21),
(12, 23),
(12, 4),
(13, 27),
(14, 28),
(15, 30),
(15, 21),
(16, 31),
(17, 33),
(18, 35),
(19, 36),
(20, 38),
(21, 35),
(22, 30),
(23, 26),
(23, 14),
(24, 42);

INSERT INTO vaidmenys (filmas_id, asmuo_id, personazas) VALUES
(1, 2, 'John Scottie Ferguson'),
(1, 3, 'Marry'),
(2, 5, 'Miss Giddens'),
(3, 7, 'T.E. Lawrence'),
(4, 9, 'Michael'),
(5, 11, 'Antonio Salieri'),
(6, 13, 'Rick Deckard'),
(7, 15, 'Alice Harford'),
(8, 17, 'McManus'),
(9, 19, 'Eddie Adams'),
(10, 21, 'Alvy Singer'),
(11, 22, 'San'),
(12, 24, 'Andy Dufresne'),
(12, 25, 'Scott'),
(12, 26, 'Sam'),
(13, 26, 'Lester Burnham'),
(14, 29, 'Rose DeWitt Bukater'),
(15, 25, 'Sean Maguire'),
(16, 32, 'Ed'),
(17, 34, 'Renton'),
(18, 3, 'Elizabeth Darko'),
(19, 37, 'Older Jamal'),
(20, 39, 'Ripley'),
(21, 26, 'Bobby Darin'),
(22, 40, 'J.J. Gittes'),
(23, 41, 'Alfred Borden');

INSERT INTO filmu_zanrai (filmas_id, zanras_id) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 1),
(2, 4),
(3, 5),
(4, 6),
(6, 7),
(7, 1),
(8, 8),
(11, 9),
(11, 10),
(11, 11),
(12, 12),
(12, 5),
(12, 1),
(13, 8),
(14, 10),
(15, 1),
(17, 5),
(18, 4),
(21, 4),
(22, 2),
(23, 13),
(23, 4),
(26, 4),
(27, 1),
(28, 4);

INSERT INTO ivertinimai (filmas_id, kritikas_id, zvaigzdutes) VALUES
(1, 1, '8.4'),
(1, 2, '7.2'),
(2, 3, '7.90'),
(2, 4, '7.1'),
(3, 5, '8.3'),
(3, 6, '8.2'),
(6, 7, '9.2'),
(8, 8, '8.6'),
(8, 9, '7.7'),
(9, 10, '0'),
(10, 11, '3.0'),
(11, 12, '8.10'),
(12, 13, '9.9'),
(12, 14, '8.0'),
(12, 15, '8.2'),
(14, 16, '7.0'),
(14, 12, '8.10'),
(15, 1, '7.70'),
(15, 17, '6.9'),
(16, 17, '4.00'),
(18, 14, '4'),
(19, 12, '6.10'),
(20, 9, '8.1'),
(20, 18, '8.5'),
(21, 6, '8.0'),
(21, 16, '7.0'),
(22, 4, '8.4'),
(23, 2, '6.7'),
(24, 19, '7.3'),
(25, 15, '7.7'),
(26, 11, '4.1'),
(26, 10, '5'),
(27, 8, '6'),
(27, 19, '6'),
(27, 5, '8.5'),
(27, 20, '9');

COMMIT;

-- Vidurkis apskaičiuojamas prieš jungiant režisierius, žanrus ar aktorius.
CREATE VIEW filmu_vidurkiai AS
SELECT filmas_id, AVG(zvaigzdutes) AS vidurkis, COUNT(*) AS vertinimu_skaicius
FROM ivertinimai
GROUP BY filmas_id;