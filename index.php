<?php
// Verbindung zur Datenbank herstellen
$conn = new mysqli("localhost", "root", "", "personalverwaltung");

// Überprüfen der Verbindung
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error); // Bei Fehlschlagen der Verbindung: Fehlermeldung anzeigen und Skript beenden
}



// SQL-Befehl zum Einfügen eines neuen Mitarbeiters in die Datenbank
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Überprüfen, ob die POST-Variablen existieren, bevor darauf zugegriffen wird
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $vorname = isset($_POST['vorname']) ? $_POST['vorname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Überprüfen, ob der Mitarbeiter bereits existiert
    $check_query = "SELECT * FROM Mitarbeiter WHERE name='$name' AND vorname='$vorname' AND email='$email'";
    $result = $conn->query($check_query); // Abfrage in der Datenbank ausführen

    if ($result->num_rows > 0) {
        // Mitarbeiter existiert bereits, zeige eine entsprechende Meldung
        echo "Der Mitarbeiter existiert bereits in der Datenbank.";
    } else {
        // Mitarbeiter existiert nicht, füge ihn hinzu
        $insert_query = "INSERT INTO Mitarbeiter (name, vorname, email) VALUES ('$name', '$vorname', '$email')";

        if ($conn->query($insert_query) === TRUE) {
            // Erfolgreich eingefügt, zeige eine Bestätigung
            echo "Mitarbeiter erfolgreich angelegt.";
        } else {
            // Fehler beim Einfügen, zeige Fehlermeldung
            echo "Fehler beim Anlegen des Mitarbeiters: " . $conn->error;
        }
    }
}

// Bearbeiten eines Mitarbeiters anhand der Mitarbeiter-ID
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Überprüfen, ob die POST-Variablen existieren, bevor darauf zugegriffen wird
    $mitarbeiter_id = isset($_POST['mitarbeiter_id']) ? $_POST['mitarbeiter_id'] : '';

    // Hier könntest du weitere Felder zum Aktualisieren einfügen
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $vorname = isset($_POST['vorname']) ? $_POST['vorname'] : '';


    // Annahme: Aktualisierung des Namens basierend auf der Mitarbeiter-ID
    $update_query = "UPDATE Mitarbeiter SET name = 'Neuer Name' WHERE mitarbeiter_id = $mitarbeiter_id";

    if ($conn->query($update_query) === TRUE) {
        // Erfolgreich aktualisiert, zeige Bestätigung
        echo "Erfolgreich in der Datenbank aktualisiert!";
    } else {
        // Fehler beim Aktualisieren, zeige Fehlermeldung
        echo "Fehler beim Aktualisieren in der Datenbank: " . $conn->error;
    }
}

// Suchen nach einem Mitarbeiter
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Überprüfen, ob die POST-Variablen existieren, bevor darauf zugegriffen wird
    $suchbegriff = isset($_POST['suchbegriff']) ? $_POST['suchbegriff'] : '';

    // SQL-Abfrage zum Suchen des Mitarbeiters in der Datenbank
    $search_query = "SELECT * FROM Mitarbeiter WHERE name='$suchbegriff'";
    $result = $conn->query($search_query);

    // Ergebnis der Suche verarbeiten
    if ($result->num_rows > 0) {
        // Mitarbeiter gefunden, zeige die Informationen an oder bearbeite sie entsprechend deiner Anforderungen
        $row = $result->fetch_assoc();
        echo "Der Mitarbeiter mit dem Namen " . $row['name'] . " wurde gefunden.";
    } else {
        // Mitarbeiter nicht gefunden, gib eine Nachricht aus, um einen neuen Mitarbeiter anzulegen
        echo "Der Mitarbeiter mit dem Namen " . $suchbegriff . " befindet sich nicht in unserer Datenbank. Bitte legen Sie einen neuen an.";
    }
}

// Drucken einer Mitarbeiterliste
// Überprüfen, ob das Formular zum Drucken einer Mitarbeiterliste gesendet wurde
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // SQL-Abfrage, um alle Mitarbeiter aus der Datenbank abzurufen
    $query = "SELECT * FROM Mitarbeiter";
    $result = $conn->query($query);

    // Ergebnis der Abfrage verarbeiten und Mitarbeiterliste ausgeben
    if ($result->num_rows > 0) {
        echo "<h3>Mitarbeiterliste:</h3>";
        while ($row = $result->fetch_assoc()) {
            // Hier kannst du die Informationen der Mitarbeiter anzeigen
            echo "Name: " . $row['name'] . ", Vorname: " . $row['vorname'] . ", Email: " . $row['email'] . "<br>";
            // ... Weitere Informationen je nach Bedarf ausgeben
        }
        echo "<p>Mitarbeiterliste wird ausgedruckt.</p>";
    } else {
        echo "Keine Mitarbeiter gefunden.";
    }
}

// Datenbankverbindung schließen
$conn->close();
?>
