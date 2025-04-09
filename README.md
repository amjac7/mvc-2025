# Min ReadME fil


![Image related to github](public/img/codegithubimg.jpg)

## Hur man clonar repot & kommer igång:


#### Steg 1:
När du ska clona repot så börjar du med att i terminalen, stå i den mappen som du ska göra det för. I mitt fall är detta `me/report`. 

Sedan så ska man göra ett git-repo av katalogen och detta gör man genom att köra nedstående kommandon:

```bash
# Gå till me/report
git init
touch README.md
git add .
git commit -m "First commit"
```
**OBS!** Kan vara bra att notera att det innanför citatteknena (" ") i sista commandot (git commit), 
är en frivillig kommentar man skriver där. Men man brukar börja med att skriva något i stil med ovan, när det är första gången man gör detta!


**Tips om du vill dubbelkolla hur det ser ut under processens gång:**
```bash
git status
```
-> Kan köras när du vill och som du ser innan du gör add . som du gjorde tidigare får de rött för saker har inte lagts upp. Gör du det efter exempelvis add . så är det grönt. Bara ett litet tips. 



Men vi fortsätter. 


#### Steg 2:

Ändringarna är dock fortfarande lokala och då går vi vidare för att fixa nästa steg!


Då får vi istället gå in via github för detta steget, för det är nu som vi ska koppla git och github ihop.
Så att allt fungerar som det ska. 

<u>Innan</u> du går vidare! Dubbelkolla att du gjort följande steg:

- Gå in på github  (webben).
- logga in på ditt konto (har du ingen får du skapa en först)

När detta är gjort letare du reda på **New** som finns i `home` (sidan på githubs sida) och klicka på den!


##### hur du ska fylla i:

- Välj din användare i dropdown-menyn, för  `Owner*`.
- `Repository name*` -> fyll i namnet du vill döpa den till, ex. kursensnamn-årtalet
- `Description` väljer du själv om du vill fylla i någon beskrivning eller ej.

Då vi redan har skapat en README.md fil i förra steget så klickar vi inte i några rutor längre ner utan
vi trycker bara på `Create repository`.




** Nu finns en folder för ditt repository **

Men vi är ej klara ännu, den är fortfarande tom. Vi måste nu koppla vår git med vår repository för få fixat det. 

Låt oss titta på hur vi gör detta:

#### Steg 4:

Nu när du kommit vidare så kan du se att du kommer till en sida med lite olika val att välja mellan.

I och med att vi redan har ett repository så kommer vi att välja **det tredje alternativet: `push`**

**VIKTIGT** Att du har valt `SSH` valet i topen av sidan innan du går vidare. 

Om ej:
- ta en ny flik och fixa kopplingen med SSH nycklar och kom sedan tillbaks till denna guiden.


För att koppla dessa nu så kommer vi lägga in dessa valen (de 3 kodraderna som finns under `push` delen)
in i vår terminal. Så kör var och ett av dessa komandon för sig (de kommer ha med rätt länkning med din repository och ssh nyckel mm så därför du tar de därifrån).


##### För att dubbelkolla om du vill efter du kört det kommandot med main kan du köra följande kommando,

för att se att du är på rätt branch (är * framför den du är på, och den ska stå på `main`)

```bash
git branch
```

** KLAR MED KOPPLINGEN **


#### Men hur lägger jag till taggar?

Jo det är välidigt simpelt, har du gjort ovan kommando och guide så kan du nu göra följande:

- skapa en tag (för den delen du nyss pushat, (koden))

```bash
git tag -a 1.0.0 -m "draft"
```
**OBS** 
    1. 1.0.0 byter du ut till vilket kursmoment du är på och efterhand att du gör ändringar öka det med 1.01, 1.02 osv!
    2. Koden innanför "" kan du välja själv vad du vill skriva där, **tips** något passande till det du gjort.


- Kolla att tagen skapades som den skulle

```bash
git tag
```
Visar alla taggar som finns, så kan du se om du hittar den du nyss la till också. 



- pusha taggen:

```bash
git push --tags
```


**KLAR, du har nu taggar till detta också!**



#### Men vilka steg gör jag om jag gör ändringar och ska publisera allt igen?

Jo då följer du bara dessa kommandon (för pusha dina ändringar):

```bash
git status
git add .
git status
git commit -m "add a sentence"
git status
git push
```

För att lägga till taggarna:

```bash
git tag -a 1.0.0 -m "sentence"
git tag
git push --tags
```
(**Kom ihåg!** att anpassa dessa 1.0.0 efterhand se mer om det i punkten där vi går igenom det ovan!)


**KLAR DU KAN NU OFFICELLT ALLTING**

Lycka till nu med dina framtida projekt med git och github!
