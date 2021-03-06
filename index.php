<?php include_once 'bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    <link href="<?=base_url?>assets/style.css" rel="stylesheet">
    
    <script>
        window.app = window.app || {};
        app.baseUrl = '<?=base_url?>';
        app.showModal = function(){
            $(".containermodal").show();
        };
        app.hideModal = function(){
            $(".containermodal").hide();
        };
    </script>
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" ng-app="CoolingApp">

        <div ng-controller="CoolingController" class="starter-template">
          <h1 class="title-underlined">Upload CSV of cooling data</h1>
          <form>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xs-12 form-inline">
                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-xs-6 form-group">
                            <input type="file" name="cooling_data" id="cooling_data" />
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-6 form-group">
                            <button class="btn btn-primary" ng-click="uploadAndGenerate('cooling_data','filename')">
                                Upload
                            </button>
                        </div>                    
                    </div>
                </div>
            </div>
          </form>
        <div id="chartContainer" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
      </div>

        <div class="containermodal">
            Loading Please Wait...
        </div>
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.11/angular.min.js"></script>
    <script src="<?=base_url?>app.js"></script>
  </body>
</html>
