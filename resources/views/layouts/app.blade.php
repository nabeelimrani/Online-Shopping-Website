<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
      <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/plugins.css')}}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/main.css')}}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('chart/apexcharts.css')}}" />



</head>
<style>
  .rating {
  font-size: 20px;
  color: #f7d74c;
}

.rating .ion-android-star-outline {
  display: inline-block;
  font-size: inherit;
  color: #ddd;
  cursor: pointer;
}

.rating .ion-android-star-outline.star_on {
  color: #f7d74c;
}
</style>
<body>
  @include("sections.menu")
       

  
            @yield('content')
  

</body>



</html>
