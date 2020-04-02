@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <a href="/home">Shop</a>
                    <br>
                    <br>
                    <a href="/shop/my_cart">My Cart</a>

                </div>


            </div>
        </div>



        <div class="col-md-9">
            <div class="card">
                <div class="card-header text-primary">
                    <b>Shop All!</b>
                </div>
                 
                <div class="card-body">
                    <div class="row">
                        @foreach($products as $obj=>$row)
                      <div class="col-sm-4">
                        <div class="card">
                            <img src="/images/{{ $row['image'] }}" style="max-height: 300px" class="img-responsive"> 
                        </div>
                        <div class="card-footer">
                            <h3>₱ {{$row['price']}}</h3>        
                            <a href="" class="btn btn-default addtocart" style="float: right;margin-top: -35px; color: maroon" id="{{$row['id']}}" role="button">
                                <i class="fa fa-cart-plus" ></i> Add to Cart</a>
                        
                        </div>
                      </div>
                      @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container">


  <!-- The Modal -->
  <div class="modal fade" id="formModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <form id="form" enctype="multipart/form-data" method="post" class="form-horizontal">
            {{csrf_field()}}
            <div class="modal-body">
                <span class="form_result"></span>

                <div class="row">
               
                    <div class="col">
                        <img id="image_preview_container" src="" alt="preview image" style="max-width: 370px;"> 
                    </div>
           
                    <div class=" col elements" style="margin-left: 2px;">
                        <input type="hidden" name="id" id="id">
                        <h3><label name="pcode" id="pcode"></label></h3>
                        <br>
                   
                        <label name="pordername" id="pordername"></label>
                      
                        <br>
                        <span>₱</span><label name="porderprice" id="porderprice"> </label>
                        <br>
                        <label>Available Stocks:</label>
                        <br>
                        <label name="stocks" id="stocks"></label>
                        <br>
                        <button type="submit" style="background: maroon; border: none; color: white" class="form-control buynow">Buy Now</button>
                        <br>
                        <input class="form-control" type="number" id="quantity" name="quantity" min="1" max="5">
                        <hr>
                        <label class="text-secondary">Product Description:</label>
                        <br>
                        <br>
                        <label class="text-secondary" name="porderdesc" id="porderdesc"></label>
                    </div>
                    
                 </div>  
            </div> 

 
        <div class="modal-footer">

        </div>
        </form>
        
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }); 

        //TO DISPLAY THE DATA USING MODAL
          $(".addtocart").on('click',function(e){
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url:'shop/'+id+'/view',
                method: 'GET',
                data:{
                    id:id
                },
                success:function(data){
                    $('#image_preview_container').attr('src','/images/'+data.image);
                    $('#id').text(data.id);
                    $('#pcode').text(data.product_code);
                    $('#pordername').text(data.name);
                    $('#porderprice').text( data.price);
                    $('#stocks').text(data.qty); 
                    $('#porderdesc').text(data.description);
                    $('#formModal').modal('show');
                },

            });
             
          });


          $('#form').on('submit', function(e){
            e.preventDefault();
            var id = $('#id').text();
            var pcode = $('#pcode').text();
            var stocks = $('#stocks').text();

            var porderprice = $('#porderprice').text();
            var quantity = $('#quantity').val();
            var pordername = $('#pordername').text();


            var totalprice =  quantity * porderprice;
            var grand_total = totalprice;
            var remaining_stocks = stocks - quantity;


      

            $.ajax({
                url:'/shop/'+id+'/add_to_cart',
                method:'POST',
                data:{
                    id,
                    pcode,
                    quantity, // no of prod ordered by the cust
                    porderprice, //amount of each product
                    pordername, //item
                    totalprice, //amount due to the cust
                    grand_total,
                    remaining_stocks

                },
                success:function(data){
                    location.reload();
                    alert('Item has been successfully added to your cart!');

                }

            });






          });
    });      

</script>


@endsection
