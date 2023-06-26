   <!--=================================
    Footer Area
    ===================================== -->
    <footer class="footer-bottom">
        <div class="container">
            <div class="row justify-content-between  section-padding">
               
       
        
            
                <p class="copyright-heading">Suspendisse in auctor augue. Cras fermentum est ac fermentum tempor. Etiam
                    vel
                    magna volutpat, posuere eros</p>
                <a href="#" class="payment-block">
                    <img src="image/icon/payment.png" alt="">
                </a>
                <p class="copyright-text">Copyright © 2022 <a href="#" class="author">Pustok</a>. All Right Reserved.
                    <br>
                    Design By Pustok</p>
         </div>
        </div>


    </footer>
    
<script src="{{asset('js/plugins.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
<script>

        $(document).on("show.bs.modal","#quickModal",function(event){
    
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

        var button=$(event.relatedTarget);  
        var id=button.data("id");
        $.ajax({
            url:"getdetail",
            method:'post',
            data:{id:id},
            dataType:'json',
            success:function(data)
            {
                $("#mainimage").html(data.image);
                $("#ptitle").html(data.title);
                $("#pprice").html(data.price+'-PKR');
                $("#discountprice").html(data.dprice+'-PKR');
                $("#des").html(data.description);
                $(".catname").html(data.catname);
                $("#pid").val(data.pid);
                $("#pqty").val(data.qqty);

                
            }
        });
    });

   $(document).on("submit","#addtocart",function(event){
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
                event.preventDefault();
            id=$("#pid").val();
            qty=$("#pqty").val();

    
        $.ajax({
            url:"additem",
            method:'post',
            data:{id:id,qty:qty},
            dataType:'json',
            success:function(data)
            {
                 $("#quickModal").html();
                  $("#quickModal").modal("hide");
                  loadcart();
            }
        });
    });
     $(document).on("click",".removeproduct",function(event){
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
              
            id=this.id;
         
      
        $.ajax({
            url:"removeproduct",
            method:'post',
            data:{id:id},
            dataType:'json',
            success:function(data)
            {
              
                  loadcart();
                  loadcartpage();
            }
        });
    });
function loadcart()
{
            $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

    $.ajax({

        url:'loadcart',
        method:'post',
        dataType:'json',
        success:function(data) {
            $("#cartbox").html(data.output);
            $("#totalitem").html(data.total);
            $("#totalprice").html(data.tprice);
        }
    });
}
</script>