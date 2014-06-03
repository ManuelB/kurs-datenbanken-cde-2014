library(RMySQL) # will load DBI as well
## open a connection to a MySQL database
connection <- dbConnect(dbDriver("MySQL"), user = "root", password = "", dbname = "kurs04", host="127.0.0.1")
# read addressbuch from database into data frame
rs <- dbSendQuery(connection, "select geschlecht, laenge from adressbuch a, telefonat t where a.telefonnummer = t.von_telefonnummer")
telefonate <- fetch(rs, n=-1)
t.test(telefonate$laenge[telefonate$geschlecht=="Mann"], telefonate$laenge[telefonate$geschlecht=="Frau"])
dbDisconnect(connection)
