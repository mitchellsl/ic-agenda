# IC Agenda Plugin 

De **IC Agenda Plugin** is een krachtige plugin die speciaal is ontworpen om evenementen van IT Circle Nederland weer te geven op je WordPress-site. Met deze plugin kun je evenementen filteren op basis van maand en jaar, en kun je gedetailleerde informatie bekijken via modals. Daarnaast biedt het de mogelijkheid om een formulier te openen wanneer een evenement wordt aangeklikt.

## Kenmerken

- **Evenementen weergave**: Toon evenementen op basis van aangepaste velden (zoals datum, tijd, details).
- **Maand- en jaarfilters**: Gebruikers kunnen evenementen filteren op maand en jaar.
- **Modale vensters**: Klik op een evenement om meer details weer te geven in een modaal venster.
- **Formulierintegratie**: Toon een formulier in de modal voor inschrijvingen of verdere acties.
- **Volledig aanpasbaar**: De plugin werkt met Elementor, zodat je gemakkelijk de opmaak van evenementen en modals kunt aanpassen.

## Installatie

### Stap 1: Plugin installeren

1. **Download de plugin** van je bron.
2. **Upload de plugin naar je WordPress-installatie**:
    - Ga naar het WordPress dashboard.
    - Klik op **Plugins** > **Nieuwe plugin**.
    - Klik op **Plugin uploaden**.
    - Selecteer het gedownloade zip-bestand van de plugin en klik op **Nu installeren**.
3. **Activeer de plugin**: Na de installatie, klik je op **Activeren**.

### Stap 2: Gebruik de plugin

1. Na het activeren van de plugin kun je een **shortcode** gebruiken om de evenementen op je pagina weer te geven. Gebruik de volgende shortcode: **[ ic_agenda_event_cards ]**

2. Voeg de **filter** en **evenementenlijst** toe op de pagina waar je ze wilt weergeven.
- Je kunt het filter gebruiken om evenementen te filteren op maand en jaar.
- Het modale venster toont de details van het evenement wanneer je op een evenement klikt.

3. **Formulier**: Er is een knop **"Open Formulier"** beschikbaar in de modal die een formulier opent wanneer erop wordt geklikt.

## Mogelijke fouten en oplossingen

### 1. **Modal werkt niet correct**

**Symptoom**: Wanneer je op een evenement klikt, wordt de modal niet geopend of de inhoud wordt niet weergegeven.

**Oplossing**:
- Zorg ervoor dat je **JavaScript-bestanden** correct zijn ingeladen. Controleer dit door naar de browserconsole te gaan (druk op F12 > Console) en te kijken of er fouten zijn gerapporteerd.
- Controleer of de **HTML-structuur** van de modal correct is. Zorg ervoor dat de `#ic-agenda-modal` daadwerkelijk in de DOM aanwezig is.

### 2. **Geen evenementen zichtbaar na filtering**

**Symptoom**: Wanneer je de maand of het jaar selecteert, worden er geen evenementen weergegeven.

**Oplossing**:
- Controleer of je **eventen** daadwerkelijk hebt toegevoegd met de **'event_date'** meta-velden (zoals 'event_year', 'event_month', 'event_day').
- Controleer de **AJAX-aanroep** in de console om te zien of er fouten optreden bij het ophalen van de gefilterde evenementen.
- Zorg ervoor dat je **filterinstellingen** correct zijn en dat de juiste maanden en jaren zijn geselecteerd.

### 3. **Formulier wordt niet weergegeven**

**Symptoom**: De knop "Open Formulier" verschijnt niet of het formulier wordt niet zichtbaar wanneer erop wordt geklikt.

**Oplossing**:
- Controleer de **event listener** voor de "Open Formulier" knop. Als je gebruik maakt van jQuery, zorg er dan voor dat de jQuery bibliotheek correct is ingeladen.
- Zorg ervoor dat de **formulieren markup** correct is en dat de juiste `ID` wordt gebruikt voor de knop en het formulier.
- Als het formulier verborgen is, controleer dan of de stijl voor het **verbergen** van het formulier correct is ingesteld in je CSS (`display: none;`).

### 4. **Foutmelding bij het opslaan van evenementen**

**Symptoom**: Bij het opslaan van een evenement krijg je een foutmelding, zoals "De datum is ongeldig."

**Oplossing**:
- Controleer de invoer van de **datum**. Zorg ervoor dat de datum correct is ingevoerd en dat deze voldoet aan het juiste formaat.
- Controleer de logica in **`process_event_meta_and_category`**. Als de datum een ongeldige waarde heeft, zorg dan dat je een fallback of foutmelding toevoegt om de gebruiker hiervan op de hoogte te stellen.

### 5. **Knoppen verdwijnen na klik**

**Symptoom**: De "Open Formulier" knop of de andere knoppen verdwijnen na het klikken.

**Oplossing**:
- Controleer of de knoppen **zichtbaar** blijven na interactie met de modal. In sommige gevallen kan de knop verborgen worden door een fout in de JavaScript-logica.
- Zorg ervoor dat de knoppen **niet per ongeluk verborgen** worden door stijlen in je CSS of door andere JavaScript-functies.

## Plugin Debugging

Als je foutmeldingen of problemen ondervindt, kun je de volgende stappen proberen:

1. **Foutlogboeken**: Controleer de serverlogs en de browserconsole op eventuele foutmeldingen.
2. **Debugging inschakelen**: Zet de **WP_DEBUG** modus in WordPress aan door `define( 'WP_DEBUG', true );` toe te voegen aan je `wp-config.php` bestand.
3. **Browserconsole**: Gebruik de **browserconsole** (F12) om te controleren op JavaScript-fouten die de werking van de plugin kunnen beïnvloeden.

## Wijzigingen en aanpassingen

- Deze plugin kan worden aangepast via de bestanden in de map `includes/` (bijvoorbeeld voor aangepaste velden en taxonomieën).
- Als je de **stijl** van de plugin wilt aanpassen, kun je de bestanden in de map `assets/css/` aanpassen.

## Licentie

Dit project is gelicentieerd onder de MIT-licentie - zie het [LICENSE.md](LICENSE.md) bestand voor details.

---

