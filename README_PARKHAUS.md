# Parkhausverwaltung - Laravel Anwendung

## Übersicht

Dies ist eine Testversion eines Parkhausverwaltungssystems, das die digitalisierte Verwaltung und den Betrieb von Parkhäusern ermöglicht. Das System wurde mit Laravel entwickelt und bietet eine vollständige API sowie eine benutzerfreundliche Weboberfläche.

## Funktionen

### 🏢 Parkhausverwaltung
- Erstellung neuer Parkhäuser mit konfigurierbarer Anzahl von Ebenen und Parkplätzen
- Individuelle Preisgestaltung pro Stunde für jedes Parkhaus
- Echtzeit-Überwachung der verfügbaren und belegten Parkplätze
- Dynamische Verwaltung unbegrenzter Parkhäuser

### 🚗 Ein- und Ausfahrt
- Videoüberwachte Ein- und Ausfahrt (simuliert durch Kennzeichen-Bildpfade)
- Automatische Schrankensteuerung nach erfolgreicher Kennzeichenerkennung
- Erstellung von Stundentickets bei Einfahrt
- Überprüfung der Zahlungsstatus bei Ausfahrt

### 💳 Kassenautomat
- Berechnung der Parkgebühren basierend auf Parkdauer
- Unterstützung für Barzahlung mit Rückgeldberechnung
- Kreditkartenzahlung mit simulierter Validierung
- Automatische Ticketverwaltung

### 🎫 Ticketverwaltung
- Stundentickets für reguläre Parkvorgänge
- Dauertickets mit Gültigkeitsdatum
- Automatische Statusverwaltung (aktiv, abgeschlossen, storniert)
- Verknüpfung mit Fahrzeugen über Kennzeichen

## Installation und Einrichtung

### Voraussetzungen
- PHP 8.1 oder höher
- Composer
- SQLite (bereits konfiguriert) oder MySQL/MariaDB
- Laravel Sail (optional, für Docker-Umgebung)

### 1. Abhängigkeiten installieren
```bash
composer install
```

### 2. Umgebungsvariablen konfigurieren
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Datenbank einrichten
```bash
php artisan migrate
php artisan db:seed
```

### 4. Anwendung starten
```bash
php artisan serve
```

Die Anwendung ist dann unter `http://localhost:8000` verfügbar.

## Datenbankstruktur

### Tabellen

#### `parkhaeuser`
- Grundinformationen über Parkhäuser
- Anzahl der Ebenen und Parkplätze pro Ebene
- Preis pro Stunde

#### `parkplaetze`
- Einzelne Parkplätze mit Status (frei, besetzt, reserviert, gesperrt)
- Verknüpfung mit Parkhaus und Ebene

#### `fahrzeuge`
- Fahrzeuginformationen mit eindeutigen Kennzeichen
- Marke, Modell und Farbe (optional)

#### `tickets`
- Parktickets (Stunden- oder Dauertickets)
- Ein- und Ausfahrtszeiten
- Verknüpfung mit Fahrzeug und Parkhaus

#### `zahlungen`
- Zahlungsinformationen
- Unterstützung für Bar- und Kreditkartenzahlung
- Rückgeldberechnung

#### `ein_ausfahrten`
- Protokollierung aller Ein- und Ausfahrten
- Kennzeichen-Bildpfade für Videoüberwachung
- Schrankenstatus

## API-Endpunkte

### Parkhausverwaltung
- `GET /api/parkhaus` - Alle Parkhäuser anzeigen
- `POST /api/parkhaus` - Neues Parkhaus erstellen
- `GET /api/parkhaus/{id}` - Parkhausdetails anzeigen
- `PUT /api/parkhaus/{id}` - Parkhaus aktualisieren
- `DELETE /api/parkhaus/{id}` - Parkhaus löschen

### Ein- und Ausfahrt
- `POST /api/ein-ausfahrt/einfahrt` - Einfahrt simulieren
- `POST /api/ein-ausfahrt/ausfahrt` - Ausfahrt simulieren

### Kassenautomat
- `POST /api/kassenautomat/zeige-betrag` - Zu zahlenden Betrag anzeigen
- `POST /api/kassenautomat/barzahlung` - Barzahlung verarbeiten
- `POST /api/kassenautomat/kreditkartenzahlung` - Kreditkartenzahlung verarbeiten

## Verwendung

### 1. Parkhaus erstellen
1. Öffnen Sie die Anwendung im Browser
2. Füllen Sie das Formular "Neues Parkhaus erstellen" aus
3. Klicken Sie auf "Parkhaus erstellen"

### 2. Einfahrt simulieren
1. Wählen Sie ein Parkhaus aus der Dropdown-Liste
2. Geben Sie ein Kennzeichen ein
3. Klicken Sie auf "Einfahrt simulieren"
4. Das System erstellt automatisch ein Ticket und weist einen Parkplatz zu

### 3. Zahlung am Kassenautomaten
1. Wählen Sie Parkhaus und Kennzeichen
2. Klicken Sie auf "Betrag anzeigen"
3. Wählen Sie zwischen Bar- oder Kreditkartenzahlung
4. Geben Sie die erforderlichen Informationen ein

### 4. Ausfahrt simulieren
1. Wählen Sie Parkhaus und Kennzeichen
2. Klicken Sie auf "Ausfahrt simulieren"
3. Das System prüft den Zahlungsstatus und öffnet die Schranke

## Beispieldaten

Nach dem Ausführen des Seeders sind folgende Beispieldaten verfügbar:

- **Parkhaus Zentrum**: 3 Ebenen × 50 Plätze, €2,50/Stunde
- **Parkhaus Bahnhof**: 2 Ebenen × 30 Plätze, €3,00/Stunde
- **Beispielfahrzeuge**: M-AB 1234 (BMW X3), M-CD 5678 (Audi A4)
- **Dauerticket**: Für M-AB 1234 im Parkhaus Zentrum

## Erweiterte Funktionen

### Videoüberwachung simulieren
Das System unterstützt die Simulation von Kennzeichen-Bildern durch Pfadangaben. In einer Produktionsumgebung können diese durch echte Bildverarbeitung ersetzt werden.

### Automatisierung
Die Schrankensteuerung erfolgt automatisch basierend auf dem Erfolg der Ein- oder Ausfahrt. In einer echten Umgebung können hier Hardware-Schnittstellen integriert werden.

### Skalierbarkeit
Das System ist so konzipiert, dass beliebig viele Parkhäuser verwaltet werden können, ohne dass Änderungen am Code erforderlich sind.

## Technische Details

### Architektur
- **Backend**: Laravel 10 mit Eloquent ORM
- **Frontend**: HTML, JavaScript, Tailwind CSS
- **Datenbank**: SQLite (Standard), MySQL/MariaDB kompatibel
- **API**: RESTful API mit JSON-Responses

### Sicherheit
- Eingabevalidierung auf allen Endpunkten
- SQL-Injection-Schutz durch Eloquent ORM
- CSRF-Schutz für Web-Formulare

### Performance
- Eager Loading für optimierte Datenbankabfragen
- Datenbanktransaktionen für Datenkonsistenz
- Caching-fähige Architektur

## Fehlerbehebung

### Häufige Probleme

1. **Migrationen funktionieren nicht**
   - Stellen Sie sicher, dass die Datenbankverbindung korrekt konfiguriert ist
   - Führen Sie `php artisan config:clear` aus

2. **Seeder funktioniert nicht**
   - Überprüfen Sie, ob alle Modelle korrekt importiert sind
   - Führen Sie `php artisan migrate:fresh --seed` aus

3. **API-Endpunkte nicht erreichbar**
   - Überprüfen Sie die Routen mit `php artisan route:list`
   - Stellen Sie sicher, dass der Webserver läuft

## Lizenz

Dieses Projekt ist eine Testversion für Bildungszwecke.

## Support

Bei Fragen oder Problemen wenden Sie sich an das Entwicklungsteam.
