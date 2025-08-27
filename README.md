# 🏢 Parkhausverwaltung

Ein modernes Parkhausverwaltungssystem entwickelt mit Laravel, das die digitalisierte Verwaltung und den Betrieb von Parkhäusern ermöglicht.

## 🚀 Features

- **Parkhausverwaltung**: Erstellung und Verwaltung beliebig vieler Parkhäuser
- **Ein- und Ausfahrt**: Videoüberwachte Ein-/Ausfahrt mit automatischer Schrankensteuerung
- **Kassenautomat**: Vollständige Zahlungsabwicklung (Bar und Kreditkarte)
- **Ticketverwaltung**: Stunden- und Dauertickets mit automatischer Gebührenberechnung
- **Echtzeit-Überwachung**: Verfügbare und belegte Parkplätze in Echtzeit

## 🛠️ Technologie

- **Backend**: Laravel 10
- **Frontend**: HTML, JavaScript, Tailwind CSS
- **Datenbank**: SQLite (MySQL/MariaDB kompatibel)
- **API**: RESTful API mit JSON-Responses

## 📋 Voraussetzungen

- PHP 8.1 oder höher
- Composer
- SQLite oder MySQL/MariaDB

## 🚀 Installation

1. **Repository klonen**

   ```bash
   git clone [repository-url]
   cd parkhausverwaltung
   ```

2. **Abhängigkeiten installieren**

   ```bash
   composer install
   ```

3. **Umgebungsvariablen konfigurieren**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Datenbank einrichten**

   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Anwendung starten**

   ```bash
   php artisan serve
   ```

## 📖 Verwendung

Öffnen Sie `http://localhost:8000` in Ihrem Browser.

### Grundfunktionen

- **Parkhaus erstellen**: Konfigurieren Sie Ebenen, Parkplätze und Preise
- **Einfahrt simulieren**: Fahrzeuge mit Kennzeichen einparken
- **Zahlung verarbeiten**: Am Kassenautomaten bezahlen
- **Ausfahrt simulieren**: Fahrzeuge ausparken nach Zahlung

## 📚 Detaillierte Dokumentation

Für eine vollständige Anleitung und API-Dokumentation siehe: [README_PARKHAUS.md](README_PARKHAUS.md)

## 🔧 Entwicklung

- **Migrationen**: `php artisan migrate`
- **Seeder ausführen**: `php artisan db:seed`
- **Tests ausführen**: `php artisan test`

## 📄 Lizenz

Dieses Projekt ist eine Testversion für Bildungszwecke.

## 🤝 Support

Bei Fragen oder Problemen wenden Sie sich an das Entwicklungsteam.

---

## Entwickelt mit ❤️ und Laravel
