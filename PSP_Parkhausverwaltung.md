# PSP (Program Structure Plan) - Parkhausverwaltung

## Übersicht

Der PSP beschreibt die hierarchische Struktur des Parkhausverwaltungssystems, die Aufteilung in Module und deren Beziehungen zueinander.

## Hauptstruktur (Level 0)

```text
PARKHAUSVERWALTUNG
├── 1.0 Benutzeroberfläche
├── 2.0 Geschäftslogik
├── 3.0 Datenzugriff
├── 4.0 Externe Schnittstellen
└── 5.0 Hilfsmodule
```

## Level 1: Hauptmodule

### 1.0 Benutzeroberfläche

```text
1.0 BENUTZEROBERFLÄCHE
├── 1.1 Web-Interface
├── 1.2 API-Schnittstelle
├── 1.3 Kassenautomat-Interface
└── 1.4 Schrankensteuerung-Interface
```

### 2.0 Geschäftslogik

```text
2.0 GESCHÄFTSLOGIK
├── 2.1 Parkhausverwaltung
├── 2.2 Ein-/Ausfahrt-Management
├── 2.3 Ticket-Management
├── 2.4 Zahlungsabwicklung
├── 2.5 Parkplatzverwaltung
└── 2.6 Schrankensteuerung
```

### 3.0 Datenzugriff

```text
3.0 DATENZUGRIFF
├── 3.1 Datenbankverbindung
├── 3.2 Modelle (Eloquent ORM)
├── 3.3 Repository-Pattern
└── 3.4 Datenbank-Migrationen
```

### 4.0 Externe Schnittstellen

```text
4.0 EXTERNE SCHNITTSTELLEN
├── 4.1 Zahlungsabwicklung
├── 4.2 Videoüberwachung
├── 4.3 Hardware-Steuerung
└── 4.4 Benachrichtigungssystem
```

### 5.0 Hilfsmodule

```text
5.0 HILFSMODULE
├── 5.1 Validierung
├── 5.2 Authentifizierung
├── 5.3 Logging
├── 5.4 Konfiguration
└── 5.5 Utilities
```

## Level 2: Detaillierte Modulstruktur

### 1.1 Web-Interface

```text
1.1 WEB-INTERFACE
├── 1.1.1 Parkhaus-Übersicht
├── 1.1.2 Ein-/Ausfahrt-Formulare
├── 1.1.3 Kassenautomat-Simulation
├── 1.1.4 Verwaltungsbereich
└── 1.1.5 Responsive Design
```

### 1.2 API-Schnittstelle

```text
1.2 API-SCHNITTSTELLE
├── 1.2.1 REST-Controller
├── 1.2.2 Request-Validierung
├── 1.2.3 Response-Formatierung
├── 1.2.4 API-Dokumentation
└── 1.2.5 Rate-Limiting
```

### 1.3 Kassenautomat-Interface

```text
1.3 KASSENAUTOMAT-INTERFACE
├── 1.3.1 Ticket-Eingabe
├── 1.3.2 Betragsberechnung
├── 1.3.3 Zahlungsabwicklung
├── 1.3.4 Quittungsdruck
└── 1.3.5 Fehlerbehandlung
```

### 1.4 Schrankensteuerung-Interface

```text
1.4 SCHRANKENSTEUERUNG-INTERFACE
├── 1.4.1 Einfahrt-Erkennung
├── 1.4.2 Ausfahrt-Validierung
├── 1.4.3 Schranken-Status
├── 1.4.4 Notfall-Funktionen
└── 1.4.5 Hardware-Kommunikation
```

### 2.1 Parkhausverwaltung

```text
2.1 PARKHAUSVERWALTUNG
├── 2.1.1 Parkhaus-Erstellung
├── 2.1.2 Parkplatz-Management
├── 2.1.3 Preiskonfiguration
├── 2.1.4 Kapazitätsplanung
└── 2.1.5 Statistiken
```

### 2.2 Ein-/Ausfahrt-Management

```text
2.2 EIN-/AUSFAHRT-MANAGEMENT
├── 2.2.1 Einfahrt-Protokollierung
├── 2.2.2 Ausfahrt-Validierung
├── 2.2.3 Kennzeichen-Erkennung
├── 2.2.4 Schranken-Steuerung
└── 2.2.5 Video-Überwachung
```

### 2.3 Ticket-Management

```text
2.3 TICKET-MANAGEMENT
├── 2.3.1 Ticket-Erstellung
├── 2.3.2 Ticket-Validierung
├── 2.3.3 Ticket-Status
├── 2.3.4 Ticket-Archivierung
└── 2.3.5 Ticket-Historie
```

### 2.4 Zahlungsabwicklung

```text
2.4 ZAHLUNGSABWICKLUNG
├── 2.4.1 Ticket-Eingabe
├── 2.4.2 Betragsberechnung
├── 2.4.3 Zahlungsmethoden
├── 2.4.4 Transaktionsprotokoll
└── 2.4.5 Rückerstattung
```

### 2.5 Parkplatzverwaltung

```text
2.5 PARKPLATZVERWALTUNG
├── 2.5.1 Parkplatz-Status
├── 2.5.2 Parkplatz-Zuweisung
├── 2.5.3 Ebene-Management
├── 2.5.4 Reservierungen
└── 2.5.5 Wartungsarbeiten
```

### 2.6 Schrankensteuerung

```text
2.6 SCHRANKENSTEUERUNG
├── 2.6.1 Einfahrt-Schranke
├── 2.6.2 Ausfahrt-Schranke
├── 2.6.3 Notfall-Funktionen
├── 2.6.4 Status-Monitoring
└── 2.6.5 Hardware-Kommunikation
```

## Level 3: Implementierungsdetails

### 2.4.1 Betragsberechnung

```text
2.4.1 BETRAGSBERECHNUNG
├── 2.4.1.1 Parkdauer-Berechnung
├── 2.4.1.2 Preisermittlung
├── 2.4.1.3 Rabatt-Berechnung
├── 2.4.1.4 Steuer-Berechnung
└── 2.4.1.5 Gesamtbetrag
```

### 2.4.2 Barzahlung

```text
2.4.2 BARZAHLUNG
├── 2.4.2.1 Geldeingabe
├── 2.4.2.2 Betragsprüfung
├── 2.4.2.3 Rückgeldberechnung
├── 2.4.2.4 Rückgeldausgabe
└── 2.4.2.5 Quittungsdruck
```

### 2.4.3 Kreditkartenzahlung

```text
2.4.3 KREDITKARTENZAHLUNG
├── 2.4.3.1 Karteneingabe
├── 2.4.3.2 PIN-Validierung
├── 2.4.3.3 Bank-Kommunikation
├── 2.4.3.4 Autorisierung
└── 2.4.3.5 Bestätigung
```

## Modul-Beziehungen

### Abhängigkeiten

```text
Benutzeroberfläche → Geschäftslogik
Geschäftslogik → Datenzugriff
Geschäftslogik → Externe Schnittstellen
Alle Module → Hilfsmodule
```

### Datenflüsse

```text
1. Web-Interface → API → Geschäftslogik → Datenzugriff
2. Kassenautomat → Geschäftslogik → Zahlungsabwicklung
3. Schrankensteuerung → Geschäftslogik → Hardware
4. Videoüberwachung → Kennzeichenerkennung → Geschäftslogik
```

### Schnittstellen

```text
- REST API zwischen Frontend und Backend
- Event-System für interne Kommunikation
- Datenbank-Transaktionen für Konsistenz
- Hardware-Protokolle für externe Geräte
```

## Implementierungsreihenfolge

### Phase 1: Grundfunktionalität

1. Datenbankstruktur
2. Grundlegende Modelle
3. Einfache API-Endpunkte
4. Basis-Web-Interface

### Phase 2: Kernfunktionen

1. Ein-/Ausfahrt-Management
2. Ticket-Verwaltung
3. Parkplatzverwaltung
4. Grundlegende Zahlungsabwicklung

### Phase 3: Erweiterte Funktionen

1. Kassenautomat-Simulation
2. Schrankensteuerung
3. Videoüberwachung
4. Erweiterte Berichte

### Phase 4: Optimierung

1. Performance-Optimierung
2. Sicherheitsverbesserungen
3. Benutzerfreundlichkeit
4. Monitoring und Logging

## Technische Spezifikationen

### Programmiersprachen

- **Backend**: PHP 8.1+ (Laravel 10)
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Datenbank**: SQLite (Entwicklung), MySQL (Produktion)

### Frameworks und Bibliotheken

- **Backend**: Laravel, Eloquent ORM
- **Frontend**: Tailwind CSS, Alpine.js
- **API**: Laravel Sanctum für Authentifizierung

### Architektur-Patterns

- **MVC**: Model-View-Controller
- **Repository Pattern**: Für Datenzugriff
- **Service Layer**: Für Geschäftslogik
- **Observer Pattern**: Für Event-Handling

### Datenbank-Design

- **ORM**: Eloquent mit Beziehungen
- **Migrationen**: Versionierte Datenbankschema-Änderungen
- **Seeding**: Testdaten für Entwicklung
- **Backup**: Automatische Backups

### API-Design

- **RESTful**: Standardisierte HTTP-Methoden
- **JSON**: Einheitliches Datenformat
- **Authentifizierung**: JWT-basierte Token
- **Rate Limiting**: Schutz vor Missbrauch

### Sicherheit

- **CSRF Protection**: Für alle Formulare
- **Authentication**: JWT-basierte Authentifizierung
- **Authorization**: Rollenbasierte Zugriffskontrolle
- **Input Validation**: Strenge Eingabevalidierung
- **SQL Injection**: Verhindert durch Eloquent ORM

## Qualitätssicherung

### Testing

- **Unit Tests**: Für alle Service-Klassen
- **Feature Tests**: Für API-Endpunkte
- **Browser Tests**: Für Web-Interface
- **Integration Tests**: Für Datenbank-Operationen

### Code-Qualität

- **PSR Standards**: PHP Coding Standards
- **Static Analysis**: PHPStan für Code-Qualität
- **Code Coverage**: Mindestens 80% Test-Coverage
- **Code Review**: Obligatorisch vor Merge

### Performance

- **Caching**: Redis für Session- und Daten-Caching
- **Database**: Query-Optimierung und Indizes
- **Frontend**: Asset-Minifizierung und CDN
- **Monitoring**: Performance-Metriken und Alerts

### Deployment

- **CI/CD**: Automatisierte Tests und Deployment
- **Environment**: Separate Umgebungen (Dev, Staging, Prod)
- **Monitoring**: Logs, Metriken und Alerts
- **Backup**: Automatische Datenbank-Backups
