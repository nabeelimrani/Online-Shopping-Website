@extends('layouts.adminapp')
@section('content')

<div class="container" >
    <div class="row">
        <div class="col-md-12">
            <div class="table-resposive">
                  <table class="table table-bordered " id="entrytable">
                <thead>
                        <th></th>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Vendor Name</th>
                        <th>Payment Mode</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Description</th>
                        
                </thead>
                <tbody>
                @foreach($payments as $payment)
               <tr>
                <td>
                  <div class="d-flex justify-content-center">
                    <i class="fa fa-trash text-danger delpayment" id="{{$payment->id}}" role="button"></i>

                 
                    </div>
                </td>
               
                   <td>{{$payment->id}}</td>
                   <td>{{$payment->created_at->format('Y-m-d')}}</td>
                   <td>{{$payment->vendor->name}}</td>
                   <td>{{$payment->paymentmode->pmode}}</td>
                   <td>{{$payment->debit}}</td>
                   <td>{{$payment->credit}}</td>
                   <td>{{$payment->description}}</td>
                  
               </tr>
               @endforeach
                </tbody>
                  <tfoot>
                    <tr>
                    <th></th>
                    <th></th>
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
<div class="modal fade" id="addpayment" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">Product Entry</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        <div class="checkout-form">
            <form method="post" action="{{route('addpayment')}}" >
                                @csrf
                                <span id="formdata">
                                    <div id="billing-form" class="mb-40">
                                        <div class="row">
                                        
                                            <div class="col-md-12 col-12 mb--20">
                                                    <label>Vendor</label>
                                                    <select required name="vid" id="vid" class="form-control">
                                                        <option value="">Select Vendor</option>
                                                        @foreach($vendors as $vendor)
                                                        <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-12 mb--20 bal" style="display:none">
                                                <input required type="text" id="balance" placeholder="Balance" readonly>
                                            </div>

                                                 <div class="col-md-12 col-12 mb--20">
                                                    <label>Method</label>
                                                    <select required name="pmode" class="form-control">
                                                        
                                                        @foreach($modes  as $pmode)
                                                        <option value="{{$pmode->id}}">{{$pmode->pmode}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                
                                                 <div class="col-md-12 mb--20 " >
                                                    <label>Amount</label>
                                                <input required type="text" id="namount" name=namount placeholder="Amount" >
                                                <input type="hidden" id="flag" name=flag value="">
                                            </div>
                                             
                                            <div class="col-md-12 col-12 mb--20">
                                                <label>Description*</label>
                <textarea required  name="description" placeholder="Description" class="form-control"></textarea>
                                            </div>
                                           

                                              
                                        </div>
                                        <div class="col-md-10 mx-auto">
                                    <button type="submit" class="btn btn--primary">Submit</button>
                                </div>
                                    </div>
                                </span>
                                
                             </form>
                        </div>
      </div>
      <div class="modal-footer">
        <button type="button" data-bs-dismiss="modal" class="btn btn--primary">close</button>
      </div>
    </div>
  </div>
</div>

<!-- <'d-flex justify-content-between my-3'l<'my-2'fB>>t<'d-flex justify-content-between my-3'ip> -->
@include("sections.adminfooter")
<script type="text/javascript">

$(document).ready(function () {

$('#entrytable').DataTable({
"language":{
buttons: {
pdf: 'PDF',
},
},
"scrollY":400,
// "scrollX":true,
"lengthMenu":[[50,100,-1],[50,100,"all"]],
"pageLength":50,
"dom":"<'d-flex justify-content-between my-2'<'my-1'l><'d-flex justify-content-end'fB>>t<'d-flex justify-content-between'<'my-3'i><'my-3'p>>",
buttons:[
{ extend: 'excel', className: 'btn  mx-2',footer: true },
{ extend: 'pdf', className: 'btn  mx-2',footer: true },
{ extend: 'print', className: 'btn  mx-2',footer: true },
{
"text":"Add payment",
className:'btn dt-button mx-2',
"action":function(){
    $("#addpayment").modal("show");
}
},
],
"initComplete": function() {
// $('body').find('.dataTables_scrollBody').addClass("scrollbar");
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
                .column(5, { page: 'end'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                        }, 0);
                  
                       
        $( api.column(5).footer() ).html("Rs "+numberWithCommas(total));
        
       
},

});
});




$("#vid").change(function(){


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
     $.ajax({
            url:"/getbalance",
            method:'post',
            data:{vid:$("#vid").val()},
            success:function(data)
            {
             
            $(".bal").show();
            $("#balance").val(data);
            $("#namount").focus();
        
            }
        });

   
});





$(document).on("click",".delpayment",function(e) {
    e.preventDefault();

    id=this.id;
    $.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
    swal({
    title: 'Are you sure?',
    text: 'Once deleted, you will not be able to recover this',
    icon: 'warning',
    buttons: true,
    dangerMode: true,
  })
    .then((willDelete) => {
      if (willDelete){
$.ajax({
url:"/delpayment",
method:'post',
dataType:'json',
data:{id:id},
success:function(data)
{
    window.location.href="/payment";
}
});
}
});
});


</script>
@endsection