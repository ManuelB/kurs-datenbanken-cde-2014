library(igraph)
library(RMySQL) # will load DBI as well
## open a connection to a MySQL database
connection <- dbConnect(dbDriver("MySQL"), user = "root", password = "", dbname = "kurs04", host="127.0.0.1")
# read addressbuch from database into data frame
rs <- dbSendQuery(connection, "select telefonnummer, anrede, vorname, nachname, geschlecht from adressbuch")
addressbuch <- fetch(rs, n=-1)
summary(addressbuch)

# read telefonate from database into data frame
rs <- dbSendQuery(connection, "select von_telefonnummer, zu_telefonnummer, laenge, id from telefonat")
telefonate <- fetch(rs, n=-1)
summary(telefonate)

# generate graph from database data
g <- graph.data.frame(telefonate, directed=TRUE, vertices=addressbuch)
# set layout
g$layout <- layout.fruchterman.reingold(g)
# https://stat.ethz.ch/pipermail/r-help/2009-February/187108.html
# set the size of the vertex based on the page.rank (more incoming calls -> more power)
V(g)$size <- page.rank(g)$vector*400
# set size of labels
V(g)$label.cex <- rep(0.5, length(V(g)))
# set color of vertexes
V(g)$color <- rainbow(length(V(g)))
# set labels based on anrede, vorname, nachname
V(g)$label <- do.call(paste, list(V(g)$anrede, V(g)$vorname, V(g)$nachname))
# http://stackoverflow.com/questions/13438013/variable-vertex-font-size-in-igraph
plot(g)
## The opposite operation
# debug
# get.data.frame(g, what="vertices")
# get.data.frame(g, what="edges")

dbDisconnect(connection)
