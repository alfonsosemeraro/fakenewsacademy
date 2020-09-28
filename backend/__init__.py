from flask import Flask
from flask_sqlalchemy import SQLAlchemy
from flask_bcrypt import Bcrypt
from flask_mysqldb import MySQL
import json

######### Enable this for debugging #########
# import logging
# logging.basicConfig()
# logging.getLogger('sqlalchemy.engine').setLevel(logging.INFO)
# SQLALCHEMY_TRACK_MODIFICATIONS = True
######## Enable this for debugging #########

app = Flask(__name__)
app.config['SECRET_KEY'] = '5791628bb0b13ce0c676dfde280ba245' # ?

with open('config/config.json', 'r') as fr:
    config = json.load(fr)

app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql://{}:{}@{}/{}'.format(config['db_user'], config['db_password'], config['host'], config['db_name'])
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)
bcrypt = Bcrypt(app)
app.secret_key = 'random string'
UPLOAD_FOLDER = 'static/uploads'
ALLOWED_EXTENSIONS = set(['jpeg', 'jpg', 'png', 'gif'])
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER

######### Required in Case of firing complex queries without ORM #########
app.config['MYSQL_HOST'] = config['host']
app.config['MYSQL_USER'] = config['db_user']
app.config['MYSQL_PASSWORD'] = config['db_password']
app.config['MYSQL_DB'] = config['db_name']
app.config['MYSQL_CURSORCLASS'] = 'DictCursor'
mysql = MySQL(app)
######### Required in Case of firing complex queries without ORM #########


from backend import models
from backend import routes


models.db.create_all()
