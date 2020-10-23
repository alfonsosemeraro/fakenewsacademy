<!DOCTYPE html>
<html lang="en">
    <head>
        <title>The FakeNews Academy</title>
        <meta charset="utf-8" >
        <link href="css/index.css" type="text/css" rel="stylesheet"> 
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="javascript/jqcloud.js"></script>
        <link rel="stylesheet" href="css/jqcloud.css">
        <script src="javascript/word-cloud.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>   
        <script src="javascript/bar.js" type="text/javascript"></script>
        <script src='https://cdn.plot.ly/plotly-latest.min.js'></script>
        <script src="javascript/map.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="nav">
            <ul>
                <li><a href="#logo">Logo</a></li>
                <li><a href="index.php">Home</a></li>
                <li><a href="#news">News</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="#about">About</a></li>
            </ul>
        </div>
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
                            <select name="year">
                                <option selected="selected" value=<?= date("Y")-4 ?>-<?= date("Y") ?>><?= date("Y")-4 ?>-<?= date("Y") ?></option>
                                <option value=<?= date("Y")-20 ?>-<?= date("Y")-5 ?>><?= date("Y")-20 ?>-<?= date("Y")-5 ?></option>
                                <option value=<?= date("Y")-21 ?>>fino al <?= date("Y")-21 ?></option>
                            </select>
                            <select name="name">
                                <option>scegli</option>
                                <option></option>
                            </select>
                            <select name="cit">
                                <option selected="selected" value="650">da 650 citazioni in su</option>
                                <option value="0">qualsiasi numero di citazioni</option>
                            </select>
                        </div>
                        <div class="row">
                            <select name="name">
                                <option>scegli</option>
                                <option></option>
                            </select>
                            <select name="name">
                                <option>scegli</option>
                                <option></option>
                            </select>
                            <select name="name">
                                <option>scegli</option>
                                <option></option>
                            </select>
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
        <div id="container"></div>
        <div id="graph">
            <canvas id="myCanvas"></canvas>
            <canvas id="myCanvas-max"></canvas>
            <canvas id="canvas"></canvas>
            <canvas id="canvas-max"></canvas>
        </div>
        <div id="myDiv"></div>
    </body>
</html>
