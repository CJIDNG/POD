<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">

    <meta property="fb:app_id" content="123456789">
    <meta property="og:url" content="">
    <meta property="og:type" content="">
    <meta property="og:title" content="">
    <meta property="og:image" content="">
    <meta property="og:image:alt" content="">
    <meta property="og:description" content="">
    <meta property="og:site_name" content="">
    <meta property="og:locale" content="en_US">
    <meta property="article:author" content="">

    <meta name="twitter:card" content="">
    <meta name="twitter:site" content="">
    <meta name="twitter:creator" content="">
    <meta name="twitter:url" content="">
    <meta name="twitter:title" content="">
    <meta name="twitter:description" content="">
    <meta name="twitter:image" content="">
    <meta name="twitter:image:alt" content="">

    <link rel="author" href="">
    <link rel="publisher" href="">
    <meta itemprop="name" content="">
    <meta itemprop="description" content="">
    <meta itemprop="image" content="">

    <meta name="google" content="notranslate">

    @stack('meta')

    <title>{{ $currentTenant['platform']['display_name'] ?? $currentTenant['platform']['name'] }}</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Karla|Merriweather:400,700,900">

    @if($currentTenant['darkMode'])
        <link rel="stylesheet" id="baseStylesheet" type="text/css" href="{{ mix('css/app-dark.css') }}">
        <link rel="stylesheet" id="highlightStylesheet" href="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.18.1/build/styles/sunburst.min.css">
    @else
        <link rel="stylesheet" id="baseStylesheet" type="text/css" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" id="highlightStylesheet" href="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.18.1/build/styles/github.min.css">
    @endif

    <script src="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.18.1/build/highlight.min.js"></script>
    <script src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

    <link rel="shortcut icon" href="{{ mix('favicon.ico') }}">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
</head>
<body>
<div id="app">
    <router-view></router-view>
</div>

@javascript('CurrentTenant', $currentTenant)

<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</body>
</html>
