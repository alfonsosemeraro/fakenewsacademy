#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Mon Oct 19 11:56:23 2020

@author: alfonso
"""

import pandas as pd
from gensim.models.doc2vec import Doc2Vec, TaggedDocument
from nltk.tokenize import word_tokenize
import numpy as np
import math
import json
from nltk.corpus import stopwords
from nltk.stem import WordNetLemmatizer
import re



def clean_lemma(x):
    
    if isinstance(x, str):
        x = re.sub(r'[^a-zA-Z0-9]', ' ', x.lower()) # strip punctuation
        x = re.sub(r'[ ]+', ' ', x) # strip double spaces
        x = x.split(' ') # split sentence in a list of words

        stopwds = set(stopwords.words('english'))
        lemmatizer = WordNetLemmatizer()

        x = [t for t in x if not t in stopwds] # remove stopwords
        x = [lemmatizer.lemmatize(t) for t in x]  # get lemma instead of words
        x = [t for t in x if t != ''] # prune errors

        return ' '.join(x)
    
    return ''
    

## LOADING JSON AND MAKE IT A DF [[ID, ABSTRACT]] WITH CLEAN ABSTRACT
with open('assets/data/fake.json', 'r') as fr:
    fake = json.load(fr)
  
fake = pd.DataFrame.from_dict(fake)[['paper_id', 'abstract']].drop_duplicates()
fake['abstract'] = [clean_lemma(row.abstract) for _, row in fake.iterrows()]


## DOC2VEC
data = fake['abstract'].values
data = [d if isinstance(d, str) else '' for d in data]

tagged_data = [TaggedDocument(words=word_tokenize(_d.lower()), tags=[str(i)]) for i, _d in enumerate(data)]
max_epochs = 10
vec_size = 20
alpha = 0.025

model = Doc2Vec(size=vec_size,
                alpha=alpha, 
                min_alpha=0.00025,
                min_count=1,
                dm =1)

model.build_vocab(tagged_data)

for epoch in range(max_epochs):
    model.train(tagged_data,
                total_examples=model.corpus_count,
                epochs=model.iter)
    # decrease the learning rate
    model.alpha -= 0.0002
    # fix the learning rate, no decay
    model.min_alpha = model.alpha
    
    
    
## GETTING TOP 10 SIMILAR ARTICLES
TOP = 10
similar = pd.DataFrame()

for index, row in fake.iterrows():
    sim = model.docvecs.most_similar(index, topn = TOP)
    sim = [fake.iloc[int(s[0]), 0] for s in sim]
    
    similar = similar.append(pd.DataFrame({'paper': [row.paper_id]*TOP, 'similar': sim}))

similar.to_csv('assets/data/most_similar.csv', index = False)