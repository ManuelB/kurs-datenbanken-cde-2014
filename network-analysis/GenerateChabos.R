library(RMySQL) # will load DBI as well
## open a connection to a MySQL database
connection <- dbConnect(dbDriver("MySQL"), user = "root", password = "", dbname = "kurs04", host="127.0.0.1")

n <- 100
m <- 20
# init the gangster
gangster <- data.frame(
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

# gangster
gangster$id <- 1:n
gangster$anrede <- c(rep("Herr", n-m), rep("Frau", m))
gangster$vorname <- c(sample(mannVornamen, n-m, TRUE), sample(frauVornamen, m, TRUE))
gangster$nachname <- sample(nachnamen, n, TRUE)
gangster$geschlecht <- c(rep("Mann", n-m), rep("Frau", m))
gangster$telefonnummer <- ceiling(runif(n, min=10000000, max=99999999))
gangster$land <- sample(c("Deutschland", "England", "Italien", "Frankreich", "Polen", "Spanien", "Portugal", "USA", "Mexiko", "Columbien", "Venezuela", "Sudan", "Kongo"), n, TRUE)

dbWriteTable(connection, value = gangster, name = "adressbuch", append = TRUE,row.names = F ) 

# Generate telefonate

k <- 1000
telefonate <- data.frame(
  id=integer(k),
  von_telefonnummer=character(k),
  zu_telefonnummer=character(k),
  laenge=integer(k)
)
telefonate$von_telefonnummer <- sample(gangster$telefonnummer, k, TRUE)
telefonate$zu_telefonnummer <- gangster$telefonnummer[abs(ceiling(rnorm(k, 500, 150)))]
# TODO: make women phone longer then men
telefonate$laenge <- exp(rnorm(k))*60
dbWriteTable(connection, value = telefonate, name = "telefonat", append = TRUE,row.names = F ) 
## list the tables in the database
dbDisconnect(connection)