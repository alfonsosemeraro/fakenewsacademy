import igraph
import pandas
import json

refs = pd.read_csv('assets/data/references.csv')
refs = refs.drop_duplicates()

if "weight" in refs.columns:
  refs.loc[refs['weight'] <= 0,'weight'] = 0.000001

refs = [tuple(x) for x in refs.values]

G = igraph.Graph.TupleList(tuples, directed = True, edge_attrs = ['weight'])
