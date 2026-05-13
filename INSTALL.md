# Installatie & Configuratie Guide

## Hipsy Events Builder v4.0

---

## 📦 Installatie

### Methode 1: WordPress Admin (Aanbevolen)

1. Download `hipsy-events-builder-v4.0.zip`
2. Ga naar WordPress Admin → Plugins → Nieuwe plugin
3. Klik op "Plugin uploaden"
4. Selecteer het ZIP bestand
5. Klik op "Nu installeren"
6. Activeer de plugin

### Methode 2: FTP Upload

1. Pak het ZIP bestand uit
2. Upload de `hipsy-events-builder` folder naar `/wp-content/plugins/`
3. Ga naar WordPress Admin → Plugins
4. Activeer "Hipsy Events Builder"

---

## ⚙️ Configuratie

### Stap 1: Hipsy API Koppeling

1. Ga naar **Dashboard → Hipsy Events → Instellingen**
2. Voer je Hipsy API gegevens in:
   - API Key
   - Organization ID (optioneel)
3. Klik op "Instellingen opslaan"
4. Klik op "Sync nu uitvoeren"

**Test:** Events zouden nu moeten verschijnen onder **Dashboard → Events**

### Stap 2: Automatische Sync

De plugin synchroniseert automatisch elk uur via WP-Cron.

**Handmatige sync:**
- Ga naar **Dashboard → Hipsy Events → Instellingen**
- Klik op "Sync nu uitvoeren"

**Laatste sync controle:**
- Bekijk "Laatste sync:" timestamp
- Bekijk sync log voor errors

---

## 🎨 Je Eerste Event Agenda Maken

### Optie A: Elementor (Aanbevolen)

#### Zonder Filtering

1. Maak een nieuwe pagina in Elementor
2. Sleep **Hipsy · Events Grid** widget op de pagina
3. Configureer:
   - Layout: Grid / List / Carousel
   - Kolommen: Desktop/Tablet/Mobiel
   - Velden: Kies wat te tonen
   - Styling: Pas kleuren, fonts, spacing aan
4. Publiceer!

#### Met Filtering (v4.0)

1. Maak een nieuwe pagina in Elementor
2. Sleep **Hipsy · Filter Bar (v4.0)** bovenaan
   - Stel Query ID in: `agenda`
   - Configureer filters (search, categorieën, locatie)
3. Sleep **Hipsy · Events Grid** eronder
   - Stel dezelfde Query ID in: `agenda`
   - Configureer layout en styling
4. Publiceer!

**Result:** Filter en Grid zijn nu gekoppeld via AJAX 🎉

### Optie B: Shortcode (Voor Salient, WPBakery, etc)

#### Zonder Filtering

```
[hipsy_events_grid columns="3" aantal="6" layout="grid"]
```

#### Met Filtering

```
[hipsy_filter query_id="agenda"]

[hipsy_events_grid query_id="agenda" columns="3" aantal="6"]
```

---

## 🎯 Elementor Widget Opties

### Hipsy Events Grid

#### Layout Tab
- **Grid-type:** Grid / List / Carrousel / Kalender / Agenda
- **Kolommen:** Responsive (Desktop/Tablet/Mobiel)
- **Kaartoriëntatie:** Verticaal / Horizontaal per device

#### Query & Filtering Tab
- **Query ID:** Unieke ID voor filter koppeling (v4.0)
- **Max. events:** Aantal events om te tonen
- **Alleen aankomende events:** Toon alleen toekomstige events
- **Filter categorie:** Toon specifieke categorie

#### Velden Tab
Toggle welke velden te tonen:
- ✓ Afbeelding
- ✓ Datum
- ✓ Tijd
- ✓ Titel
- ✓ Locatie
- ✓ Beschrijving
- ✓ Prijs
- ✓ Knoppen

#### Style Tabs
Volledig aanpasbare styling:
- Container spacing
- Card background, border, shadow
- Image height, radius
- Typography (alle elementen)
- Button styling (normal/hover)
- Responsive padding & margins

### Hipsy Filter Bar (v4.0)

#### Koppeling Tab
- **Query ID:** Moet matchen met je Events Grid

#### Filters Tab
- **Zoekbalk:** Aan/uit + placeholder tekst
- **Categorie filters:** Aan/uit + "Alle" label
- **Locatie filter:** Aan/uit

#### Style Tabs
- Zoekbalk styling (typography, colors, radius)
- Filter buttons (normal/active states)

---

## 💡 Shortcode Referentie

### [hipsy_filter]

Filter bar shortcode.

**Parameters:**
```
query_id          → Koppel aan grid (verplicht)
show_search       → yes/no (default: yes)
show_categories   → yes/no (default: yes)
show_location     → yes/no (default: no)
search_placeholder → Placeholder tekst
all_label         → Label voor "Alle" button
```

**Voorbeeld:**
```
[hipsy_filter query_id="agenda" show_search="yes" show_categories="yes"]
```

### [hipsy_events_grid]

Events grid shortcode.

**Parameters:**
```
query_id          → Koppel aan filter (optioneel)
layout            → grid/list/carousel (default: grid)
columns           → 1-4 (default: 3)
aantal            → Max events (default: 6)
alleen_toekomst   → yes/no (default: yes)
categorie         → Filter op categorie slug
show_image        → yes/no
show_date         → yes/no
show_time         → yes/no
show_title        → yes/no
show_location     → yes/no
show_description  → yes/no
show_price        → yes/no
show_button       → yes/no
max_words         → Max woorden beschrijving
button_text       → Tekst voor ticket button
```

**Voorbeelden:**
```
[hipsy_events_grid query_id="agenda" columns="3" aantal="6"]

[hipsy_events_grid layout="list" aantal="10" alleen_toekomst="yes"]

[hipsy_events_grid categorie="workshops" columns="2" show_description="no"]
```

### [hipsy_events_list]

Dedicated list layout shortcode.

**Parameters:**
```
query_id         → Koppel aan filter (optioneel)
aantal           → Max events
alleen_toekomst  → yes/no
categorie        → Filter op categorie slug
```

**Voorbeeld:**
```
[hipsy_events_list query_id="agenda" aantal="10"]
```

---

## 🔄 Upgraden van Oudere Versies

### Van v1.x of v3.x naar v4.0

**Goede nieuws:** Deze upgrade is volledig backwards compatible! 🎉

#### Wat blijft werken:
✅ Alle bestaande Elementor widgets
✅ Alle bestaande shortcodes  
✅ Custom post type `hipsy_event`
✅ Meta fields
✅ API sync
✅ Cron jobs
✅ Admin instellingen

#### Upgrade stappen:
1. **Backup maken** (altijd aan te raden)
2. Plugin updaten naar v4.0
3. Klaar! Alles blijft werken

#### Nieuwe features gebruiken:
1. **AJAX Filtering toevoegen:**
   - Edit je bestaande Elementor pagina
   - Voeg "Hipsy Filter Bar (v4.0)" widget toe
   - Kies een Query ID (bijv: `agenda`)
   - Bij je bestaande "Events Grid" widget:
     - Voeg dezelfde Query ID toe
   - Save & test!

2. **Shortcodes met filtering:**
   - Vervang `[hipsy_events_grid]`
   - Door: `[hipsy_filter query_id="agenda"]` + `[hipsy_events_grid query_id="agenda"]`

---

## 🛠️ Troubleshooting

### Events worden niet gesynchroniseerd

**Check:**
1. API credentials correct ingevuld?
2. WP-Cron draait? (Hosting check)
3. Sync errors in log?

**Fix:**
- Klik handmatig op "Sync nu uitvoeren"
- Check Hipsy dashboard voor API issues
- Contact hosting voor WP-Cron support

### Filter werkt niet

**Check:**
1. Query ID is hetzelfde in Filter en Grid?
2. JavaScript errors in browser console?
3. jQuery geladen?

**Fix:**
- Controleer Query ID spelling (let op hoofdletters)
- Refresh page
- Check of jQuery conflict bestaat

### Styling ziet er verkeerd uit

**Check:**
1. Theme CSS conflicts?
2. Cache geleegd?
3. Browser cache geleegd?

**Fix:**
- Clear WordPress cache
- Clear browser cache (Ctrl+Shift+R)
- Check theme compatibility

### Elementor widget niet zichtbaar

**Check:**
1. Elementor geïnstalleerd?
2. Plugin geactiveerd?
3. Page builder refresh nodig?

**Fix:**
- Deactiveer en heractiveer plugin
- Regenereer Elementor CSS (Tools → Regenerate CSS)

---

## 📞 Support

### Voor Technische Issues

**Email:** hello@youngsoulbusiness.com

**Include in je bericht:**
- WordPress versie
- PHP versie  
- Elementor versie (indien gebruikt)
- Plugin versie
- Error messages / screenshots

### Voor Feature Requests

Stuur je suggesties naar:
**Email:** hello@youngsoulbusiness.com

---

## 🎓 Best Practices

### Performance

- **Cache:** Gebruik caching plugin (WP Rocket, W3 Total Cache)
- **Images:** Gebruik CDN voor event afbeeldingen
- **Sync:** Laat automatische sync op elk uur staan (default)

### Design

- **Mobile First:** Test altijd op mobiel
- **Responsive:** Gebruik responsive controls in Elementor
- **Consistency:** Gebruik dezelfde styling op alle pagina's

### SEO

- **Structured Data:** Events hebben automatisch schema.org markup
- **URLs:** Use clean permalinks (/events/event-naam/)
- **Images:** Alt text wordt automatisch uit event titel gehaald

---

## ✅ Checklist: Na Installatie

- [ ] API credentials ingevuld
- [ ] Eerste sync uitgevoerd
- [ ] Events zichtbaar in admin
- [ ] Test pagina gemaakt in Elementor
- [ ] Filter + Grid gekoppeld (v4.0)
- [ ] Mobile responsive getest
- [ ] Ticket links werken
- [ ] Automatische sync draait (check na 1 uur)

---

**Veel succes met je Hipsy Events Builder! 🚀**

Voor vragen: hello@youngsoulbusiness.com
