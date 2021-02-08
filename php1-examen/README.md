# Examen PHP1

Op deze URL vinden jullie een video met korte introductie : https://youtu.be/A3R5rbwT_nw

Fork deze repo (rechts boven), maak je eigen repository en ga aan de slag als een echte professional : git branchen en committen waar nodig. Uiteindelijk merge je alles naar de master-branch.

Start je eigen debugserver met volgende commando: `php -S localhost:8080 -t .` Zet breakpoints, lees foutboodschappen zeer aandachtig. Probeer eerst een zicht te krijgen op de opbouw van de code! Als last resort : het probleem beschrijven (ook in de code schrijven) is al een stap in de goede richting!

Push zeker je laatste commit tegen 17u ! Je krijgt tijd tot woensdag 20u, maar dit is met strafpunten:

- ma 8 feb 17u : 0 strafpunten
- ma 8 feb 24u : 10 strafpunten
- di 9 feb 24u : 20 strafpunten
- wo 10 feb 24u : 30 strafpunten

Ik kijk naar de commit-tijdstippen **in de master branch !!!**

Veel succes!

## Debug config

Maak de juiste debug-configuratie aan. Controleer eerst welke XDebug versie je hebt: `php -v`. Heeft jouw XDebug een versie kleinder dan 3.0, gebruik dan deze configuratie als debug-config.

```json
{
    "version": "0.2.0",
    "configurations": [{
            "name": "Listen for XDebug",
            "type": "php",
            "request": "launch",
            "port": 9000
        },
   
    ]
}
```

Is jouw versie >= 3.0, gebruik dan deze (port is aangepast naar 9003):

```json
{
    "version": "0.2.0",
    "configurations": [{
            "name": "Listen for XDebug",
            "type": "php",
            "request": "launch",
            "port": 9003
        },
   
    ]
}
```