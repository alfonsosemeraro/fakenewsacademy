library(data.table)
library(igraph)
library(bit64)

refs = fread('assets/data/references.csv')
refs = unique(refs)

if("weight" %in% colnames(refs)){
  refs[refs$weigh <= 0,]$weight = 0.000001  
}

G = graph_from_data_frame(refs, directed = TRUE)

## Computing centralities for each node
nodes = data.table()
nodes$id = V(G)$name
nodes$betweenness = betweenness(G)
nodes$indegree = degree(G, mode = "in")
nodes$clustering = transitivity(G, 'local')
nodes$pagerank = page_rank(G)$vector

nodes[is.na(nodes)] <- 0
fwrite(nodes, 'assets/data/paper_centrality.csv')
