# Entscheidungstabelle - Schrankensteuerung bei der Ausfahrt eines PKW

## Übersicht

Diese Entscheidungstabelle definiert alle möglichen Kombinationen von Bedingungen und die entsprechenden Aktionen für die Schrankensteuerung bei der Ausfahrt eines PKW aus dem Parkhaus.

## Bedingungen (Conditions)

### C1: Ticket vorhanden

- **Ja**: Fahrzeug hat ein gültiges Ticket
- **Nein**: Kein Ticket vorhanden

### C2: Ticket bezahlt

- **Ja**: Ticket ist vollständig bezahlt
- **Nein**: Ticket ist nicht bezahlt oder nur teilweise bezahlt

### C3: Ticket gültig

- **Ja**: Ticket ist nicht abgelaufen (bei Dauertickets)
- **Nein**: Ticket ist abgelaufen

### C4: Fahrzeug erkannt

- **Ja**: Kennzeichen wurde erfolgreich erkannt
- **Nein**: Kennzeichen konnte nicht erkannt werden

### C5: Kennzeichen stimmt überein

- **Ja**: Erkanntes Kennzeichen stimmt mit Ticket überein
- **Nein**: Kennzeichen stimmt nicht überein

### C6: Parkplatz freigegeben

- **Ja**: Parkplatz wurde als frei markiert
- **Nein**: Parkplatz ist noch als besetzt markiert

### C7: Zahlung erfolgreich

- **Ja**: Letzte Zahlung war erfolgreich
- **Nein**: Letzte Zahlung war nicht erfolgreich

### C8: System funktionsfähig

- **Ja**: Alle Systemkomponenten funktionieren
- **Nein**: Mindestens eine Komponente hat einen Fehler

## Aktionen (Actions)

### A1: Schranke öffnen

- **Beschreibung**: Schranke wird automatisch geöffnet
- **Priorität**: Höchste Priorität

### A2: Schranke geschlossen halten

- **Beschreibung**: Schranke bleibt geschlossen
- **Priorität**: Standard-Verhalten

### A3: Warnung anzeigen

- **Beschreibung**: Rotes Warnlicht und akustisches Signal
- **Priorität**: Mittlere Priorität

### A4: Parkhausverwalter benachrichtigen

- **Beschreibung**: Automatische Benachrichtigung an den Verwalter
- **Priorität**: Niedrige Priorität

### A5: Ticket einbehalten

- **Beschreibung**: Ticket wird nicht zurückgegeben
- **Priorität**: Niedrige Priorität

### A6: Fehlermeldung anzeigen

- **Beschreibung**: Spezifische Fehlermeldung auf Display
- **Priorität**: Mittlere Priorität

### A7: Notfall-Button aktivieren

- **Beschreibung**: Manueller Notfall-Button wird aktiviert
- **Priorität**: Höchste Priorität bei Systemfehlern

## Vollständige Entscheidungstabelle

| Regel | C1 | C2 | C3 | C4 | C5 | C6 | C7 | C8 | Aktionen | Begründung |
|-------|----|----|----|----|----|----|----|----|----------|------------|
| 1 | Ja | Ja | Ja | Ja | Ja | Ja | Ja | Ja | A1 | Normalfall - alle Bedingungen erfüllt |
| 2 | Ja | Ja | Ja | Ja | Ja | Ja | Ja | Nein | A2, A7 | Systemfehler - Schranke bleibt zu, Notfall-Button aktiv |
| 3 | Ja | Ja | Ja | Ja | Ja | Ja | Nein | Ja | A2, A3, A6 | Zahlung nicht erfolgreich - Schranke bleibt zu |
| 4 | Ja | Ja | Ja | Ja | Ja | Nein | Ja | Ja | A2, A3, A6 | Parkplatz nicht freigegeben - Schranke bleibt zu |
| 5 | Ja | Ja | Ja | Ja | Nein | Ja | Ja | Ja | A2, A3, A4, A6 | Kennzeichen stimmt nicht überein - Verdacht auf Diebstahl |
| 6 | Ja | Ja | Ja | Nein | - | Ja | Ja | Ja | A2, A3, A6 | Fahrzeug nicht erkannt - manuelle Überprüfung erforderlich |
| 7 | Ja | Ja | Nein | Ja | Ja | Ja | Ja | Ja | A2, A3, A6 | Ticket abgelaufen - Schranke bleibt zu |
| 8 | Ja | Nein | Ja | Ja | Ja | Ja | Ja | Ja | A2, A3, A6 | Ticket nicht bezahlt - Schranke bleibt zu |
| 9 | Nein | - | - | Ja | - | - | - | Ja | A2, A3, A4, A5, A6 | Kein Ticket - möglicherweise unbefugter Zugang |
| 10 | Ja | Ja | Ja | Ja | Ja | Ja | Nein | Nein | A2, A7 | Systemfehler + Zahlungsproblem - Notfall-Button aktiv |
| 11 | Ja | Nein | Ja | Ja | Ja | Ja | Ja | Nein | A2, A7 | Systemfehler + unbezahltes Ticket - Notfall-Button aktiv |
| 12 | Nein | - | - | Ja | - | - | - | Nein | A2, A7 | Systemfehler + kein Ticket - Notfall-Button aktiv |
| 13 | Ja | Ja | Ja | Nein | - | Ja | Ja | Nein | A2, A7 | Systemfehler + Fahrzeug nicht erkannt - Notfall-Button aktiv |
| 14 | Ja | Ja | Nein | Ja | Ja | Ja | Ja | Nein | A2, A7 | Systemfehler + abgelaufenes Ticket - Notfall-Button aktiv |
| 15 | Ja | Nein | Nein | Ja | Ja | Ja | Ja | Ja | A2, A3, A6 | Ticket abgelaufen und nicht bezahlt - Schranke bleibt zu |

## Spezielle Regeln

### Regel 16: Wartungsmodus

- **Bedingungen**: Alle C1-C8 = Nein
- **Aktionen**: A2, A7
- **Begründung**: System ist im Wartungsmodus

### Regel 17: Notfall-Evakuierung

- **Bedingungen**: Notfall-Signal aktiv
- **Aktionen**: A1 (alle Schranken öffnen)
- **Begründung**: Sicherheit hat höchste Priorität

### Regel 18: VIP-Fahrzeuge

- **Bedingungen**: C1=Ja, C2=Ja, C3=Ja, VIP-Status=Ja
- **Aktionen**: A1 (auch bei anderen Problemen)
- **Begründung**: VIP-Fahrzeuge haben Vorrang

## Implementierungslogik

### Prioritätsreihenfolge der Aktionen

1. **A7 (Notfall-Button)**: Bei Systemfehlern
2. **A1 (Schranke öffnen)**: Bei allen erfüllten Bedingungen
3. **A2 (Schranke geschlossen halten)**: Standard-Verhalten
4. **A3 (Warnung)**: Bei Problemen
5. **A6 (Fehlermeldung)**: Spezifische Informationen
6. **A4 (Verwalter benachrichtigen)**: Bei verdächtigen Vorgängen
7. **A5 (Ticket einbehalten)**: Bei unbefugtem Zugang

### Logische Operatoren

- **UND (&&)**: Alle Bedingungen müssen erfüllt sein für A1
- **ODER (||)**: Mindestens eine Bedingung für A2
- **XOR**: Entweder C4 ODER C5 (nicht beide)

### Timeout-Behandlung

- **Kennzeichenerkennung**: 10 Sekunden
- **Zahlungsprüfung**: 5 Sekunden
- **Systemprüfung**: 3 Sekunden
- **Gesamt-Timeout**: 30 Sekunden

## Fehlerbehandlung

### Retry-Mechanismus

- **Kennzeichenerkennung**: 3 Versuche
- **Zahlungsprüfung**: 2 Versuche
- **Systemprüfung**: 1 Versuch

### Eskalation

1. **Versuch 1**: Automatische Wiederholung
2. **Versuch 2**: Warnung anzeigen
3. **Versuch 3**: Verwalter benachrichtigen
4. **Nach 3 Versuchen**: Notfall-Button aktivieren

## Monitoring und Logging

### Zu protokollierende Ereignisse

- Alle Schrankenöffnungen
- Alle verweigerten Ausfahrten
- Alle Systemfehler
- Alle Kennzeichen-Erkennungen
- Alle Zahlungsprüfungen

### Metriken

- Durchschnittliche Ausfahrtszeit
- Anzahl verweigerter Ausfahrten
- Systemverfügbarkeit
- Fehlerrate bei Kennzeichenerkennung
- Zahlungsfehlerrate
