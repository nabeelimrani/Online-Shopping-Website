@extends('layouts.adminapp')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Shantell+Sans:ital@1&display=swap" rel="stylesheet">
   <style>
       .mcard{
        font-family: 'Shantell Sans', cursive;
        width: 100%;
        height: 150px;
        background: grey;
        padding: 10px;
        background:#fefefe;
        text-align:center;
        box-shadow:#999 2px 2px,#ccc 4px 4px,-2px -2px,#ccc -4px -4px;
        margin-top:50px;
        color:navy; 
        transform:skewY(-4deg);
       }
       .text1
        {
        font-family: 'Shantell Sans', cursive;
        font-size:30px;  
        color:black;
       
         }
         .mcard:hover {

    transform:skewY(0deg);

}
   </style>
        <!-- Cart Page Start -->
        <main class="cart-page-main-block inner-page-sec-padding-bottom">
            <div class="cart_area cart-area-padding  ">
                <div class="container">
                   <div class="row">
                       <div class="col-md-3">
                           <div class="mcard">
                               <h1>Today Sale</h1>
                               <span class="text1">{{$csale}}</span>
                           </div>
                       </div>  
                        <div class="col-md-3">
                           <div class="mcard">
                               <h3>Today's Pending Sale</h3>
                               <span class="text1">{{$pendingsale}}</span>
                           </div>
                       </div>      
                          <div class="col-md-3">
                           <div class="mcard">
                               <h2>Monthly Sale</h2>
                               <span class="text1">{{$msales}}</span>
                           </div>
                       </div>
                           <div class="col-md-3">
                           <div class="mcard">
                               <h2>Sold Sale</h2>
                               <span class="text1">{{$soldproducts}}</span>
                           </div>
                       </div>
                  
                   </div>
                   <div class="row my-3">
                    <div class="col-md-6 mt-2">

                       <div id="chart"></div>
                       </div>
                   </div>
                </div>
            </div>


        </main>

@include("sections.adminfooter")
<script>
 

         var options = {
         {{$data1}},
        {!! $labels1 !!},
          chart: {
          width: 380,
          type: 'pie',
        },
         
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

</script>
@endsection
			