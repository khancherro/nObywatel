<?php
session_start();

function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

function sanitize_input($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imie = sanitize_input($_POST['imie']);
    $nazwisko = sanitize_input($_POST['nazwisko']);
    $birthdate = sanitize_input($_POST['birthdate']);
    $pesel = sanitize_input($_POST['pesel']);
    $adres = sanitize_input($_POST['adres']);
    $kod_pocztowy_miasto = sanitize_input($_POST['kod_pocztowy_miasto']);
    $data_zameldowania = sanitize_input($_POST['data_zameldowania']);
    $ostatnia_aktualizacja = sanitize_input($_POST['ostatnia_aktualizacja']);
    $seria_i_numer = sanitize_input($_POST['seria_i_numer']);
    $termin_waznosci = sanitize_input($_POST['termin_waznosci']);
    $data_wydania = sanitize_input($_POST['data_wydania']);
    $imie_ojca = sanitize_input($_POST['imie_ojca']);
    $imie_matki = sanitize_input($_POST['imie_matki']);
    $link_zdjecia = sanitize_input($_POST['link_zdjecia']);
    $plec = sanitize_input($_POST['plec']);
    $miejsce_urodzenia = sanitize_input($_POST['miejsce_urodzenia']);
    $nazwisko_rodowe_ojca = sanitize_input($_POST['nazwisko_rodowe_ojca']);
    $nazwisko_rodowe_matki = sanitize_input($_POST['nazwisko_rodowe_matki']);
    $miasto = sanitize_input($_POST['miasto']);
    $initials = strtoupper($imie[0] . $nazwisko[0]);
  
    $username = $_SESSION['username'];
  
    $dowodnowy_template = file_get_contents('template.html');
    $dashboard_template = file_get_contents('template2.html');
    $index_template = file_get_contents('template3.html');

    $dowodnowy_template = str_ireplace('IMIE', $imie, $dowodnowy_template);
    $dowodnowy_template = str_ireplace('NAZWISKO', $nazwisko, $dowodnowy_template);
    $dowodnowy_template = str_ireplace('BIRTHDATE', $birthdate, $dowodnowy_template);
    $dowodnowy_template = str_ireplace('PESEL', $pesel, $dowodnowy_template);
    $dowodnowy_template = str_ireplace('ADRES', $adres, $dowodnowy_template);
    $dowodnowy_template = str_ireplace('KOD POCZTOWY I MIASTO', $kod_pocztowy_miasto, $dowodnowy_template);
    $dowodnowy_template = str_ireplace('DATA ZAMELDOWANIA', $data_zameldowania, $dowodnowy_template);
    $dowodnowy_template = str_ireplace('OSTATNIA AKTUALIZACJA', $ostatnia_aktualizacja, $dowodnowy_template);
    $dowodnowy_template = str_ireplace('SERIA I NUMER', $seria_i_numer, $dowodnowy_template);
    $dowodnowy_template = str_ireplace('TERMIN WAŻNOSCI', $termin_waznosci, $dowodnowy_template);
    $dowodnowy_template = str_ireplace('DATA WYDANIA', $data_wydania, $dowodnowy_template);
    $dowodnowy_template = str_ireplace('LINK DO ZDJECIA UZYTKOWNIKA', $link_zdjecia, $dowodnowy_template);
    $dowodnowy_template = str_ireplace('PŁEĆ', $plec, $dowodnowy_template);
    $dowodnowy_template = str_ireplace('MIEJSCE URODZENIA', $miejsce_urodzenia, $dowodnowy_template);
    $dowodnowy_template = str_ireplace('NAZWICHO1', $nazwisko_rodowe_ojca, $dowodnowy_template);
    $dowodnowy_template = str_ireplace('NAZWICHO2', $nazwisko_rodowe_matki, $dowodnowy_template);
    $dowodnowy_template = str_ireplace('(MIASTO)', $miasto, $dowodnowy_template);
    $dowodnowy_template = str_ireplace('IMKOOJCA', $imie_ojca, $dowodnowy_template);
    $dowodnowy_template = str_ireplace('IMKOMATKI', $imie_matki, $dowodnowy_template);
    $dashboard_template = str_ireplace('INITIALS', $initials, $dashboard_template);

    $folder_name = "demObywatel_" . $username . "_" . generateRandomString();
    mkdir($folder_name);

    file_put_contents("$folder_name/index.html", $index_template);
    file_put_contents("$folder_name/dashboard.html", $dashboard_template);
    file_put_contents("$folder_name/dowodnowy.html", $dowodnowy_template);

    header("Location: $folder_name");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>demObywatel | Generator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="generator.css">
    <style>
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #121212;
            transition: opacity 0.75s, visibility 0.75s;
        }

        .loader--hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader::after {
            content: "";
            width: 75px;
            height: 75px;
            border: 15px solid #dddddd;
            border-top-color: #1e1e1e;
            border-radius: 50%;
            animation: loading 0.75s ease infinite;
        }

        @keyframes loading {
            from {
                transform: rotate(0turn);
            }
            to {
                transform: rotate(1turn);
            }
        }

        .informacja {
            text-align: center;
        }
    </style>
    <script>
        window.addEventListener("load", () => {
            const loader = document.querySelector(".loader");

            loader.classList.add("loader--hidden");

            loader.addEventListener("transitionend", () => {
                document.body.removeChild(loader);
            });
        });
    </script>
</head>
<body>
    <header>
        <h1>demObywatel | Generator <i class="fas fa-user"></i></h1> <br>
        <a href="dashboard.php" class="back-button"><i class="fas fa-arrow-left"></i> Powrót</a>
    </header>
    <div class="loader"></div>
    <div class="content">
        <form action="" method="post">
            <label for="imie">Imię:</label>
            <input type="text" id="imie" name="imie" placeholder="Jan" required><br><br>
            <label for="nazwisko">Nazwisko:</label>
            <input type="text" id="nazwisko" name="nazwisko" placeholder ="Kowalski" required><br><br>
            <label for="birthdate">Data urodzenia:</label>
            <input type="text" id="birthdate" name="birthdate" placeholder ="01.01.2000" required><br><br>
            <label for="pesel">PESEL:</label>
            <input type="text" id="pesel" name="pesel" placeholder="05210169617" required maxlength="11"><br><br>
            <label for="adres">Adres:</label>
            <input type="text" id="adres" name="adres" placeholder="Złota 44" required><br><br>
            <label for="kod_pocztowy_miasto">Kod pocztowy i miasto:</label>
            <input type="text" id="kod_pocztowy_miasto" name="kod_pocztowy_miasto" placeholder="00-120, Warszawa" required><br><br>
            <label for="data_zameldowania">Data zameldowania:</label>
            <input type="date" id="data_zameldowania" name="data_zameldowania" required><br><br>
            <label for="ostatnia_aktualizacja">Ostatnia aktualizacja:</label>
            <input type="date" id="ostatnia_aktualizacja" name="ostatnia_aktualizacja" required><br><br>
            <label for="seria_i_numer">Seria i numer:</label>
            <input type="text" id="seria_i_numer" name="seria_i_numer" placeholder="FIP146052" required><br><br>
            <label for="termin_waznosci">Termin ważności:</label>
            <input type="date" id="termin_waznosci" name="termin_waznosci" required><br><br>
            <label for="data_wydania">Data wydania:</label>
            <input type="date" id="data_wydania" name="data_wydania" required><br><br>
            <label for="link_zdjecia">Link do zdjęcia:</label>
            <input type="text" id="link_zdjecia" name="link_zdjecia" required><br><br>
          <label for="plec" class="label-2">Płeć:</label><br>
          <select id="plec" name="plec" required>
            <option value="">Wybierz...</option>
            <option value="Mężczyzna">Mężczyzna</option>
            <option value="Kobieta">Kobieta</option>
          </select><br><br>
            <label for="miejsce_urodzenia">Miejsce urodzenia:</label>
            <input type="text" id="miejsce_urodzenia" name="miejsce_urodzenia" placeholder="Warszawa" required><br><br>
            <label for="nazwisko_rodowe_ojca">Nazwisko rodowe ojca:</label>
            <input type="text" id="nazwisko_rodowe_ojca" name="nazwisko_rodowe_ojca" placeholder="Kiepski" required><br><br>
            <label for="nazwisko_rodowe_matki">Nazwisko rodowe matki:</label>
            <input type="text" id="nazwisko_rodowe_matki" name="nazwisko_rodowe_matki" placeholder="Kowalska" required><br><br>
            <label for="miasto">Organ Wydający:</label>
            <input type="text" id="miasto" name="miasto" placeholder="WARSZAWA" required><br><br>
            <label for="imie_ojca">Imię ojca:</label>
            <input type="text" id="imie_ojca" name="imie_ojca" placeholder="Ferdynand" required><br><br>
            <label for="imie_matki">Imię matki:</label>
            <input type="text" id="imie_matki" name="imie_matki" placeholder="Joanna" required><br><br>
            <input type="submit" value="Generuj">
        </form>
   </div>
  <div class="navbar">
        <a href="/info.php" class="nav-link"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
  </body>
</html>
