#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Thu Sep 24 18:45:13 2020

@author: alfonso
"""

import json
import os
import pandas as pd

with open('assets/data/fake.json', 'r') as fr:
    fake = json.load(fr)

with open('config/config.json', 'r') as fr:
    config = json.load(fr)

sql = "INSERT INTO `papers` (`paper_id`, `title`, `author`, `year`, `cit`, `abstract`, `betweenness`, `indegree`, `clustering`, `pagerank`) VALUES ***;"

for f in fake:
    del f['references']

fake_str = str([tuple(e.values()) for e in fake])[1:-1]
sql = sql.replace('***', fake_str)

with open('assets/database/db_seed.sql', 'w') as fr:
    fr.write(sql)


refs = pd.read_csv('assets/data/references.csv').drop_duplicates()
refs_values = str([tuple(e) for e in refs.values])[1:-1]
sql2 = "INSERT INTO `references` (`source`, `target`) VALUES {};".format(refs_values)

with open('assets/database/db_cits.sql', 'w') as fr:
    fr.write(sql2)


sim = pd.read_csv('assets/data/most_similar.csv').drop_duplicates()
sim_values = str([tuple(e) for e in sim.values])[1:-1]
sql3 = "INSERT INTO `most_similar` (`paper_id`, `similar`) VALUES {};".format(sim_values)

with open('assets/database/db_similar.sql', 'w') as fr:
    fr.write(sql3)

command0 = "mysql --user={} --password='{}' -e 'DROP DATABASE IF EXISTS {};'".format(config['db_user'], config['db_password'], config['db_name'])
command1 = "mysql --user={} --password='{}' -e 'CREATE DATABASE {};'".format(config['db_user'], config['db_password'], config['db_name'])
command2 = "mysql --user={} --password='{}' -s {} < 'assets/database/db_schema.sql'".format(config['db_user'], config['db_password'], config['db_name'])
command3 = "mysql --user={} --password='{}' -s {} < 'assets/database/db_seed.sql'".format(config['db_user'], config['db_password'], config['db_name'])
command4 = "mysql --user={} --password='{}' -s {} < 'assets/database/db_cits.sql'".format(config['db_user'], config['db_password'], config['db_name'])
command5 = "mysql --user={} --password='{}' -s {} < 'assets/database/db_similar.sql'".format(config['db_user'], config['db_password'], config['db_name'])

os.system(command0)
os.system(command1)
os.system(command2)
os.system(command3)
os.system(command4)
os.system(command5)