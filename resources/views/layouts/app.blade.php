
<html>
    <head>
   		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @yield('meta')

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Semantic UI -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">

        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <title>Bluemarket - @yield('title')</title>
    </head>
    <body>
        <div class="ui secondary pointing menu bluemarketheader" id="bluemarketheader">
            <div class="right menu">
                <a class="{{ Request::is('/') ? 'active item' : 'item' }}" href="{{ url('/') }}">
                    Home
                </a>
                <a class="{{ Request::is('projects') ? 'active item' : 'item' }}" href="{{ url('projects') }}">
                    Projects
                </a>
                <a class="{{ Request::is('login') ? 'active item' : 'item' }}" id="loginBtn" href="{{ url('login') }}">
                    Login
                </a>
            </div>
        </div>
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
