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
<link rel="stylesheet" type="text/css" href="{{asset('DataTables/datatables.min.css')}}"/>
     <link rel="stylesheet" type="text/css" media="screen" href="{{asset('datepicker/bootstrap-datepicker.css')}}" />



</head>
<style>
.table-responsive {
padding:20px;
background:#fff;
box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
}
button.dt-button{
border:none !important;
background: none !important;
color:green !important;
min-height: 30px !important;
font-size:12px !important;
padding:0px !important;
}
.dataTables_filter{
font-size: 12px  !important;
}
.dataTables_filter input{
line-height: 10px !important;
height:30px !important;
font-size:12px !important;
}
.dataTables_length select {
height:25px !important;
font-size:12px !important;
}
.dataTables_length{
font-size:12px !important;
}
table.dataTable{
border-collapse: collapse !important;
box-shadow: inset 0px 11px 8px -10px #32de84, inset 0px -11px 8px -10px #0BDA51;
}
table.dataTable thead {
padding: 5px 5px 5px 20px !important;
}
table.dataTable thead th {
color: #ddd;
background: #00693E;
color:#fefefe;
font-size: 10px;
border: 1px solid #ddd !important;
border-bottom: 1px solid #b5b0b0 !important;
}
.dataTables_wrapper .dataTables_paginate {
color: white !important;
border: 1px solid black;
height:35px !important;
line-height:15px !important;
font-size:12px !important;
background: #00693E;
background-color:#00693E important;
}
.dataTables_info {
font-size:12px !important;
}

</style>
<body>
  @include("sections.adminmenu")
       

  
            @yield('content')
  

</body>



</html>
