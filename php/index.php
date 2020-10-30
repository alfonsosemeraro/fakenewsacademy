<!DOCTYPE html>
<html lang="en">
    <head>
        <!--
            Autore: Calabrese Camilla
            Contenuto: pagina iniziale del sito
         -->
        <title>The FakeNews Academy</title>
        <meta charset="utf-8" >
        <link href="../css/index.css" type="text/css" rel="stylesheet"> 
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="../javascript/jqcloud.js"></script>
        <link rel="stylesheet" href="../css/jqcloud.css">
        <script src="../javascript/word-cloud.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>   
        <script src="../javascript/bar.js" type="text/javascript"></script>
        <script src='https://cdn.plot.ly/plotly-latest.min.js'></script>
        <script src="../javascript/map.js" type="text/javascript"></script>
    </head>
    <body>
    <div id="body">
        <div id="nav">
            <ul>
                <li><a href="index.php">Logo</a></li>
                <li><a href="../html/project.html">Project</a></li>
                <li><a href="../html/methods.html">Methods</a></li>
                <li style="float:right"><a href="../html/about.html">About us</a></li>
            </ul>
        </div>
        <div><img src="../img/wave.jpg" alt="wave"/></div>
        <div id="form">
            <form action="results.php" method="POST">
                <div class="inner-form">
                    <div class="basic-search">
                        <div class="input-field">
                            <input type="text" id="search" placeholder="Type Keywords" name="search">
                            <div class="icon-wrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="advance-search">
                        <span class="desc">ADVANCED SEARCH</span>
                        <div class="row">
                            <label><strong>Years:</strong></label>                           
                            <input type="text" id="year-min" placeholder="starting year" name="year-min"> -
                            <input type="text" id="year-max" placeholder="final year" name="year-max">
                        </div>
                        <div class="row">
                            <label><strong>Cit:</strong></label>
                            <input type="text" id="cit-min" placeholder="min number of cit" name="cit-min"> -
                            <input type="text" id="cit-max" placeholder="max number of cit" name="cit-max">
                        </div>
                        <div class="row">
                            <label><strong>Author:</strong></label>
                            <input type="text" id="author" placeholder="Author" name="author">
                        </div>
                        <div class="row">
                            <div class="btn">
                                <button type="reset" class="btn-delete" id="delete">RESET</button>
                                <button type="submit" class="btn-search" id="search-btn">SEARCH</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="info-cont">
            <div id="information">
                <h2>4000+ papers</h2>
                <p>Search among thousands of works about the disinformation problem</p>
            </div>
            <div id="information">
                <h2>68000+ citations</h2>
                <p>Explore paper citations and find subfields, topics and communities</p>
            </div>
            <div id="information">
                <h2>Always updated</h2>
                <p>Fakenewsacademy is constantly up-to-date. Don't miss the latest out!</p>
            </div>
        </div>
        <hr>
        <div id="graph">
            <div id="informations">
                <p>
                    The problem of disinformation online has become a big concern in the last years, 
                    after fake news allegedly affected elections and modified the relationship 
                    between democracies and citizens. The scientific community promptly responded 
                    with a massive production of studies, analyses, experiments and tests, but the 
                    journey has just started.
                </p>
            </div>
            <div class="art-year">
                <div class="myCanv">
                    <canvas id="myCanvas"></canvas>
                </div>
                <div class="myCanv">
                    <canvas id="myCanvas-max"></canvas>
                </div>
            </div>
        </div>
        <div id="informations">
            <p>
                What do we talk about when we talk about fake news? Here it is a wordcloud with all 
                the most important keywords, taken from the titles and abstracts of the papers. 
                Click on a word to retrieve all the articles about it.               
            </p>
        </div>
        <div id="container"></div>
        <div id="graph">
            <div id="informations">
                <p>
                    Disinformation online is a worldwide concern, as it deteriorates the regular 
                    functioning of democracies. The role of social media in elections has been 
                    pointed out especially after 2016. Which country did researchers focus on 
                    the most? Which year is studied the most?
                </p>
            </div>
            <div class="art-year">
                <div class="myCanv">
                    <canvas id="canvas"></canvas>
                </div>
                <div class="myCanv">
                    <div id="myDiv"></div>
                </div>
            </div>
        </div>
    <div>
    </body>
</html>
