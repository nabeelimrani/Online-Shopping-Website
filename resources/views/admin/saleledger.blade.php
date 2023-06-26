@extends('layouts.adminapp')
@section('content')


<!-- Cart Page Start -->
<main class="cart-page-main-block inner-page-sec-padding-bottom">
    <div class="cart_area cart-area-padding  ">
        <div class="container">

                    <div class="row mb-5">

                            <div class="col-md-6  mx-auto">
                                <div class="card shadow">
                                    <div class="card-body">
                                         <form method=post  action="{{route('searchsaleledger')}}">
                                            @csrf

                                            <div class="row">
       <div class="col-md-6"><input tye=text id="sdate" name="sdate" class="form-control datepicker" autocomplete="off" value="{{date('Y-m-d')}}"></div>
        
         <div class="col-md-6">                                          

                        <div class="input-group">
                            <input tye=text id="edate" name="edate" class="form-control datepicker" autocomplete="off" value="{{date('Y-m-d')}}">


                            <button class="btn btn--primary"><i class="fa fa-search"></i></button>
    
                        </div>
</div>
                    </div>
                         </form>
                                    </div>
                                </div>

                            </div>

                        
                       
    </div>

            <div class="table-responsive">
             <table class="table" id="producttable" style="width:100%">
                <thead>
                    <tr>
                  
                    <th>Sno</th>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Total</th>
                    <th>Discount</th>
                    <th>Net Amount</th>
                    
                    
                    
                   
                </tr>
                    
                </thead>

                <tbody>
                    @if(!empty($sales))
                 @foreach($sales as $sale)
                     <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$sale->user_id}}</td>
                        <td>{{$sale->user->username}}</td>
                        <td>{{$sale->total}}</td>
                        <td>{{($sale->discount*$sale->total/100)}}</td>
                        <td>{{$sale->total-($sale->discount*$sale->total/100)}}</td>
                       
                                        
                       
                    </tr>
                @endforeach
                @endif

                </tbody>

                 <tfoot>
                    <tr>
                  
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    
                    
                    
                    
                   
                </tr>
                    
                </tfoot>


            </table>
        </div>
        </div>
       
    </div>
</div>
</div>

</main>
<!-- Cart Page End -->
</div>




 


@include("sections.adminfooter")

<script>
$(document).ready(function () {
    

    $('#producttable').DataTable({

        "language":{
                        
                            buttons: {
                pdf: 'PDF',
                
            },
                            
                        }   ,
        "scrollY":500,
        "scrollX":true,
        "pageLength":50,
        "sort":false,
        "bsort":false,
    "lengthMenu":[[50,100,200,-1],[50,100,200,"All"]],
    

    dom: "<'d-flex justify-content-between my-3'<'mb-y'l><'text-right'<'d-flex justify-content-end'fB>>>t<'d-flex justify-content-between'<'my-3'i><'my-3'p>>",
        "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    buttons:[
         { extend: 'print', className: 'btn  mx-2',footer: true },
            { extend: 'excel', className: 'btn',footer: true },
            { extend: 'pdf', className: 'btn' ,footer: true},
        



        ],



    "initComplete": function() {
    $('body').find('.dataTables_scrollBody').addClass("scrollbar");
     $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
},


footerCallback: function ( row, data, start, end, display ) {
         
        
            var api = this.api(),data;
            console.log(api);
            
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            
            function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
            
            
            var total = api
                .column(3, { page: 'end'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                        }, 0);
                        var total1 = api
                .column(4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                        }, 0);
                        var total2 = api
                .column(5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                        }, 0);
                       
        $( api.column(3).footer() ).html("Rs "+numberWithCommas(total));
        $( api.column(4).footer() ).html(numberWithCommas(total1));
        $( api.column(5).footer() ).html(numberWithCommas(total2));;
        
       
},
    
    
    
    
   
    });






   
});
</script>

@endsection
