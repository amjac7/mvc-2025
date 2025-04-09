# min ReadME fil


![Image related to github](public/img/codegithubimg.jpg)

text

## Hur man clonar repot & kommer igång:


#### Steg 1:
När du ska clona repot så börjar du med att i terminalen, stå i den mappen som du ska göra det för. I mitt fall är detta me/report. 

Sedan så ska man göra ett git-repo av katalogen och detta gör man genom att köra nedstående kommandon:

```bash
# Gå till me/report
git init
touch README.md
git add .
git commit -m "First commit"
```
**OBS!** Kan vara bra att notera att det innanför citatteknena (" ") i sista commandot (git commit), 
det är en frivillig kommentar man skriver där. Men man brukar börja med att skriva något i stil med ovan, när det är första gången man gör detta!


**Tips om du vill dubbelkolla hur det ser ut under processens gång:**
```bash
git status
```
-> Kan köras när du vill och som du ser innan du gör add . som du gjorde tidigare får de rött för saker har inte lagts upp. Gör du det efter exempelvis add . så är det grönt. Bara ett litet tips. 



Men vi fortsätter. 


### Steg 2:

Ändringarna är dock fortfarande lokala och då går vi vidare för att fixa nästa steg!


Då får vi istället gå in via github för detta steget, för det är nu som vi ska koppla git och github ihop.
Så att allt fungerar som det ska. 

<u>Innan</u> du går vidare! Dubbelkolla att du gjort följande steg:

- Gå in på github  (webben).
- logga in på ditt konto (har du ingen får du skapa en först)

När detta är gjort letare du reda på **New** som finns i `home` (sidan på githubs sida) och klicka på den!


#### hur du ska fylla i:

- Välj din användare i dropdown-menyn, för  `Owner*`.
- `Repository name*` -> fyll i namnet du vill döpa den till, ex. kursensnamn-årtalet
- `Description` väljer du själv om du vill fylla i någon beskrivning eller ej.

Då vi redan har skapat en README.md fil i förra steget så klickar vi inte i några rutor längre ner utan
vi trycker bara på `Create repository`.







