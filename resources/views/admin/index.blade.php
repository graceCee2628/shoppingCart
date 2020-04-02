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
                <div class="card-header">Admin</div>
                <div class="card-body">
                    <h4 class="modal-title" >
                        <label class="text-primary">Product Lists</label>
                    </h4>
                    <div class="output_results"></div> <!--For alert -->
                    <div class="modal-content">
                        <div class="modal-header" >
                            <a href="" name="create" class="btn btn-success addProduct" style="float: right;"><i class="fa fa-plus"></i>  Add Product</a>
                        </div>

                        <div class="table-responsive" >
                            <table id="myTable" class="table table-bordered table-striped" >
                                <thead>
                                    
                                    <tr>
                                        <th>Image</th>
                                        <th>Product Code</th>
                                        <th>Product Name</th>
                                        <th>QTY</th>
                                        <th>Price</th>
                                        <th>Description</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                
                                <tbody>
                                    
                                    @foreach($products as $obj=>$row)
                                        
                                    <tr>

                                        <td><img src="/images/{{ $row['image'] }}" class="" width="75"> 
                                        </td>
                                        <td>{{$row ['product_code'] }}</td>
                                        <td>{{$row ['name'] }} </td>
                                        <td>{{$row ['qty'] }} </td>
                                        <td>{{$row ['price'] }} </td>
                                        <td>{{$row ['description'] }} </td>
                                        <td>
                                            <a href="admin/{{$row ['id']}}" id="{{$row ['id'] }}" class="btn btn-success btn-sm edit"><i class="fa fa-edit"></i></a>
                                            <a href="" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></a>
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="container">


  <!-- The Modal -->
  <div class="modal fade" id="formModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add New Product</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <form id="form" enctype="multipart/form-data" method="post" class="form-horizontal">
            {{csrf_field()}}
            <div class="modal-body">
                <span class="form_result"></span>

                 <div class="form-group">
                    <div class="row">
                        <div class="col-md-12" >
                            <div class="thumbnail" align="center">
                                <img id="image_preview_container" src="" 
                                alt="preview image" style="max-height: 150px;">                                              
                            </div>
                            <div style="margin-left: 40%" class="mt-2">
                                <input type="file" name="pimage" id="pimage"> 
                                <!-- <span id="store_image"></span> -->
                            </div>

                        </div>
                    </div>  
                </div> 


                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Name:</label>
                        </div>
                        <div class="col-md-9" >
                            <input type="text" id="pname" name="pname" class="form-control" >
                        </div>
                    </div>  
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Qty:</label>
                        </div>
                        <div class="col-md-9" >
                            <input id="qty" name="qty" class="form-control" > 
                        </div>
                    </div>  
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Price:</label>
                        </div>
                        <div class="col-md-9" >
                            <input id="price" name="price" class="form-control" > 
                        </div>
                    </div>  
                </div> 

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Description:</label>
                        </div>
                        <div class="col-md-9" >
                            <textarea class="form-control" id="desc" name="desc" ></textarea>
                        </div>
                    </div>  
                </div>                               


            </div> 

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="submit" name="action_button" id="action_button" class="btn btn-success submit" >Save</button> 
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

          $(".addProduct").on('click',function(e){
            e.preventDefault();
            $('#formModal').modal('show');
          });

          //Image change
          $('#pimage').change(function(){

            let reader = new FileReader();
            reader.onload = (e) => { 
              $('#image_preview_container').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 

          });



          $('#form').on('submit', function(e){
            e.preventDefault();

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








          //SAVING THE DATA WITHOUT IMAGE
          // $('.submit').on('click',function(e){
          //   e.preventDefault();

          //   var pname = $('#pname').val();
          //   var qty = $('#qty').val();
          //   var price = $('#price').val();
          //   var desc = $('#desc').val();


          //   $.ajax({

          //       url:'/admin/store',
          //       method: 'POST',
          //       data:{
          //           pname,
          //           qty,
          //           price,
          //           desc
          //       },
          //       success:function(result){
          //           location.reload();
          //       }
          //   });

          // });





    });    


</script>
@endsection