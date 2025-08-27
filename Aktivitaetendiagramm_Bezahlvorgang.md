# Aktivitätendiagramm - Bezahlvorgang am Kassenautomaten

## Übersicht

Das Aktivitätendiagramm beschreibt den vollständigen Ablauf des Bezahlvorgangs am Kassenautomaten im Parkhausverwaltungssystem.

## Hauptablauf

### Startpunkt

- **Start**: Autofahrer nähert sich dem Kassenautomaten

### 1. Ticket-Eingabe

- **Aktivität**: Ticket in den Automaten einführen
- **Entscheidung**: Ist das Ticket gültig?
  - **Ja**: Weiter zu Schritt 2
  - **Nein**: Fehlermeldung anzeigen → **Ende**

### 2. Betragsberechnung

- **Aktivität**: System berechnet Parkgebühren
- **Berechnung**: Parkdauer × Preis pro Stunde
- **Aktivität**: Betrag auf Display anzeigen
- **Aktivität**: Zahlungsoptionen anbieten (Bar/Kreditkarte)

### 3. Zahlungsart-Auswahl

- **Entscheidung**: Welche Zahlungsart wird gewählt?
  - **Bar**: Weiter zu "Barzahlung"
  - **Kreditkarte**: Weiter zu "Kreditkartenzahlung"

## Barzahlung-Pfad

### 3a. Barzahlung

- **Aktivität**: Automat fordert Bargeld ein
- **Aktivität**: Autofahrer wirft Geld ein
- **Entscheidung**: Ist der eingelegte Betrag ausreichend?
  - **Ja**: Weiter zu "Rückgeld berechnen"
  - **Nein**: Weiter zu "Weiteres Geld einfordern"

### 3a.1. Weiteres Geld einfordern

- **Aktivität**: Fehlbetrag anzeigen
- **Aktivität**: Automat fordert weiteren Betrag ein
- **Entscheidung**: Ist der Gesamtbetrag ausreichend?
  - **Ja**: Weiter zu "Rückgeld berechnen"
  - **Nein**: Schleife zu "Weiteres Geld einfordern"

### 3a.2. Rückgeld berechnen

- **Aktivität**: System berechnet Rückgeld
- **Formel**: Rückgeld = Eingelegter Betrag - Zu zahlender Betrag
- **Aktivität**: Rückgeld ausgeben
- **Aktivität**: Quittung drucken

## Kreditkartenzahlung-Pfad

### 3b. Kreditkartenzahlung

- **Aktivität**: Automat fordert Kreditkarte ein
- **Aktivität**: Autofahrer steckt Kreditkarte ein
- **Entscheidung**: Ist die Kreditkarte gültig?
  - **Ja**: Weiter zu "PIN-Eingabe"
  - **Nein**: Fehlermeldung anzeigen → **Ende**

### 3b.1. PIN-Eingabe

- **Aktivität**: Automat fordert PIN ein
- **Aktivität**: Autofahrer gibt PIN ein
- **Entscheidung**: Ist die PIN korrekt?
  - **Ja**: Weiter zu "Zahlung autorisieren"
  - **Nein**: Fehlermeldung anzeigen → **Ende**

### 3b.2. Zahlung autorisieren

- **Aktivität**: System sendet Zahlungsanfrage an Bank
- **Entscheidung**: Ist die Zahlung autorisiert?
  - **Ja**: Weiter zu "Quittung drucken"
  - **Nein**: Fehlermeldung anzeigen → **Ende**

## Gemeinsamer Abschluss

### 4. Quittung drucken

- **Aktivität**: System druckt Quittung
- **Inhalt**:
  - Parkhaus-Name
  - Kennzeichen
  - Einfahrtszeit
  - Ausfahrtszeit
  - Parkdauer
  - Zu zahlender Betrag
  - Gezahlter Betrag
  - Rückgeld (bei Barzahlung)
  - Datum/Uhrzeit
  - Transaktions-ID

### 5. Ticket freigeben

- **Aktivität**: System markiert Ticket als bezahlt
- **Datenbank**: Update `tickets.status` = 'abgeschlossen'
- **Datenbank**: Update `tickets.gezahlter_betrag`
- **Datenbank**: Insert in `zahlungen` Tabelle

### 6. Zahlungsbestätigung

- **Aktivität**: "Zahlung erfolgreich" anzeigen
- **Aktivität**: Grünes Licht leuchtet auf
- **Aktivität**: Schranke öffnet sich automatisch

## Fehlerbehandlung

### Fehler bei Barzahlung

- **Fehler**: Automat kann Rückgeld nicht ausgeben
- **Aktivität**: Fehlermeldung anzeigen
- **Aktivität**: Parkhausverwalter benachrichtigen
- **Aktivität**: Ticket bleibt aktiv

### Fehler bei Kreditkartenzahlung

- **Fehler**: Karte wird nicht akzeptiert
- **Aktivität**: Karte ausgeben
- **Aktivität**: Alternative Zahlungsarten anbieten
- **Aktivität**: Bei mehreren Fehlern: Ticket bleibt aktiv

### Systemfehler

- **Fehler**: Automat funktioniert nicht
- **Aktivität**: Notfall-Button aktivieren
- **Aktivität**: Parkhausverwalter benachrichtigen
- **Aktivität**: Manuelle Schrankenöffnung möglich

## Zeitliche Abläufe

### Normale Abwicklung

- **Ziel**: Kompletter Bezahlvorgang in < 2 Minuten
- **Barzahlung**: 30-60 Sekunden
- **Kreditkartenzahlung**: 45-90 Sekunden

### Timeout-Behandlung

- **Timeout**: Keine Aktivität für 3 Minuten
- **Aktivität**: Automat geht in Standby-Modus
- **Aktivität**: Ticket wird automatisch ausgeworfen
- **Aktivität**: "Bitte Vorgang wiederholen" anzeigen

## Parallel-Aktivitäten

### Gleichzeitig ablaufende Prozesse

1. **Zahlungsverarbeitung** (Hauptprozess)
2. **Ticket-Validierung** (läuft parallel)
3. **Schrankensteuerung** (wird vorbereitet)
4. **Protokollierung** (läuft im Hintergrund)

### Synchronisationspunkte

- **Punkt 1**: Nach erfolgreicher Zahlung
- **Punkt 2**: Vor Schrankenöffnung
- **Punkt 3**: Nach Datenbank-Update

## Ende des Prozesses

### Erfolgreicher Abschluss

- **Ende**: Autofahrer verlässt Parkhaus
- **Status**: Ticket ist bezahlt und abgeschlossen
- **Parkplatz**: Wird automatisch freigegeben

### Fehlgeschlagener Abschluss

- **Ende**: Prozess wird abgebrochen
- **Status**: Ticket bleibt aktiv
- **Nächster Schritt**: Autofahrer muss Vorgang wiederholen
