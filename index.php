<?php
// Verbindung zur Datenbank herstellen
$conn = new mysqli("localhost", "root", "", "personalverwaltung");

// Überprüfen der Verbindung
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error); // Bei Fehlschlagen der Verbindung: Fehlermeldung anzeigen und Skript beenden
}

// Überprüfen, ob das Formular zum Hinzufügen eines Mitarbeiters gesendet wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Überprüfe, ob die Anfrage eine POST-Anfrage ist
    // Überprüfe, ob die POST-Variablen existieren, bevor du darauf zugreifst
    $name = isset($_POST['name']) ? $_POST['name'] : ''; // Den Wert von 'name' aus dem Formular lesen, wenn nicht vorhanden, leer lassen
    $vorname = isset($_POST['vorname']) ? $_POST['vorname'] : ''; // Den Wert von 'vorname' aus dem Formular lesen, wenn nicht vorhanden, leer lassen
    $email = isset($_POST['email']) ? $_POST['email'] : ''; // Den Wert von 'email' aus dem Formular lesen, wenn nicht vorhanden, leer lassen
    $tel = isset($_POST['tel']) ? $_POST['tel'] : ''; // Den Wert von 'tel' aus dem Formular lesen, wenn nicht vorhanden, leer lassen
    $position = isset($_POST['position']) ? $_POST['position'] : ''; // Den Wert von 'position' aus dem Formular lesen, wenn nicht vorhanden, leer lassen
    $abteilung = isset($_POST['abteilung']) ? $_POST['abteilung'] : ''; // Den Wert von 'abteilung' aus dem Formular lesen, wenn nicht vorhanden, leer lassen

    // Überprüfe, ob der Mitarbeiter bereits existiert
    $check_query = "SELECT * FROM Mitarbeiter WHERE name='$name' AND vorname='$vorname'";
    $result = $conn->query($check_query); // Führe die Abfrage in der Datenbank aus

    if ($result->num_rows > 0) {
        // Mitarbeiter existiert bereits
        echo '<script>document.getElementById("message").innerHTML = "Dieser Mitarbeiter ist bereits in der Datenbank"; document.getElementById("message").style.display = "block";</script>';
    } else {
        // Mitarbeiter existiert nicht, füge ihn hinzu
        $insert_query = "INSERT INTO Mitarbeiter (name, vorname, email, tel, position, abteilung) VALUES ('$name', '$vorname', '$email', '$tel', '$position', '$abteilung')";

        if ($conn->query($insert_query) === TRUE) {
            echo '<script>document.getElementById("message").innerHTML = "Neuer Mitarbeiter erfolgreich angelegt"; document.getElementById("message").style.display = "block";</script>';
        } else {
            echo '<script>document.getElementById("message").innerHTML = "Fehler beim Anlegen des Mitarbeiters: ' . $conn->error . '"; document.getElementById("message").style.display = "block";</script>';
        }
    }
}
// Bearbeiten eines Mitarbeiters anhand der Mitarbeiter-ID
if (isset($_POST['edit'])) {
    // Hier ergänze den Code zum Bearbeiten eines Mitarbeiters
}

// Suchen nach einem Mitarbeiter
if (isset($_POST['suchbegriff'])) {
    $search_query = $_POST['suchbegriff'];
    // SQL-Befehl zum Suchen nach einem Mitarbeiter in der Datenbank
    $search_result = $conn->query("SELECT * FROM Mitarbeiter WHERE name LIKE '%$search_query%' OR vorname LIKE '%$search_query%'");

    if ($search_result->num_rows > 0) {
        // Wenn der Mitarbeiter gefunden wurde
        while ($row = $search_result->fetch_assoc()) {
            echo "Der Mitarbeiter mit dem Namen " . $row['suchbegriff'] . " wurde gefunden.";
        }
    } else {
        // Wenn der Mitarbeiter nicht gefunden wurde
        echo "Der Mitarbeiter ist nicht in der Datenbank vorhanden.";
    }
}

// Drucken einer Mitarbeiterliste
if (isset($_POST['print'])) {
    // Code für das Drucken einer Mitarbeiterliste
}

// Datenbankverbindung schließen
$conn->close();
?>
