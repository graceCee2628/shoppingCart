@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-9">
            <div class="card">
                <div class="card-header text-primary">
                    <b>My Cart</b>
                </div>
                 
                <div class="card-body">
                        <div class="table-responsive" >
                            <table id="myTable" class="table table-bordered table-striped mt-5" >
                                <thead>
                                    
                                    <tr>
                                     
                                        <th>Product Code</th>
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $Summary = 0;
                                        
                                    ?>

                                    @foreach($carts as $cart)
                                        <?php

                                            $Summary += $cart->amount_due ;
                                        ?>

                                    <tr>
                                        <td> {{$cart->prod_code}}</td>
                                        <td> {{$cart->prod_item}}</td>
                                        <td> {{$cart->price}}</td>
                                        <td> {{$cart->prod_qty}}</td>
                                        <td> {{$cart->amount_due}}</td>
                                        <td>
                                            <center>
                                 
                                                <a href="" type="submit" class="delete" id="{{$cart->id}}"><i class="fa fa-trash" style="color: maroon" ></i></a>
                                            </center>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <a href="/home" class="btn btn-default text-primary" style="float: right"> <i class='fas fa-reply text-primary' ></i> Back To Shop</a>
                </div>




            </div>
        </div>


        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Order Summary</div>

                <div class="card-body">

                    <div class="col mt-3">

                        <b style="color: maroon">

                            <label>Amount Due:</label>
                            
                                        
                            <span>&nbsp;&nbsp;₱</span>&nbsp;&nbsp;&nbsp;<label name="dueAmount" id="dueAmount">{{$Summary}}</label>

                        </b>

                        <br>
                        <br>
                        <a href="/home" class="btn btn-default form-control" style="background: rgba(0,0,0,0.4);"> Continue Shopping</a>
                        <br>
                        <br>
                        <a href="/shop/checkout" class="btn form-control checkOut" style="background: maroon; border: none; color: white">Check Out</a>

                                    
                    </div>


                </div>


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

            $('.delete').on('click', function(e){
                e.preventDefault();
                var id = $(this).attr('id');
                
                $.ajax({
                    method:'POST',
                    url:'/shop/'+id+'/delete_cart_item',
                    data:{
                        id
                    },
                    success:function(response){
                        location.reload();
                        alert('Item is deleted!');

                    }
                });

            });

            // $('.checkOut').on('click', function(e){
            //     e.preventDefault();

            //     var dueAmount = $('#dueAmount').text();
            //     $.ajax({
            //         method:'POST',
            //         url:'/shop/checkout',
            //         data:{
            //             dueAmount
            //         },
            //         success:function(){
                        
            //         }
            //     })


            // })





    });      

</script>


@endsection
