# Minecraft Statistics | Visualized

Syftet med webbapplikationen är att uppfylla kraven som uppgiftsbeskrivningen som skolan gav i Tillämpad programmering. Webbappen ska låta användaren spara och visa statistiken av en värld som användaren har valt. Allt som behövs är att skriva sin path till sin minecraft/saves folder för att skriptet ska fungera OM man har en databas uppsatt.

## Struktur
```
│   index.php
│   readme.md
│
├───db
│       create_db.sql
│       database.php
│
├───logic
│       functions.php
│       import.php
│
├───styles
│       stylesheet.css
│
└───visual
        footer.php
        header.php
        main.php
        navbar.php
        worldstats.php
```

## För att få igång projektet 

1. Klona repot till din dator med 'git clone https://github.com/Bobluoae/mcstats1.13-plus.git' i din laragon/www folder i Laragon.

2. Kör det relevanta SQL skriptet i din relevanta databas. Skriptet kan hittas i "db" foldern