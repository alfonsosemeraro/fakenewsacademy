import hashlib
import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

from flask import session
from flask import url_for, flash, redirect
from flask_wtf import FlaskForm
from wtforms import StringField, SubmitField, TextAreaField, IntegerField, RadioField, FloatField, SelectField
from flask_wtf.file import FileField, FileAllowed
from wtforms.validators import DataRequired, Length, Email

from backend import mysql
from backend.models import *

from string import ascii_lowercase, ascii_uppercase
import random
from operator import itemgetter




def Search(title, author, years, cits):
    """ Front end sends defaults:
        title: ''
        author: ''
        years: (1850, current_year)
        cits: (0, 1*10**6)
    """

    if title != '':
        title = '%' + title + '%'

    if author != '':
        author = '%' + author + '%'

    min_year, max_year = years
    min_cit, max_cit = cits

    itemData = Papers.query \
        .with_entities(
            Papers.paper_id,
            Papers.title,
            Papers.author,
            Papers.year,
            Papers.cit,
            Papers.abstract,
            Papers.indegree,
            Papers.betweenness,
            Papers.pagerank,
            Papers.clustering
        ) \
        .filter(
            Papers.title.ilike(title),
            Papers.author.ilike(author),
            Papers.year >= min_year,
            Papers.year <= max_year,
            Papers.cit >= min_cit,
            Papers.cit <= max_cit
        ).all()

    return {'item-total-number': len(itemData), 'item-list': itemData}



def getPaper(paper_id):

    itemData = Papers.query \
        .with_entities(
        Papers.paper_id,
        Papers.title,
        Papers.author,
        Papers.year,
        Papers.cit,
        Papers.abstract,
        Papers.indegree,
        Papers.betweenness,
        Papers.pagerank,
        Papers.clustering) \
        .filter(Papers.paper_id == paper_id).first()

    return itemData



def getSimilarPapers(paper_id):
    pass

def getSameAuthorPapers(author, n_papers = 10):

    """ Must unpack authors and search in OR """
    itemData = Papers.query \
        .with_entities(
            Papers.paper_id,
            Papers.title,
            Papers.author,
            Papers.year,
            Papers.cit,
            Papers.abstract,
            Papers.indegree,
            Papers.betweenness,
            Papers.pagerank,
            Papers.clustering
        ) \
        .filter(
            Papers.author == author
        ).all()

    itemData = itemData[:n_papers]
    return itemData
