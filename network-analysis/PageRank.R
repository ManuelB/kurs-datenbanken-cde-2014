library(igraph)
g <- random.graph.game(20, 5/20, directed=TRUE)
g$layout <- layout.fruchterman.reingold(g)
# https://stat.ethz.ch/pipermail/r-help/2009-February/187108.html
V(g)$size <- page.rank(g)$vector*300
V(g)$color <- rainbow(length(V(g)))
plot(g)
# http://stackoverflow.com/questions/12268697/how-to-sort-and-visualize-a-directed-graph
# http://igraph.org/r/