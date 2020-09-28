import json
import pandas as pd
import os

os.system('Rscript assets/centralities.R >assets/rlog/a.Rout 2>assets/rlog/a.Rerr')

with open('assets/data/fake.json', 'r') as fr:
        fake = json.load(fr)

L0 = len(fake)

pc = pd.read_csv('assets/data/paper_centrality.csv')

fake = pd.DataFrame(fake, columns = fake[0].keys())
L1 = fake.shape[0]

fake = pd.merge(fake, pc, on = 'paper_id')
L2 = fake.shape[0]


if not L0 == L1 == L2:
    print('Lost {} papers in the process!'.format(L0 - L2))

fake = fake.to_dict(orient = 'row')

with open('assets/data/fake.json', 'w') as fw:
    json.dump(fake, fw)
