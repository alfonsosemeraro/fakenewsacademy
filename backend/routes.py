import os
import secrets
from PIL import Image
from flask import render_template, request, jsonify
from backend import app
from plotly.offline import plot
import plotly.graph_objs as go
from flask import Markup
from backend.models import *
from backend.forms import *
import simplejson
import json
import datetime



# ==== HOW TO RETRIEVE QUERY STRINGS
# arg = request.args.get('user')
#
# ==== HOW TO RETRIEVE SESSION PARAMETERS
# if 'user' in session:
#     user = session['user']

current_year = datetime.datetime.now().year

with open('assets/data/year_production.json', 'r') as fr:
    year_production = json.load(fr)

with open('assets/data/map_papers.json', 'r') as fr:
    map_papers = json.load(fr)

with open('assets/data/year_papers.json', 'r') as fr:
    years_papers = json.load(fr)

with open('assets/data/top_keywords.json', 'r') as fr:
    top_keywords = json.load(fr)


@app.route("/")
@app.route("/index")
def index():

    s = {
         'year_production': year_production,
         'map_papers': map_papers,
         'years_papers': years_papers,
         'top_keywords': top_keywords
         }

    return jsonify(s)


@app.route("/search")
def search():

    title = request.args.get('title') if 'title' in request.args else ' '
    author = request.args.get('author') if 'author' in request.args else ' '
    min_year = request.args.get('min_year') if 'min_year' in request.args else 1850
    max_year = request.args.get('max_year') if 'max_year' in request.args else current_year
    min_cit = request.args.get('min_cit') if 'min_cit' in request.args else 0
    max_cit = request.args.get('max_cit') if 'max_cit' in request.args else 1_000_000

    # this would be the true query
    s = Search(title = title, author = author, years = (min_year, max_year), cits = (min_cit, max_cit))

    # mock query
    # s = Search(title = 'hoax', author = 'Ruffo', years = (min_year, max_year), cits = (min_cit, max_cit))

    return jsonify(s)



@app.route("/paper/<paper_id>")
def paper(paper_id):

    s = getPaper(paper_id)
    return jsonify(s)
