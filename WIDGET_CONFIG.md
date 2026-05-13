# MANDIRA DESIGN — Widget Configuratie 🎨

Zo stel je het **Events Grid Widget** in voor exact de Mandira Utrecht designs!

---

## ⚡ QUICK SETUP

### Stap 1: Installeer CSS

**Locatie:** `assets/mandira-style.css`

**Optie A - Divi:**
1. Ga naar **Divi → Theme Options → Custom CSS**
2. Plak de hele `mandira-style.css` onderaan
3. Save

**Optie B - Elementor:**
1. Ga naar **Elementor → Custom CSS**
2. Plak de hele `mandira-style.css`
3. Save

### Stap 2: Kies je Layout

Je hebt 2 opties:
- **Grid Layout** (Screenshots 1 & 4) → Gebruik class `mandira-grid`
- **List Layout** (Screenshot 3) → Gebruik class `mandira-list`

---

## 🎨 LAYOUT 1: GRID (Screenshot 1)

### Widget Instellingen

**🎨 Grid-type:**
- Layout: `Grid`
- Kolommen: `3` (desktop), `2` (tablet), `1` (mobile)

**🃏 Kaartopbouw:**
- Kaartoriëntatie: `Verticaal — afbeelding boven`

**📸 Afbeeldingen:**
- Toon afbeeldingen: `Ja`
- Aspect ratio: `16:9` of `4:3`
- Object-fit: `Cover`

**📝 Content blokken:**
- Titel: `Ja` (order 1)
- Datum: `Ja` (order 2)
- Tijd: `Ja` (order 3)
- Locatie: `Ja` (order 4)
- Beschrijving: `Ja` (order 5), max 50 woorden
- Categorieën: `Ja`

**🎨 Custom CSS Class:**
```
mandira-grid
```

### HTML Template (Advanced)

Als je volledige controle wilt, gebruik dan **Custom HTML**:

```html
<div class="mandira-grid">
  <!-- Events worden hier automatisch gegenereerd -->
  
  <div class="hew-card">
    <div class="hew-img-wrapper" data-month="MEI" data-day="01">
      <img src="[event-image]" alt="[event-title]">
      
      <!-- Category Tags -->
      <div class="hew-event-categories">
        <span class="category-tag">MANTRA'S/KIRTAN</span>
        <span class="category-tag">MEDITATIE</span>
      </div>
    </div>
    
    <div class="hew-content">
      <h3 class="hew-event-title">
        <a href="[event-link]">Vrijdagmiddag Kirtan</a>
      </h3>
      
      <div class="hew-event-meta">
        <div class="hew-meta-item">
          <span class="hew-meta-icon">📅</span>
          <span>vrijdag 1 mei 2026</span>
        </div>
        <div class="hew-meta-item">
          <span class="hew-meta-icon">🕐</span>
          <span>14:00 - 16:30</span>
        </div>
        <div class="hew-meta-item">
          <span class="hew-meta-icon">📍</span>
          <span>Mandira, Utrecht</span>
        </div>
      </div>
      
      <div class="hew-event-description">
        3 vrijdagen komen we samen met een vaste groep...
      </div>
    </div>
  </div>
</div>
```

---

## 📋 LAYOUT 2: LIST (Screenshot 3)

### Widget Instellingen

**🎨 Grid-type:**
- Layout: `Lijst`
- Kolommen: `1`

**🃏 Kaartopbouw:**
- Kaartoriëntatie: `Horizontaal — afbeelding links`

**📸 Afbeeldingen:**
- Toon afbeeldingen: `Ja`
- Afbeeldingsbreedte (horizontaal): `200px`

**📝 Content blokken:**
- Datum (bovenaan, uppercase): `ZATERDAG 16 MEI 2026`
- Titel: `Ja`
- Tijd (inline met datum): `🕐 10:30 - 17:30`
- Locatie: `Ja` (met link naar Google Maps)
- Beschrijving: `Ja`, max 75 woorden
- Prijs: `Vanaf € 95,-` of `Gratis`

**🎨 Custom CSS Class:**
```
mandira-list
```

### Buttons Toevoegen

Voeg 2 buttons toe in het widget:

**Button 1 (Meer info):**
- Text: `Meer info`
- URL: `[event_link]`
- Class: `hew-btn hew-btn-outline`

**Button 2 (Aanmelden):**
- Text: `Aanmelden →`
- URL: `[event_ticket_url]`
- Class: `hew-btn hew-btn-primary`

---

## 🔘 FILTER BUTTONS (Screenshot 2 & 4)

### Category Filters (Screenshot 2)

Voeg **boven** je Events Grid widget een **HTML block** toe:

```html
<div class="mandira-filters">
  <button class="mandira-filter-btn active" data-filter="alle">
    Alle
  </button>
  <button class="mandira-filter-btn" data-filter="mantra-kirtan">
    Mantra's/Kirtan
  </button>
  <button class="mandira-filter-btn" data-filter="klankreizen">
    Klankreizen
  </button>
  <button class="mandira-filter-btn" data-filter="tantra">
    Tantra
  </button>
  <button class="mandira-filter-btn" data-filter="cacaoceremonies">
    Cacaoceremonies
  </button>
  <button class="mandira-filter-btn" data-filter="meditatie">
    Meditatie
  </button>
  <button class="mandira-filter-btn" data-filter="yoga">
    Yoga
  </button>
  <button class="mandira-filter-btn" data-filter="dans">
    Dans
  </button>
</div>
```

### Location Filters (Screenshot 4)

```html
<div class="mandira-filters">
  <button class="mandira-filter-btn location active" data-location="alle">
    Alle locaties
  </button>
  <button class="mandira-filter-btn location" data-location="utrecht">
    Utrecht
  </button>
  <button class="mandira-filter-btn location" data-location="rotterdam">
    Rotterdam
  </button>
  <button class="mandira-filter-btn location" data-location="breda">
    Breda
  </button>
  <button class="mandira-filter-btn location" data-location="eindhoven">
    Eindhoven
  </button>
  <button class="mandira-filter-btn location" data-location="nijmegen">
    Nijmegen
  </button>
  <button class="mandira-filter-btn location" data-location="zwolle">
    Zwolle
  </button>
  <button class="mandira-filter-btn location" data-location="enschede">
    Enschede
  </button>
</div>
```

**Filter JavaScript:**

Voeg toe aan footer (Divi → Custom Code → Footer):

```javascript
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.mandira-filter-btn');
    
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active from all
            filterButtons.forEach(b => b.classList.remove('active'));
            
            // Add active to clicked
            this.classList.add('active');
            
            // Get filter value
            const filterValue = this.getAttribute('data-filter') || this.getAttribute('data-location');
            
            // Filter events (adjust selector to match your widget)
            const events = document.querySelectorAll('.hew-card');
            
            events.forEach(event => {
                if (filterValue === 'alle') {
                    event.style.display = '';
                } else {
                    // Check if event has this category/location
                    const hasFilter = event.classList.contains(filterValue) || 
                                     event.getAttribute('data-category') === filterValue ||
                                     event.getAttribute('data-location') === filterValue;
                    
                    event.style.display = hasFilter ? '' : 'none';
                }
            });
        });
    });
});
</script>
```

---

## 🎯 DATUM BADGE (Screenshot 1)

De datum badge (MEI 01) werkt via CSS `::before` en `::after`. 

**JavaScript om data toe te voegen:**

```html
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.mandira-grid .hew-img-wrapper').forEach(wrapper => {
        const card = wrapper.closest('.hew-card');
        const dateElement = card.querySelector('[data-event-date]');
        
        if (dateElement) {
            const dateStr = dateElement.getAttribute('data-event-date');
            const date = new Date(dateStr);
            
            const months = ['JAN','FEB','MRT','APR','MEI','JUN','JUL','AUG','SEP','OKT','NOV','DEC'];
            const month = months[date.getMonth()];
            const day = date.getDate();
            
            wrapper.setAttribute('data-month', month);
            wrapper.setAttribute('data-day', day);
        }
    });
});
</script>
```

**Of gebruik shortcodes in template:**

```html
<div class="hew-img-wrapper" 
     data-month="[event_date format='M']" 
     data-day="[event_date format='d']">
  [event_image]
</div>
```

---

## 🎨 KLEUREN AANPASSEN

Wil je andere kleuren? Pas deze variabelen aan in de CSS:

```css
:root {
    --mandira-primary: #d97706;     /* Oranje */
    --mandira-success: #10b981;     /* Groen (prijs) */
    --mandira-gray: #666;           /* Text kleur */
}

/* Dan vervang overal #d97706 door var(--mandira-primary) */
```

---

## ✅ CHECKLIST

- [ ] CSS toegevoegd aan theme
- [ ] Widget toegevoegd aan pagina
- [ ] Layout gekozen (grid of list)
- [ ] Custom class toegevoegd (`mandira-grid` of `mandira-list`)
- [ ] Filter buttons toegevoegd (optioneel)
- [ ] Datum badge script toegevoegd
- [ ] Getest op desktop + mobile
- [ ] Live!

---

## 🆘 TROUBLESHOOTING

### Datum badge verschijnt niet
→ Check of het datum badge JavaScript geladen is  
→ Controleer of `.hew-img-wrapper` de juiste class heeft

### Category tags niet zichtbaar
→ Check of events categorieën hebben  
→ Voeg `hew-event-categories` div toe in template

### Filters werken niet
→ Check of filter JavaScript geladen is  
→ Controleer of events de juiste `data-category` attribute hebben

### Styling werkt niet
→ Hard refresh browser (Ctrl+Shift+R)  
→ Check of CSS correct geïmporteerd is  
→ Gebruik browser inspector om classes te checken

---

**Nu heb je exact de Mandira designs!** 🎉

Vragen? → hello@youngsoulbusiness.com
