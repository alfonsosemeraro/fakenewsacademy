import datetime
from backend import db
from sqlalchemy import func
from sqlalchemy.types import UserDefinedType

db.Model.metadata.reflect(db.engine)

class Papers(db.Model):
    __table_args__ = {'extend_existing': True}
    paper_id = db.Column(db.String(15), primary_key=True)
    title = db.Column(db.String(500))
    author = db.Column(db.String(500))
    year = db.Column(db.Integer)
    cit = db.Column(db.Integer)
    abstract = db.Column(db.String(5000))
    betweenness = db.Column(db.Float)
    indegree = db.Column(db.Integer)
    clustering = db.Column(db.Float)
    pagerank = db.Column(db.Float)

    def __repr__(self):
        return {
        'paper_id': self.paper_id,
        'title': self.title,
        'author': self.author,
        'year': self.year,
        'cit': self.cit,
        'abstract': self.abstract,
        'betweenness': self.betweenness,
        'indegree': self.indegree,
        'clustering': self.clustering,
        'pagerank': self.pagerank
        }
