@extends('admin.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Admin</div>

                <div class="card-body">

                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">EDIT</div>

                <div class="card-body">


                    <div class="modal-content">
                      
                        <!-- Modal Header -->
                        <div class="modal-header">
                         
                            <h3>
                                <label class="text-primary">{{$product->product_code}}</label>
                            </h3>

                        </div>
                        
                        <form id="form" enctype="multipart/form-data" class="form-horizontal">

                            {{csrf_field()}}

                            <div class="modal-body">

                                 <div class="form-group">

                                    <div class="row">

                                        <div class="col-md-4" >

                                            <div class="thumbnail" align="center">

                                                <img id="image_preview_container" src="{{ URL:: to('/')}}/images/{{ $product->image }}" 

                                                alt="preview image" style="max-height: 330px;"> 

                                                <span id="store-image"></span> 

                                                <!-- <input type="hidden" name="hidden_image" value="{{ $product->image }}" /> -->

                                            </div>

                                            <div  class="mt-2">

                                                <input type="file" name="pimage" id="pimage"> 

                                            </div>

                                        </div>



                                        <div class="col-md-8" >

                                            <div class="form-group">

                                                <div class="row">

                                                    <div class="col-md-3">

                                                        <label>Name:</label>

                                                    </div>

                                                    <div class="col-md-9" >

                                                        <input type="text" id="pname" name="pname" class="form-control" value="{{ $product->name }}" >
                                                     

                                                    </div>

                                                </div>  

                                            </div>


                                            <div class="form-group">

                                                <div class="row">

                                                    <div class="col-md-3">

                                                        <label>Qty:</label>

                                                    </div>

                                                    <div class="col-md-9" >

                                                        <input id="qty" name="qty" class="form-control" value="{{ $product->qty }}" > 

                                                    </div>

                                                </div>  

                                            </div>



                                            <div class="form-group">

                                                <div class="row">

                                                    <div class="col-md-3">

                                                        <label>Price:</label>

                                                    </div>

                                                    <div class="col-md-9" >

                                                        <input id="price" name="price" class="form-control" value="{{ $product->price }}" >

                                                    </div>

                                                </div>  

                                            </div> 



                                            <div class="form-group">

                                                <div class="row">

                                                    <div class="col-md-3">

                                                        <label>Description:</label>

                                                    </div>

                                                    <div class="col-md-9" >

                                                        <input class="form-control" id="desc" name="desc" value="{{ $product->description }}">

                                                    </div>

                                                </div>  

                                            </div> 

                                        </div>


                                    </div>  

                                </div> 
                              

                            </div> 

                            <!-- Modal footer -->
                            <div class="modal-footer" >

                                <button type="submit" name="action_button" class="btn btn-default text-primary edit" id="{{ $product->id }}" >

                                    <i class="fa fa-save"></i> Save</button>                                

                                <a href="/admin" name="create" class="btn btn-default text-secondary addProduct" style="float: left;">

                                    <i class="fa fa-reply"></i>Back</a>



                            </div>

                        </form>
                        
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


          //Image change
          $('#pimage').change(function(){

            let reader = new FileReader();
            reader.onload = (e) => { 
              $('#image_preview_container').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 

          });

          $('.edit').on('click', function(e){
            e.preventDefault();
            // var id = $(this).attr('id');
            
            var formData = new FormData(this);
            $.ajax({
                type:'POST',
                url:  "{{ url('save-product')}}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data) {
                    console.log(data);
                    alert('Data has been added successfully');
                    // window.location.assign('/admin'); 
                    location.reload();
                                       
                },
                error:function(data){
                    console.log(data.responseJSON.errors);
                }             
            });


          });







    });    


</script>


@endsection