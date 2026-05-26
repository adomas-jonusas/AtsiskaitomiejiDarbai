<?php
class Automobilis
{
    protected $marke;
    protected $modelis;
    protected $metai;
    protected $spalva;
    protected $kaina;
    protected $foto;
    protected $kuras;
    protected $variklis;
    protected $galia;
    protected $nuotolisPilnuBaku;

    public function __construct($data)
    {
        $this->marke = $data["marke"];
        $this->modelis = $data["modelis"];
        $this->metai = $data["metai"];
        $this->spalva = $data["spalva"];
        $this->kuras = $data["kuras"];
        $this->foto = $data["foto"];
        $this->kaina = $data["kaina"];
        $this->variklis = $data["variklis"];
        $this->galia = $data["galia"];
        $this->nuotolisPilnuBaku = $data["nuotolisPilnuBaku"];
    }

    protected function getKaina()
    {
        return $this->kaina . " €/val.";
    }

    protected function getFoto()
    {
        return '<img src="' . $this->foto . '" title="' . $this->marke . ' ' . $this->modelis . '" alt="' . $this->marke . ' ' . $this->modelis . '">';
    }

    public function html()
    {
        return '
        <div class="auto">
            ' . $this->getFoto() . '
            <h2>' . $this->marke . ' ' . $this->modelis . '</h2>
            <p><b>Metai:</b> ' . $this->metai . '</p>
            <p><b>Spalva:</b> ' . $this->spalva . '</p>
            <p><b>Kuro tipas:</b> ' . $this->kuras . '</p>
            <p><b>Variklis:</b> ' . $this->variklis . '</p>
            <p><b>Galia:</b> ' . $this->galia . ' AG</p>
            <p><b>Nuvažiuoja pilnu baku:</b> ' . $this->nuotolisPilnuBaku . ' km</p>
            <p><b>Kaina:</b> ' . $this->getKaina() . '</p>
        </div>';
    }
}

class Krovininis extends Automobilis
{
    private $keliamojiGalia;
    private $kebuloIlgis;

    public function __construct($data)
    {
        parent::__construct($data);
        $this->keliamojiGalia = $data["keliamojiGalia"];
        $this->kebuloIlgis = $data["kebuloIlgis"];
    }

    public function html()
    {
        return '
        <div class="auto krovininis">
            ' . $this->getFoto() . '
            <h2>' . $this->marke . ' ' . $this->modelis . '</h2>
            <p><b>Metai:</b> ' . $this->metai . '</p>
            <p><b>Spalva:</b> ' . $this->spalva . '</p>
            <p><b>Kuro tipas:</b> ' . $this->kuras . '</p>
            <p><b>Variklis:</b> ' . $this->variklis . '</p>
            <p><b>Galia:</b> ' . $this->galia . ' AG</p>
            <p><b>Atstumas be priekabos:</b> ' . $this->nuotolisPilnuBaku . ' km</p>
            <p><b>Kaina:</b> ' . $this->getKaina() . '</p>
            <p><b>Keliamoji galia:</b> ' . $this->keliamojiGalia . ' t</p>
            <p><b>Kėbulo ilgis:</b> ' . $this->kebuloIlgis . ' m</p>
        </div>';
    }
}

class Elektromobilis extends Automobilis
{
    private $atstumas;
    private $baterija;

    public function __construct($data)
    {
        parent::__construct($data);
        $this->atstumas = $data["atstumas"];
        $this->baterija = $data["baterija"];
    }

    protected function getKaina()
    {
        return $this->kaina . " €/val. + nemokamas įkrovimas";
    }

    public function html()
    {
        return '
        <div class="auto elektro">
            ' . $this->getFoto() . '
            <h2>' . $this->marke . ' ' . $this->modelis . '</h2>
            <p><b>Metai:</b> ' . $this->metai . '</p>
            <p><b>Spalva:</b> ' . $this->spalva . '</p>
            <p><b>Kuro tipas:</b> ' . $this->kuras . '</p>
            <p><b>Variklis:</b> ' . $this->variklis . '</p>
            <p><b>Galia:</b> ' . $this->galia . ' AG</p>
            <p><b>Nuvažiuoja pilnu įkrovimu:</b> ' . $this->atstumas . ' km</p>
            <p><b>Kaina:</b> ' . $this->getKaina() . '</p>
            <p><b>Baterija:</b> ' . $this->baterija . ' kWh</p>
        </div>';
    }
}

function foto($failas)
{
    return "https://commons.wikimedia.org/wiki/Special:FilePath/" . rawurlencode($failas) . "?width=900";
}

$transportas = [
    "BMW M serija" => [
        new Automobilis(["marke" => "BMW", "modelis" => "M3 F80", "metai" => 2018, "spalva" => "Yas Marina Blue", "kuras" => "Benzinas", "foto" => foto("DSC03028 (13999348587).jpg"), "kaina" => 75, "variklis" => "I6 3.0L twin-turbo", "galia" => 431, "nuotolisPilnuBaku" => 550]),
        new Automobilis(["marke" => "BMW", "modelis" => "M5 F10", "metai" => 2016, "spalva" => "Monte Carlo Blue", "kuras" => "Benzinas", "foto" => foto("BMW M5 (F10).jpg"), "kaina" => 85, "variklis" => "V8 4.4L twin-turbo", "galia" => 560, "nuotolisPilnuBaku" => 520]),
        new Automobilis(["marke" => "BMW", "modelis" => "M4 G82", "metai" => 2021, "spalva" => "Sao Paulo Yellow", "kuras" => "Benzinas", "foto" => foto("BMW M4 2021.jpg"), "kaina" => 95, "variklis" => "I6 3.0L twin-turbo", "galia" => 510, "nuotolisPilnuBaku" => 530]),
        new Automobilis(["marke" => "BMW", "modelis" => "M4 G82", "metai" => 2021, "spalva" => "Mint Green", "kuras" => "Benzinas", "foto" => foto("BMW M4 (G82) Mint Green IAA 2021 1X7A0002.jpg"), "kaina" => 100, "variklis" => "I6 3.0L twin-turbo", "galia" => 510, "nuotolisPilnuBaku" => 530]),
        new Automobilis(["marke" => "BMW", "modelis" => "M3 G80 Competition", "metai" => 2024, "spalva" => "Sao Paulo Yellow", "kuras" => "Benzinas", "foto" => foto("BMW G80 M3 Competition M xDrive Sao Paulo Yellow Edition Sao Paulo Yellow (21).jpg"), "kaina" => 110, "variklis" => "I6 3.0L twin-turbo", "galia" => 510, "nuotolisPilnuBaku" => 520]),
    ],

    "BMW elektromobiliai" => [
        new Elektromobilis(["marke" => "BMW", "modelis" => "i4 eDrive40", "metai" => 2023, "spalva" => "Tanzanite Blue II Metallic", "kuras" => "Elektra", "foto" => foto("BMW G26E i4 eDrive40 M Sport Tanzanite Blue II Metallic (2).jpg"), "kaina" => 82, "variklis" => "Elektrinis", "galia" => 340, "nuotolisPilnuBaku" => 590, "atstumas" => 590, "baterija" => 84]),
        new Elektromobilis(["marke" => "BMW", "modelis" => "iX xDrive50", "metai" => 2023, "spalva" => "Sophisto Grey Brilliant Effect", "kuras" => "Elektra", "foto" => foto("BMW I20 iX xDrive50 Sport Sophisto Grey Brilliant Effect (2).jpg"), "kaina" => 105, "variklis" => "Elektrinis AWD", "galia" => 523, "nuotolisPilnuBaku" => 630, "atstumas" => 630, "baterija" => 111]),
        new Elektromobilis(["marke" => "BMW", "modelis" => "i7 xDrive60", "metai" => 2023, "spalva" => "Oxide Grey", "kuras" => "Elektra", "foto" => foto("BMW G70E i7 xDrive60 Design Pure Excellence BMW Individual Oxide Grey (23).jpg"), "kaina" => 145, "variklis" => "Elektrinis AWD", "galia" => 544, "nuotolisPilnuBaku" => 625, "atstumas" => 625, "baterija" => 102]),
        new Elektromobilis(["marke" => "BMW", "modelis" => "iX1 xDrive30", "metai" => 2024, "spalva" => "Cape York Green Metallic", "kuras" => "Elektra", "foto" => foto("BMW U11 BEV iX1 xDrive30 M Sport Cape York Green Metallic (4).jpg"), "kaina" => 76, "variklis" => "Elektrinis AWD", "galia" => 313, "nuotolisPilnuBaku" => 440, "atstumas" => 440, "baterija" => 65]),
        new Elektromobilis(["marke" => "BMW", "modelis" => "i5 eDrive40", "metai" => 2025, "spalva" => "Cape York Green Metallic", "kuras" => "Elektra", "foto" => foto("BMW i5 G60 eDrive40 Cape York Green Metallic 01.jpg"), "kaina" => 98, "variklis" => "Elektrinis", "galia" => 340, "nuotolisPilnuBaku" => 582, "atstumas" => 582, "baterija" => 81]),
    ],

    "Fūros ir krovininiai" => [
        new Krovininis(["marke" => "Volvo", "modelis" => "FH16 750", "metai" => 2022, "spalva" => "Juoda", "kuras" => "Dyzelis", "foto" => foto("Volvo FH16 750.jpg"), "kaina" => 120, "variklis" => "D16 dyzelis 16.1L", "galia" => 750, "nuotolisPilnuBaku" => 2600, "keliamojiGalia" => 25, "kebuloIlgis" => 13.6]),
        new Krovininis(["marke" => "Volvo", "modelis" => "FH 2024", "metai" => 2024, "spalva" => "Pilka", "kuras" => "Dyzelis", "foto" => foto("Volvo FH (2024).jpg"), "kaina" => 130, "variklis" => "D13 dyzelis 12.8L", "galia" => 500, "nuotolisPilnuBaku" => 2800, "keliamojiGalia" => 24, "kebuloIlgis" => 13.6]),
        new Krovininis(["marke" => "Scania", "modelis" => "R500", "metai" => 2021, "spalva" => "Balta / žalia", "kuras" => "Dyzelis", "foto" => foto("Scania R500.jpg"), "kaina" => 115, "variklis" => "Dyzelis 13.0L", "galia" => 500, "nuotolisPilnuBaku" => 2400, "keliamojiGalia" => 23, "kebuloIlgis" => 13.6]),
        new Krovininis(["marke" => "Scania", "modelis" => "R500", "metai" => 2020, "spalva" => "Mėlyna", "kuras" => "Dyzelis", "foto" => foto("Scania R500.JPG"), "kaina" => 118, "variklis" => "Dyzelis 13.0L", "galia" => 500, "nuotolisPilnuBaku" => 2300, "keliamojiGalia" => 22, "kebuloIlgis" => 12.5]),
        new Krovininis(["marke" => "Mercedes-Benz", "modelis" => "Actros 1851", "metai" => 2022, "spalva" => "Geltona", "kuras" => "Dyzelis", "foto" => foto("Mercedes-Benz Actros 1851 Schöpfer (1).jpg"), "kaina" => 125, "variklis" => "OM471 dyzelis 12.8L", "galia" => 510, "nuotolisPilnuBaku" => 2500, "keliamojiGalia" => 24, "kebuloIlgis" => 13.6]),
    ],
];
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Automobilių nuoma</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #eeeeee;
            color: #222222;
        }

        h1 {
            text-align: center;
            margin: 25px 0;
        }

        .sarasas {
            width: 92%;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 18px;
            padding-bottom: 30px;
        }

        .kategorija {
            width: 92%;
            margin: 25px auto 12px;
            padding: 10px 14px;
            color: white;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .m-serija {
            background: #255f9e;
        }

        .furos {
            background: #8a3f25;
        }

        .elektromobiliai {
            background: #2f7c4b;
        }

        .auto {
            background: white;
            border: 1px solid #cccccc;
            border-top: 5px solid #255f9e;
            padding: 12px;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.12);
        }

        .auto img {
            width: 100%;
            height: 155px;
            object-fit: cover;
            border-radius: 4px;
            background: #dddddd;
        }

        .auto h2 {
            font-size: 20px;
            margin: 10px 0;
        }

        .auto p {
            margin: 6px 0;
        }

        .krovininis {
            border-top-color: #8a3f25;
        }

        .elektro {
            border-top-color: #2f7c4b;
        }
    </style>
</head>
<body>
    <h1>Automobilių nuoma</h1>

    <?php
    foreach ($transportas as $kategorija => $automobiliai) {
        $klase = "m-serija";

        if ($kategorija == "Fūros ir krovininiai") {
            $klase = "furos";
        }

        if ($kategorija == "BMW elektromobiliai") {
            $klase = "elektromobiliai";
        }

        echo '<h2 class="kategorija ' . $klase . '">' . $kategorija . '</h2>';
        echo '<div class="sarasas">';

        foreach ($automobiliai as $auto) {
            echo $auto->html();
        }

        echo '</div>';
    }
    ?>
</body>
</html>
