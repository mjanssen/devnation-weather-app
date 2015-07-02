<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{% if title is defined %}{{ title }}{% else %}Weather App{% endif %}</title>

    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:100,200,300,400' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/dist/styles/weather-icons.min.css"/>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/dist/styles/main.css"/>
    <link rel="stylesheet" href="/dist/styles/style.css"/>

    <link id="favicon" rel="shortcut icon" href="/dist/images/favicon.png" type="image/png" />

    {% if styles is defined %}
        {% for style in styles %}
            <link rel="stylesheet" href="/dist/styles/{{ style }}.css"/>
        {% endfor %}
    {% endif %}

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
</head>
<body>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Weather</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    {#<li><a href="/">Home</a></li>#}
                    <li><a href="#" id="current">Current</a></li>
                    {#<li><a href="#">Map</a></li>#}
                    {% if user !== false %}
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Favorites<span class="caret"></span></a>
                        <ul class="dropdown-menu" id="favorites">
                        </ul>
                    </li>
                    {% endif %}
                </ul>
                <form class="navbar-form navbar-left" role="search" id="compare">
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" id="switch">Day</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{% if user == false %}User{% else %}{{ user['name'] }}{% endif %}<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            {% if user == false %}
                            <li><a href="/user/login">Login</a></li>
                            {% else %}
                            <li><a href="/user/logout">Logout</a></li>
                            {% endif %}
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container-fluid">
    {{ this.getContent() }}
    </div>


    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.2.1/backbone-min.js"></script>

    <script src="/_scripts/backbone/init.js"></script>
    <script type="text/javascript">site.settings = {{ js_settings }};</script>
    <script src="/dist/js/app.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</body>
</html>