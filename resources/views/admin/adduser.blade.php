@extends('layouts.adminapp')

@section('content')
<style>
    
        .wrapper {
  display: inline-flex;
  list-style: none;
}

.wrapper .icon {
  position: relative;
  background: #ffffff;
  border-radius: 50%;
  padding: 15px;
  margin: 10px;
  width: 50px;
  height: 50px;
  font-size: 18px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  transition: all 0.2s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.wrapper .tooltip {
  position: absolute;
  top: 0;
  font-size: 14px;
  background: #ffffff;
  color: #ffffff;
  padding: 5px 8px;
  border-radius: 5px;
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
  opacity: 0;
  pointer-events: none;
  transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.wrapper .tooltip::before {
  position: absolute;
  content: "";
  height: 8px;
  width: 8px;
  background: #ffffff;
  bottom: -3px;
  left: 50%;
  transform: translate(-50%) rotate(45deg);
  transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.wrapper .icon:hover .tooltip {
  top: -45px;
  opacity: 1;
  visibility: visible;
  pointer-events: auto;
}

.wrapper .icon:hover span,
.wrapper .icon:hover .tooltip {
  text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.1);
}

.wrapper .update:hover,
.wrapper .update:hover .tooltip,
.wrapper .update:hover .tooltip::before {
  background: #1877F2;
  color: #ffffff;
}

.wrapper .delete:hover,
.wrapper .delete:hover .tooltip,
.wrapper .delete:hover .tooltip::before {
  background: red;
  color: #ffffff;
}

.table {
  background-color: #eee;
  height: 100%;
  margin-bottom: 0;
}
.table-responsive {
  height: 100%;
}
</style>
        <div class="container" >
                <button class="btn btn--primary mt-4" id="modalbtn">Add Operator </button>
            <div class="row">
              <div class="col-md-12" id="operatortable">
                
                  
              </div>
            </div>
        </div>






        <div class="modal fade" id="modal1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                         
                        </button>
                        
                    </div>
                    <div class="modal-body">
                    </div>
                    </div>
            </div>
        </div>
@include("sections.adminfooter")
<script type="text/javascript">
    $(document).ready(function() {
        loadoptable();
       
    });
    $(document).on("click","#modalbtn",function(
        ) {
         loadopmodal();
         $("#modal1").modal("show");
    });
   $(document).on("submit","#addoperator",function(e) {
    e.preventDefault();
     $( "div[id*='error']" ).html("");
   $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
   $.ajax({
            url:"/admin/adduser",
            method:'post',
            dataType:'json',
            data:$("#addoperator").serializeArray(),
             error: function (request, status, error)
                 {
                   
                   if(request.responseJSON['errors'])
                   {
       $.each(request.responseJSON['errors'],function(index,v){
                divid="error-"+index;
        $("#"+divid).addClass("text-danger").html(v);
                             });}

    },
            success:function(data)
            {
 
            $("#modal1").modal("hide");
            // $("form[input]").val("");
            // $(#addoperator).closest('form').find("input[type=text]").val("");
            $("#addoperator").trigger("reset");
    
        }
    });
   });
    $(document).on("submit","#updateoperatordata",function(e) {
    e.preventDefault();
     $( "div[id*='error']" ).html("");
   $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
   $.ajax({
            url:"/admin/updateoperatordata",
            method:'post',
            dataType:'json',
            data:$("#updateoperatordata").serializeArray(),
             error: function (request, status, error)
                 {
                   
                   if(request.responseJSON['errors'])
                   {
       $.each(request.responseJSON['errors'],function(index,v){
                divid="error-"+index;
        $("#"+divid).addClass("text-danger").html(v);
                             });}

    },
            success:function(data)
            {
 
            $("#modal1").modal("hide");
           loadoptable();
           loadopmodal();
    
        }
    });
   });
   $(document).on("click",".opid",function() {
   

id=this.id;
 
   $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
   $.ajax({
            url:"/admin/updateoperatormodal",
            method:'post',
            dataType:'json',
            data:{id:id,option:"update"},
            
            
            success:function(data)
            {

            $("#modal1 .modal-body").html(data.a);
            $("#modal1 .modal-title").html("Update Operator");
            $("#modal1").modal("show");
          
    
        }
    });
   });
   $(document).on("click",".delid",function() {
   

id=this.id;
 
   $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
   $.ajax({
            url:"/admin/deleteoperator",
            method:'post',
            dataType:'json',
            data:{id:id},
            
            
            success:function(data)
            {

            loadoptable();
           alert("deleted");
          
    
        }
    });
   });
   function loadoptable()
   {
      $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
      $.ajax({
            url:"/admin/operatortable",
            method:'post',
            dataType:'json',
            data:$("#addoperator").serializeArray(),
                         success:function(data)
            {
                            
                    $("#operatortable").html(data.a);
            }
    });
   }
     function loadopmodal()
   {
      $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
      $.ajax({
            url:"/admin/updateoperatormodal",
            method:'post',
            dataType:'json',
            data:{option:"add"},
                         success:function(data)
            {
                    $("#modal1 .modal-title").html("Add Operator")  
                    $("#modal1 .modal-body").html(data.a);
            }
    });
   }
</script>
@endsection
			