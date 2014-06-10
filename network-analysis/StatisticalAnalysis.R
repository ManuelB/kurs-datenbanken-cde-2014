library(RMySQL) # will load DBI as well
## open a connection to a MySQL database
connection <- dbConnect(dbDriver("MySQL"), user = "root", password = "", dbname = "kurs04", host="127.0.0.1")
# read addressbuch from database into data frame
rs <- dbSendQuery(connection, "select geschlecht, laenge from adressbuch a, telefonat t where a.telefonnummer = t.von_telefonnummer")
telefonateGeschlecht <- fetch(rs, n=-1)
telefonateMaenner <- telefonateGeschlecht$laenge[telefonateGeschlecht$geschlecht=="Mann"]
hist(telefonateMaenner)
hist(log(telefonateMaenner))
mean(telefonateMaenner)
telefonateFrauen <- telefonateGeschlecht$laenge[telefonateGeschlecht$geschlecht=="Frau"]
hist(telefonateFrauen)
hist(log(telefonateFrauen))
mean(telefonateFrauen)
t.test(log(telefonateMaenner), log(telefonateFrauen))
rs <- dbSendQuery(connection, "select land, laenge from adressbuch a, telefonat t where a.telefonnummer = t.von_telefonnummer")
telefonateLand <- fetch(rs, n=-1)
model <- aov(laenge ~ land, telefonateLand)
summary(model)
dbDisconnect(connection)