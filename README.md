# FakeNews Academy

## Deploy on localhost

1. Install mysql
2. Set root permissions [as here](https://linuxconfig.org/how-to-reset-root-mysql-mariadb-password-on-ubuntu-20-04-focal-fossa-linux). You should be able to run "mysql -u root -p" and connect with your password (default password is 'root', see _config/config.json_)
3. Install R
4. Install R packages _data.table_, _igraph_, _bit64_ and _rjson_.
5. Install python 3
6. Install python packages from requirements.txt (run _pip3 isntall -r requirements.txt_)
7. Run setup.py_
8. Run _run.py_
9. Go to localhost:5000

## You can hit three different addresses:

### localhost:5000/
Returns a json like:
```
{"map_papers":
  {"Afghanistan":6,"Africa":43,"Argentina":1,"Asia":16,"Australia":32,"Austria":3,"Bangladesh":5, ...},

"top_keywords":
  {"article":"782","based":"855","data":"732", ...},

"year_production":
{"1852":1,"1858":2,"1872":1,"1890": "1", ...}
}
```

### localhost:5000/paper/<paper_id>
For instance, hitting localhost:5000/paper/1105550512 returns a json like:

```
{"paper_id":"1105550512",
"title":"Fact-checking Effect on Viral Hoaxes: A Model of Misinformation Spread in Social Networks",
"year":2015,
"abstract":"spread of misinformation, rumors and hoaxes. The goal of this work is to introduce a simple modeling framework to study the diffusion of hoaxes and in particular how the availability of debunking information may contain their diffusion. As traditionally done in the mathematical modeling of information diffusion processes, we regard hoaxes as viruses: users can become infected if they are exposed to them, and turn into spreaders as a consequence. Upon verification, users can also turn into non-believers and spread the same attitude with a mechanism analogous to that of the hoax-spreaders. Both believers and non-believers, as time passes, can return to a susceptible state. Our model is characterized by four parameters: spreading rate, gullibility, probability to verify a hoax, and that to forget one's current belief. Simulations on homogeneous, heterogeneous, and real networks for a wide range of parameters values reveal a threshold for the fact-checking probability that guarantees the complete removal of the hoax from the network. Via a mean field approximation, we establish that the threshold value does not depend on the spreading rate but only on the gullibility and forgetting probability. Our approach allows to quantitatively gauge the minimal reaction necessary to eradicate a hoax.",
"author":"Marcella Tambuscio (University of Turin), Giancarlo Ruffo (University of Turin), Alessandro Flammini (Indiana University), Filippo Menczer (Indiana University)",
"betweenness":45745.5,
"cit":81,
"clustering":0.0539683,
"indegree":16,
"pagerank":3.98385e-05
}
```

### localhost:5000/search
You send a request with a list of parameters:
  - title
  - author
  - min_year
  - max_year
  - min_cit
  - max_cit

All parameters are optional.

For instance, if you send a request with parameters _title = "hoax"_ and _author = "Ruffo"_ it returns a json:

```
{"item-total-number":10,

"item-list":[

{"paper_id":"1105550512",
"title":"Fact-checking Effect on Viral Hoaxes: A Model of Misinformation Spread in Social Networks",
"year":2015,
"abstract":"spread of misinformation, rumors and hoaxes. The goal of this work is to introduce a simple modeling framework to study the diffusion of hoaxes and in particular how the availability of debunking information may contain their diffusion. As traditionally done in the mathematical modeling of information diffusion processes, we regard hoaxes as viruses: users can become infected if they are exposed to them, and turn into spreaders as a consequence. Upon verification, users can also turn into non-believers and spread the same attitude with a mechanism analogous to that of the hoax-spreaders. Both believers and non-believers, as time passes, can return to a susceptible state. Our model is characterized by four parameters: spreading rate, gullibility, probability to verify a hoax, and that to forget one's current belief. Simulations on homogeneous, heterogeneous, and real networks for a wide range of parameters values reveal a threshold for the fact-checking probability that guarantees the complete removal of the hoax from the network. Via a mean field approximation, we establish that the threshold value does not depend on the spreading rate but only on the gullibility and forgetting probability. Our approach allows to quantitatively gauge the minimal reaction necessary to eradicate a hoax.",
"author":"Marcella Tambuscio (University of Turin), Giancarlo Ruffo (University of Turin), Alessandro Flammini (Indiana University), Filippo Menczer (Indiana University)",
"betweenness":45745.5,
"cit":81,
"clustering":0.0539683,
"indegree":16,
"pagerank":3.98385e-05
},
... ]

}
```
