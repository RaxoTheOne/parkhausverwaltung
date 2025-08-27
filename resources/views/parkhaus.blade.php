<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkhausverwaltung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8 text-blue-600">Parkhausverwaltung</h1>

        <!-- Neues Parkhaus erstellen -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Neues Parkhaus erstellen</h2>
            <form id="parkhausForm" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" id="name" placeholder="Name" class="border rounded px-3 py-2" required>
                <input type="number" id="anzahl_ebenen" placeholder="Anzahl Ebenen" class="border rounded px-3 py-2" min="1" max="10" required>
                <input type="number" id="parkplaetze_pro_ebene" placeholder="Parkplätze pro Ebene" class="border rounded px-3 py-2" min="1" max="100" required>
                <input type="number" id="preis_pro_stunde" placeholder="Preis pro Stunde" class="border rounded px-3 py-2" step="0.01" min="0" required>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 md:col-span-4">
                    Parkhaus erstellen
                </button>
            </form>
        </div>

        <!-- Ein- und Ausfahrt -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Einfahrt -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-green-600">Einfahrt</h2>
                <form id="einfahrtForm" class="space-y-4">
                    <select id="einfahrt_parkhaus" class="w-full border rounded px-3 py-2" required>
                        <option value="">Parkhaus auswählen</option>
                    </select>
                    <input type="text" id="einfahrt_kennzeichen" placeholder="Kennzeichen" class="w-full border rounded px-3 py-2" required>
                    <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Einfahrt simulieren
                    </button>
                </form>
            </div>

            <!-- Ausfahrt -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-red-600">Ausfahrt</h2>
                <form id="ausfahrtForm" class="space-y-4">
                    <select id="ausfahrt_parkhaus" class="w-full border rounded px-3 py-2" required>
                        <option value="">Parkhaus auswählen</option>
                    </select>
                    <input type="text" id="ausfahrt_kennzeichen" placeholder="Kennzeichen" class="w-full border rounded px-3 py-2" required>
                    <button type="submit" class="w-full bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Ausfahrt simulieren
                    </button>
                </form>
            </div>
        </div>

        <!-- Kassenautomat -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4 text-purple-600">Kassenautomat</h2>
            <form id="kassenautomatForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <select id="kassenautomat_parkhaus" class="border rounded px-3 py-2" required>
                    <option value="">Parkhaus auswählen</option>
                </select>
                <input type="text" id="kassenautomat_kennzeichen" placeholder="Kennzeichen" class="border rounded px-3 py-2" required>
                <button type="button" onclick="zeigeBetrag()" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">
                    Betrag anzeigen
                </button>
            </form>
            <div id="betragAnzeige" class="mt-4 p-4 bg-gray-100 rounded hidden">
                <h3 class="font-semibold mb-2">Zu zahlender Betrag:</h3>
                <div id="betragDetails"></div>
                <div class="mt-4 space-y-2">
                    <button onclick="barzahlung()" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mr-2">
                        Bar zahlen
                    </button>
                    <button onclick="kreditkartenzahlung()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Kreditkarte
                    </button>
                </div>
            </div>
        </div>

        <!-- Parkhausübersicht -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Parkhausübersicht</h2>
            <div id="parkhausListe" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Wird dynamisch gefüllt -->
            </div>
        </div>
    </div>

    <script>
        let currentTicket = null;
        let currentBetrag = 0;

        // Lade Parkhäuser beim Start
        document.addEventListener('DOMContentLoaded', function() {
            ladeParkhaeuser();
        });

        // Parkhaus erstellen
        document.getElementById('parkhausForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = {
                name: document.getElementById('name').value,
                anzahl_ebenen: parseInt(document.getElementById('anzahl_ebenen').value),
                parkplaetze_pro_ebene: parseInt(document.getElementById('parkplaetze_pro_ebene').value),
                preis_pro_stunde: parseFloat(document.getElementById('preis_pro_stunde').value)
            };

            try {
                const response = await axios.post('/api/parkhaus', formData);
                alert('Parkhaus erfolgreich erstellt!');
                document.getElementById('parkhausForm').reset();
                ladeParkhaeuser();
            } catch (error) {
                alert('Fehler beim Erstellen des Parkhauses: ' + error.response.data.message);
            }
        });

        // Einfahrt simulieren
        document.getElementById('einfahrtForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = {
                parkhaus_id: document.getElementById('einfahrt_parkhaus').value,
                kennzeichen: document.getElementById('einfahrt_kennzeichen').value
            };

            try {
                const response = await axios.post('/api/ein-ausfahrt/einfahrt', formData);
                alert('Einfahrt erfolgreich! Ticket-ID: ' + response.data.ticket_id);
                document.getElementById('einfahrtForm').reset();
                ladeParkhaeuser();
            } catch (error) {
                alert('Fehler bei der Einfahrt: ' + error.response.data.error);
            }
        });

        // Ausfahrt simulieren
        document.getElementById('ausfahrtForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = {
                parkhaus_id: document.getElementById('ausfahrt_parkhaus').value,
                kennzeichen: document.getElementById('ausfahrt_kennzeichen').value
            };

            try {
                const response = await axios.post('/api/ein-ausfahrt/ausfahrt', formData);
                alert('Ausfahrt erfolgreich!');
                document.getElementById('ausfahrtForm').reset();
                ladeParkhaeuser();
            } catch (error) {
                alert('Fehler bei der Ausfahrt: ' + error.response.data.error);
            }
        });

        // Lade alle Parkhäuser
        async function ladeParkhaeuser() {
            try {
                const response = await axios.get('/api/parkhaus');
                const parkhaeuser = response.data;

                // Fülle Dropdowns
                const parkhausOptions = parkhaeuser.map(ph =>
                    `<option value="${ph.id}">${ph.name}</option>`
                ).join('');

                document.getElementById('einfahrt_parkhaus').innerHTML = '<option value="">Parkhaus auswählen</option>' + parkhausOptions;
                document.getElementById('ausfahrt_parkhaus').innerHTML = '<option value="">Parkhaus auswählen</option>' + parkhausOptions;
                document.getElementById('kassenautomat_parkhaus').innerHTML = '<option value="">Parkhaus auswählen</option>' + parkhausOptions;

                // Fülle Parkhausübersicht
                const parkhausListe = document.getElementById('parkhausListe');
                parkhausListe.innerHTML = parkhaeuser.map(ph => `
                    <div class="border rounded p-4">
                        <h3 class="font-semibold text-lg">${ph.name}</h3>
                        <p class="text-gray-600">${ph.anzahl_ebenen} Ebenen × ${ph.parkplaetze_pro_ebene} Plätze</p>
                        <p class="text-gray-600">Preis: €${ph.preis_pro_stunde}/h</p>
                        <div class="mt-2">
                            <span class="text-green-600 font-semibold">${ph.freie_plaetze} frei</span>
                            <span class="text-red-600 font-semibold ml-2">${ph.belegte_plaetze} besetzt</span>
                        </div>
                    </div>
                `).join('');

            } catch (error) {
                console.error('Fehler beim Laden der Parkhäuser:', error);
            }
        }

        // Zeige zu zahlenden Betrag
        async function zeigeBetrag() {
            const parkhausId = document.getElementById('kassenautomat_parkhaus').value;
            const kennzeichen = document.getElementById('kassenautomat_kennzeichen').value;

            if (!parkhausId || !kennzeichen) {
                alert('Bitte Parkhaus und Kennzeichen auswählen');
                return;
            }

            try {
                const response = await axios.post('/api/kassenautomat/zeige-betrag', {
                    parkhaus_id: parkhausId,
                    kennzeichen: kennzeichen
                });

                currentTicket = response.data.ticket_id;
                currentBetrag = response.data.zu_zahlender_betrag;

                document.getElementById('betragDetails').innerHTML = `
                    <p><strong>Kennzeichen:</strong> ${response.data.kennzeichen}</p>
                    <p><strong>Einfahrtszeit:</strong> ${new Date(response.data.einfahrts_zeit).toLocaleString()}</p>
                    <p><strong>Parkdauer:</strong> ${response.data.parkdauer_stunden} Stunden</p>
                    <p><strong>Preis pro Stunde:</strong> €${response.data.preis_pro_stunde}</p>
                    <p class="text-xl font-bold text-red-600">Zu zahlen: €${response.data.zu_zahlender_betrag}</p>
                `;

                document.getElementById('betragAnzeige').classList.remove('hidden');
            } catch (error) {
                alert('Fehler beim Abrufen des Betrags: ' + error.response.data.error);
            }
        }

        // Barzahlung
        async function barzahlung() {
            if (!currentTicket) {
                alert('Bitte zuerst einen Betrag anzeigen lassen');
                return;
            }

            const betrag = prompt(`Bitte geben Sie den gezahlten Betrag ein (Mindestbetrag: €${currentBetrag}):`);
            if (!betrag || parseFloat(betrag) < currentBetrag) {
                alert('Ungültiger Betrag');
                return;
            }

            try {
                const response = await axios.post('/api/kassenautomat/barzahlung', {
                    ticket_id: currentTicket,
                    gezahlter_betrag: parseFloat(betrag)
                });

                alert(`Zahlung erfolgreich! Rückgeld: €${response.data.rueckgeld}`);
                document.getElementById('betragAnzeige').classList.add('hidden');
                currentTicket = null;
                currentBetrag = 0;
            } catch (error) {
                alert('Fehler bei der Barzahlung: ' + error.response.data.error);
            }
        }

        // Kreditkartenzahlung
        async function kreditkartenzahlung() {
            if (!currentTicket) {
                alert('Bitte zuerst einen Betrag anzeigen lassen');
                return;
            }

            const kreditkartenNummer = prompt('Bitte geben Sie die Kreditkartennummer ein:');
            if (!kreditkartenNummer) {
                alert('Kreditkartennummer erforderlich');
                return;
            }

            try {
                const response = await axios.post('/api/kassenautomat/kreditkartenzahlung', {
                    ticket_id: currentTicket,
                    kreditkarten_nummer: kreditkartenNummer,
                    gezahlter_betrag: currentBetrag
                });

                alert('Kreditkartenzahlung erfolgreich!');
                document.getElementById('betragAnzeige').classList.add('hidden');
                currentTicket = null;
                currentBetrag = 0;
            } catch (error) {
                alert('Fehler bei der Kreditkartenzahlung: ' + error.response.data.error);
            }
        }
    </script>
</body>
</html>
