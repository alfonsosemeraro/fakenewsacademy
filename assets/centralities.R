library(data.table)
library(igraph)
library(bit64)
library(rjson)

refs = fread('assets/data/references.csv')
refs = unique(refs)

if("weight" %in% colnames(refs)){
  refs[refs$weigh <= 0,]$weight = 0.000001  
}

G = graph_from_data_frame(refs, directed = TRUE)

## Computing centralities for each node
nodes = data.table()
nodes$paper_id = V(G)$name
nodes$betweenness = betweenness(G)
nodes$indegree = degree(G, mode = "in")
nodes$clustering = transitivity(G, 'local')
nodes$pagerank = page_rank(G)$vector



fn <- fromJSON(file = 'assets/data/fake.json')
ids = c()
for(f in fn){
  ids = c(ids, f$paper_id)
}
fn = data.table(paper_id = ids)
fn$paper_id <- as.character(fn$paper_id)

nodes = merge(fn, nodes, by = 'paper_id', all.x = TRUE)


nodes[is.na(nodes$betweenness),]$betweenness <- 0
nodes[is.na(nodes$indegree),]$indegree <- 0
nodes[is.na(nodes$clustering),]$clustering <- 0
nodes[is.na(nodes$pagerank),]$pagerank <- 0


fwrite(nodes, 'assets/data/paper_centrality.csv')
