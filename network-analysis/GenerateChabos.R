library(RMySQL) # will load DBI as well
## open a connection to a MySQL database
connection <- dbConnect(dbDriver("MySQL"), user = "root", password = "", dbname = "kurs04", host="127.0.0.1")

n <- 30
m <- 10
# init the adressbuch
adressbuch <- data.frame(
  id=integer(n),
  anrede=character(n),
  vorname=character(n), 
  nachname=character(n), 
  geschlecht=character(n),
  strasse=character(n), 
  postleitzahl=character(n),
  ort=character(n),
  land=character(n),
  telefonnummer=character(n), 
stringsAsFactors=FALSE)

mannVornamen <- c("Don", "Luigi", "Mario", "Fat Tony", "Frank", "Joseph", "Victor", "John", "Al", "Pablo", "Max")
frauVornamen <- c("Anna", "Lucia", "Julianna", "Maggie", "Sally", "Laura")
nachnamen <- c("Corleone", "Capone", "Escobar", "Lucas", "Cartel", "Roberts", "Mermelstein", "Salazar", "Vasquez", "Gacha", "Lehder")

# adressbuch
adressbuch$id <- 1:n
adressbuch$anrede <- c(rep("Herr", n-m), rep("Frau", m))
adressbuch$vorname <- c(sample(mannVornamen, n-m, TRUE), sample(frauVornamen, m, TRUE))
adressbuch$nachname <- sample(nachnamen, n, TRUE)
adressbuch$geschlecht <- c(rep("Mann", n-m), rep("Frau", m))
adressbuch$telefonnummer <- ceiling(runif(n, min=10000000, max=99999999))
adressbuch$land <- sample(c("Deutschland", "England", "Italien", "Frankreich", "Polen", "Spanien", "Portugal", "USA", "Mexiko", "Columbien", "Venezuela", "Sudan", "Kongo"), n, TRUE)

dbWriteTable(connection, value = adressbuch, name = "adressbuch", append = TRUE,row.names = F ) 

# Generate telefonate

k <- 300
telefonate <- data.frame(
  id=integer(k),
  von_telefonnummer=character(k),
  zu_telefonnummer=character(k),
  laenge=integer(k)
)
telefonate$id <- 1:k
telefonate$von_telefonnummer <- sample(adressbuch$telefonnummer, k, TRUE)
telefonate$zu_telefonnummer <- adressbuch$telefonnummer[abs(ceiling(rnorm(k, 10, 4)))]
# TODO: make women phone longer then men
telefonate$laenge <- exp(rnorm(k))*60

adressbuch_telefonate <- merge(adressbuch, telefonate, by.x = "telefonnummer", by.y="von_telefonnummer")
# make women call 30 seconds longer then men
telefonate$laenge <- telefonate$laenge + ifelse(adressbuch_telefonate$geschlecht == "Frau", 30, 0)

dbWriteTable(connection, value = telefonate, name = "telefonat", append = TRUE,row.names = F ) 
## list the tables in the database
dbDisconnect(connection)
