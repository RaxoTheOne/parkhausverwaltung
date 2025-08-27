# Relationales Datenmodell - Parkhausverwaltung

## Normalisierte Tabellen

### 1. Parkhaeuser (1NF, 2NF, 3NF)

```sql
Parkhaeuser (id, name, anzahl_ebenen, parkplaetze_pro_ebene, preis_pro_stunde, created_at, updated_at)
```

- **Primärschlüssel**: id
- **Funktionale Abhängigkeiten**: id → {name, anzahl_ebenen, parkplaetze_pro_ebene, preis_pro_stunde, created_at, updated_at}
- **Normalisierung**: 3NF (keine transitiven Abhängigkeiten)

### 2. Parkplaetze (1NF, 2NF, 3NF)

```sql
Parkplaetze (id, parkhaus_id, ebene, parkplatz_nummer, status, created_at, updated_at)
```

- **Primärschlüssel**: id
- **Fremdschlüssel**: parkhaus_id → Parkhaeuser.id
- **Unique Constraint**: (parkhaus_id, ebene, parkplatz_nummer)
- **Funktionale Abhängigkeiten**:
  - id → {parkhaus_id, ebene, parkplatz_nummer, status, created_at, updated_at}
  - (parkhaus_id, ebene, parkplatz_nummer) → {id, status, created_at, updated_at}
- **Normalisierung**: 3NF

### 3. Fahrzeuge (1NF, 2NF, 3NF)

```sql
Fahrzeuge (id, kennzeichen, marke, modell, farbe, created_at, updated_at)
```

- **Primärschlüssel**: id
- **Unique Constraint**: kennzeichen
- **Funktionale Abhängigkeiten**:
  - id → {kennzeichen, marke, modell, farbe, created_at, updated_at}
  - kennzeichen → {id, marke, modell, farbe, created_at, updated_at}
- **Normalisierung**: 3NF

### 4. Tickets (1NF, 2NF, 3NF)

```sql
Tickets (id, fahrzeug_id, parkhaus_id, ticket_typ, einfahrts_zeit, ausfahrts_zeit, gezahlter_betrag, status, gueltig_bis, created_at, updated_at)
```

- **Primärschlüssel**: id
- **Fremdschlüssel**:
  - fahrzeug_id → Fahrzeuge.id
  - parkhaus_id → Parkhaeuser.id
- **Funktionale Abhängigkeiten**: id → {fahrzeug_id, parkhaus_id, ticket_typ, einfahrts_zeit, ausfahrts_zeit, gezahlter_betrag, status, gueltig_bis, created_at, updated_at}
- **Normalisierung**: 3NF

### 5. Zahlungen (1NF, 2NF, 3NF)

```sql
Zahlungen (id, ticket_id, zahlungsart, betrag, rueckgeld, kreditkarten_nummer, zahlungs_zeit, status, created_at, updated_at)
```

- **Primärschlüssel**: id
- **Fremdschlüssel**: ticket_id → Tickets.id
- **Funktionale Abhängigkeiten**: id → {ticket_id, zahlungsart, betrag, rueckgeld, kreditkarten_nummer, zahlungs_zeit, status, created_at, updated_at}
- **Normalisierung**: 3NF

### 6. EinAusfahrten (1NF, 2NF, 3NF)

```sql
EinAusfahrten (id, parkhaus_id, fahrzeug_id, richtung, zeitpunkt, kennzeichen_bild_pfad, schranke_geoeffnet, bemerkungen, created_at, updated_at)
```

- **Primärschlüssel**: id
- **Fremdschlüssel**:
  - parkhaus_id → Parkhaeuser.id
  - fahrzeug_id → Fahrzeuge.id
- **Funktionale Abhängigkeiten**: id → {parkhaus_id, fahrzeug_id, richtung, zeitpunkt, kennzeichen_bild_pfad, schranke_geoeffnet, bemerkungen, created_at, updated_at}
- **Normalisierung**: 3NF

## Indizes

### Primärschlüssel-Indizes

- Alle Tabellen haben automatische Primärschlüssel-Indizes auf `id`

### Fremdschlüssel-Indizes

- `parkplaetze.parkhaus_id` → `parkhaeuser.id`
- `tickets.fahrzeug_id` → `fahrzeuge.id`
- `tickets.parkhaus_id` → `parkhaeuser.id`
- `zahlungen.ticket_id` → `tickets.id`
- `ein_ausfahrten.parkhaus_id` → `parkhaeuser.id`
- `ein_ausfahrten.fahrzeug_id` → `fahrzeuge.id`

### Unique-Indizes

- `fahrzeuge.kennzeichen`
- `parkplaetze.(parkhaus_id, ebene, parkplatz_nummer)`

### Performance-Indizes (empfohlen)

- `tickets.status` (für aktive Tickets)
- `tickets.einfahrts_zeit` (für Zeitberechnungen)
- `ein_ausfahrten.zeitpunkt` (für Protokollierung)
- `zahlungen.zahlungs_zeit` (für Buchhaltung)

## Referentielle Integrität

### CASCADE DELETE-Regeln

- Wenn ein Parkhaus gelöscht wird → alle zugehörigen Parkplätze, Tickets und EinAusfahrten werden gelöscht
- Wenn ein Fahrzeug gelöscht wird → alle zugehörigen Tickets und EinAusfahrten werden gelöscht
- Wenn ein Ticket gelöscht wird → alle zugehörigen Zahlungen werden gelöscht

### Constraints

```sql
-- Beispiel für Fremdschlüssel-Constraint
ALTER TABLE parkplaetze 
ADD CONSTRAINT fk_parkplaetze_parkhaus 
FOREIGN KEY (parkhaus_id) REFERENCES parkhaeuser(id) 
ON DELETE CASCADE;

-- Beispiel für Unique-Constraint
ALTER TABLE parkplaetze 
ADD CONSTRAINT uk_parkplatz_position 
UNIQUE (parkhaus_id, ebene, parkplatz_nummer);
```

## Denormalisierung (falls erforderlich)

### Für Performance-Optimierung könnten folgende Views erstellt werden

```sql
-- View für freie Parkplätze pro Parkhaus
CREATE VIEW freie_parkplaetze AS
SELECT 
    p.id,
    p.parkhaus_id,
    ph.name as parkhaus_name,
    p.ebene,
    p.parkplatz_nummer,
    p.status
FROM parkplaetze p
JOIN parkhaeuser ph ON p.parkhaus_id = ph.id
WHERE p.status = 'frei';

-- View für aktive Tickets mit Fahrzeug- und Parkhaus-Informationen
CREATE VIEW aktive_tickets AS
SELECT 
    t.id,
    t.ticket_typ,
    t.einfahrts_zeit,
    t.gezahlter_betrag,
    t.status,
    f.kennzeichen,
    f.marke,
    f.modell,
    ph.name as parkhaus_name,
    ph.preis_pro_stunde
FROM tickets t
JOIN fahrzeuge f ON t.fahrzeug_id = f.id
JOIN parkhaeuser ph ON t.parkhaus_id = ph.id
WHERE t.status = 'aktiv';
```

## Datenbankoptimierung

### Partitionierung

- **Tickets**: Nach `einfahrts_zeit` (Jahr/Monat)
- **EinAusfahrten**: Nach `zeitpunkt` (Jahr/Monat)
- **Zahlungen**: Nach `zahlungs_zeit` (Jahr/Monat)

### Archiving-Strategie

- Abgeschlossene Tickets älter als 1 Jahr in Archive-Tabelle
- EinAusfahrten älter als 2 Jahre in Archive-Tabelle
- Zahlungen älter als 7 Jahre (gesetzliche Aufbewahrungspflicht) in Archive-Tabelle
