@extends('admin.template')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DataTables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            @if ($message = Session::get('insert success'))
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h5><i class="icon fas fa-check"></i> Alert!</h5>
                  {{ $message }}
            </div>
            @endif
            @if ($message = Session::get('delete success'))
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h5><i class="icon fas fa-check"></i> Alert!</h5>
                  {{ $message }}
            </div>
            @endif
            @if ($message = Session::get('update success'))
            <div class="alert alert-warning alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h5><i class="icon fas fa-check"></i> Alert!</h5>
                  {{ $message }}
            </div>
            @endif
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
                <br/>
                <div class="row mt-2">
                  <div class="col-lg-12 margin-tb mb-1">
                    <div class="pull-right">
                      <a class="btn btn-success" href="{{ route('admin.rolepermissions.create') }}"> Create New Product</a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <?php $j = 0; ?>
        <div class="row">
        @foreach ($roles as $value)
          <?php $j = $value->id; ?>
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title" style="float: left;">
                  <i class="fas fa-text-width"></i>
                  {{ $value->rolename }}
                </h3>
                <div style="float: right;">
                      <a class="btn btn-primary" href="{{ route('admin.rolepermissions.edit',$value->id) }}">Edit</a>
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <ul>
                  @foreach ($rolepermissions as $val)
                    @if($val->role_id == $value->id)
                    <li>{{ $val->name }}</li>
                    @endif
                  @endforeach
                  
                  <?php 
                    $i=0;
                    $temparry = array();
                      foreach ($rolepermissions as $val) {
                        $temparry[] = $val->role_id;
                      }
                      // print_r($temparry);
                      foreach ($roles as $value) {
                        if(!in_array($value->id, $temparry)){
                            // echo $value->id;
                            $temparray[] = $value->id;
                            $temparray = array_unique($temparray);
                        } 
                      }
                      if(empty($temparray)){
                        $temparray[] = "";
                      }
                      // print_r($temparray);
                  ?>
                  
                  <h6 style="display: <?php if(!in_array($j, $temparray)){ echo "none";} ?>" >nothing permissions granted yet</h6>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- ./col -->
        @endforeach
        </div>

      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection