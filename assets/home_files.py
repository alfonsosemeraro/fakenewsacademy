#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Thu Sep 24 12:49:15 2020

@author: alfonso
"""

import json
from polyglot.detect.base import logger as polyglot_logger
import pandas as pd
import re
from nltk.corpus import stopwords
from nltk.stem import WordNetLemmatizer
from sklearn.feature_extraction.text import CountVectorizer
from string import ascii_lowercase, ascii_uppercase
import random


def rand_code(num):
    alphabet = [a for a in ascii_lowercase] + [a for a in ascii_uppercase] + [str(x) for x in range(10)]
    return ''.join([random.sample(alphabet, 1)[0] for x in range(num)])


def eng(title, abstract):
    try:
        if abstract and abstract != '':
            return Text(title).language.code == Text(abstract).language.code == 'en'
        else:
            return Text(title).language.code == 'en'
    except:
        return True


def unique_papers(fake):

    fake = pd.DataFrame(fake).sort_values('cit', ascending = False)
    fake = fake.drop_duplicates(subset = ['title'])
    fake = fake.drop_duplicates(subset = ['paper_id'])

    return fake.to_dict(orient = 'row')


def clean_papers():

    with open('assets/data/raw/fn.json', 'r') as fr:
        fake = json.load(fr)

    fake = [f for f in fake if eng(f['DN'], f['abstract'])]

    fake = [{'paper_id': p['Id'],
             'title': p['DN'],
             'author': (', '.join([au['DAuN'] + ' (' + au['DAfN'] + ')' for au in p['AA']])).replace('()', ''),
             'year': p['Y'],
             'cit': p['ECC'],
             'abstract': p['abstract'],
             'references': p['RId']}

           for p in fake if p['Pt'] in ["1", "3", "7", "8"] and p['Id'] != '']

    fake = unique_papers(fake)

    return fake


def references(fake):
    source = []
    target = []

    for f in fake:
        target += list(f['references'])
        source += [f['paper_id']]*len(f['references'])

    refs = pd.DataFrame({'source': source, 'target': target})

    return refs


def year_papers(fake):
    years = pd.Series([p['year'] for p in fake]).value_counts().sort_index().to_dict()

    return years


def check_nationality(nationality, title, abstract):
    text = title + ' ' + abstract

    x = [a for a in nationality.place if a in text]
    y = [nationality.loc[nationality['adjective'] == a, 'place'].values[0] for a in nationality.adjective if a in text]

    return ', '.join(set(x + y))


def nations_inside(fake):

    nationality = pd.read_csv('assets/data/nationality.csv')
    nations = ', '.join([check_nationality(nationality, p['title'], p['abstract']) for p in fake]).split(', ')

    nations = pd.Series([n for n in nations if n != '']).value_counts().to_dict()
    return nations


def check_years(title, abstract):
    text = title + ' ' + abstract

    text = re.sub(r'[^a-zA-Z0-9 ]', '', text)
    x = [int(a) for a in text.split(' ') if a.isdigit()]
    x = [str(a) for a in x if a > 1900 and a < 2500]

    return ', '.join(x)


def years_inside(fake):
    years = (', '.join([check_years(p['title'], p['abstract']) for p in fake])).split(', ')
    years = pd.Series(years).value_counts().to_dict()

    return years


def clean_lemma(x):

    if isinstance(x, str):
        x = re.sub(r'[^a-zA-Z0-9]', ' ', x.lower()) # strip punctuation
        x = re.sub(r'[ ]+', ' ', x) # strip double spaces
        x = x.split(' ') # split sentence in a list of words

        stopwds = list(set(stopwords.words('english'))) + ['also']
        lemmatizer = WordNetLemmatizer()

        x = [t for t in x if not t in stopwds] # remove stopwords
        x = [lemmatizer.lemmatize(t) for t in x]  # get lemma instead of words
        x = [t for t in x if len(t) > 2] # prune errors

        return ' '.join(x)

    return ''


def top_keywords(fake, n_top = 30):
    lemmas = [clean_lemma(p['abstract'] + ' ' + p['title']) for p in fake]


    n_grams = (1,2) # words and bi-grams

    cv = CountVectorizer(lemmas, ngram_range = n_grams, min_df=10)
    vec = cv.fit_transform(lemmas)
    sum_words = vec.sum(axis = 0)
    words_freq = [(word, sum_words[0, idx]) for word, idx in cv.vocabulary_.items()]
    words_freq =sorted(words_freq, key = lambda x: x[1], reverse=True)

    out = {k[0]: str(k[1]) for k in words_freq[:n_top]}
    return out


fake = clean_papers()
refs = references(fake)
yp = year_papers(fake)
ni = nations_inside(fake)
yi = years_inside(fake)
tk = top_keywords(fake)

for f in fake:
    #f['abstract'] = ''
    if len(f['author']) > 300:
        f['author'] = f['author'][:296] + '...'

# WRITING =========================================================================================

refs.to_csv('assets/data/references.csv', index = False)

with open('assets/data/year_production.json', 'w') as fw:
    json.dump(yp, fw)

with open('assets/data/map_papers.json', 'w') as fw:
    json.dump(ni, fw)

with open('assets/data/year_papers.json', 'w') as fw:
    json.dump(yi, fw)

with open('assets/data/top_keywords.json', 'w') as fw:
    json.dump(tk, fw)

with open('assets/data/fake.json', 'w') as fw:
    json.dump(fake, fw)
