@extends('admin.template')
@section('content')
  <div class="content-wrapper" style="min-height: 1403.62px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>General Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">General Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="col-md-8 offset-2">
          <div class="pull-right ml-1 mb-3">
                <a class="btn btn-primary" href="{{ route('admin.roles.index') }}"> Back</a>
          </div>
          
          @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h5><i class="icon fas fa-check"></i><strong>Whoops!</strong> There were some problems with your input.<br><br></h5>
                 <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            </div>
            
          @endif
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Quick Example</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('admin.roles.store') }}" method="POST">
              @csrf

              <div class="card-body">
                <div class="form-group">
                  <label>Role Name</label>
                  <input type="text" class="form-control" name="rolename" placeholder="Enter Role Name" required>
                </div>
                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" style="height:150px" name="description" placeholder="Enter Description"></textarea>
                </div>
              </div>
                <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
  <script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            document.getElementById('imgshowdiv').style.opacity = "1";
            reader.onload = function (e) {
                $('#img')
                    .attr('src', e.target.result)
                    .width(80)
                    .height(100);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
  </script>
@endsection