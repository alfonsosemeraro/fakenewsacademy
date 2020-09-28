#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Thu Sep 24 18:45:13 2020

@author: alfonso
"""

import json
import os

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


command0 = "mysql --user={} --password='{}' -e 'DROP DATABASE IF EXISTS {};'".format(config['db_user'], config['db_password'], config['db_name'])
command1 = "mysql --user={} --password='{}' -e 'CREATE DATABASE {};'".format(config['db_user'], config['db_password'], config['db_name'])
command2 = "mysql --user={} --password='{}' -s {} < 'assets/database/db_schema.sql'".format(config['db_user'], config['db_password'], config['db_name'])
command3 = "mysql --user={} --password='{}' -s {} < 'assets/database/db_seed.sql'".format(config['db_user'], config['db_password'], config['db_name'])

os.system(command0)
os.system(command1)
os.system(command2)
os.system(command3)
