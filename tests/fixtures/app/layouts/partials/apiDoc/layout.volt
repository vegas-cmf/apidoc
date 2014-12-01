<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>API Documentation</title>
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.4/styles/default.min.css">

    <style>
        body{padding-top:50px}.sub-header{padding-bottom:10px;border-bottom:1px solid #eee}.navbar-fixed-top{border:0}.sidebar{display:none}@media (min-width:768px){.sidebar{position:fixed;top:51px;bottom:0;left:0;z-index:1000;display:block;padding:20px;overflow-x:hidden;overflow-y:auto;background-color:#f5f5f5;border-right:1px solid #eee}}.nav-sidebar{margin-right:-21px;margin-bottom:20px;margin-left:-20px}.nav-sidebar>li>a{padding-right:20px;padding-left:20px}.nav-sidebar>.active>a,.nav-sidebar>.active>a:focus,.nav-sidebar>.active>a:hover{color:#fff;background-color:#428bca}.main{padding:20px}@media (min-width:768px){.main{padding-right:40px;padding-left:40px}}.main .page-header{margin-top:0}.placeholders{margin-bottom:30px;text-align:center}.placeholders h4{margin-bottom:0}.placeholder{margin-bottom:20px}.placeholder img{display:inline-block;border-radius:50%}
    </style>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.4/highlight.min.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">API Documentation</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <form class="navbar-form navbar-right">
                <input type="text" id="search-api-phrase" class="form-control" placeholder="Search...">
            </form>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            {{ partial('apiDoc/partials/sidebar', ['collections': collections]) }}
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div class="container-fluid">
                <div class="row hide" id="search-not-found">
                    <div class="alert alert-warning">
                        Nothing found...
                    </div>
                </div>
                {% for collection in collections %}
                    {{ partial('apiDoc/partials/collection', ['collection': collection]) }}
                {% endfor %}
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        function syntaxHighlight(json) {
            if (typeof json !== 'string') {
                json = JSON.stringify(json, undefined, 2);
            }
            json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
                var cls = 'number';
                if (/^"/.test(match)) {
                    if (/:$/.test(match)) {
                        cls = 'key';
                    } else {
                        cls = 'string';
                    }
                } else if (/true|false/.test(match)) {
                    cls = 'boolean';
                } else if (/null/.test(match)) {
                    cls = 'null';
                }
                return '<span class="' + cls + '">' + match + '</span>';
            });
        }
        $('code.json').each(function(i, block) {
            var json = JSON.parse($(block).html());
            $(block).html(syntaxHighlight(json));
            hljs.highlightBlock(block);
        });
        $('.collapse').collapse();
        $('.nav-sidebar > li').on('click', 'a', function(e) {
            e.preventDefault();
            $('.nav-sidebar').find('li.active').removeClass('active');
            $(this).parent('li').addClass('active');

            $('body').animate({
                scrollTop: $($(this).attr('href')).offset().top
            });
        });
        $('#search-api-phrase').on('keyup', function() {
            if ($(this).val().length > 2) {
                var phrase = $(this).val();
                $('.title-primary').each(function() {
                    var reg = new RegExp(phrase, "i");
                    if ($(this).text().search(reg) === -1) {
                        $(this).parents('.panel-group').hide();
                    } else {
                        $(this).parents('.panel-group').show();
                    }
                });
                $('.nav-sidebar li').each(function() {
                    var reg = new RegExp(phrase, "i");
                    if ($(this).text().search(reg) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            } else {
                $('.panel-group').each(function() { $(this).show(); });
                $('.nav-sidebar li').each(function() { $(this).show(); });
            }

            if ($('.panel-group').find(':visible').length == 0 && $('.nav-sidebar li').find(':visible').length == 0) {
                $('#search-not-found').removeClass('hide');
            } else {
                $('#search-not-found').addClass('hide');
            }
        });
    });
</script>
</body>
</html>