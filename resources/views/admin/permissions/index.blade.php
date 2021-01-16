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
                      <a class="btn btn-success" href="{{ route('admin.permissions.create') }}"> Create New Product</a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
             
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No.</th>
                    <th>Permission Name</th>
                    <th>Controller Name</th>
                    <th>Method Name</th>
                    <th>Action</th>
                    <!-- <th>CSS grade</th> -->
                  </tr>
                  </thead>
                  <tbody>
                  <?php $i = 0;?>
                  @foreach ($permissions as $value)
                    <tr>
                      <td>{{ ++$i }}</td>
                      <td>{{ $value->name }}</td>
                      <td>{{ $value->controller }}</td>
                      <td>{{ $value->method }}</td>
                      <td>
                        <form action="{{ route('permissions.destroy',$value->id) }}" method="POST">
                          <a class="btn btn-primary" href="{{ route('admin.permissions.edit',$value->id) }}">Edit</a>
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">Delete</button>
                        </form>  
                      </td>
                    </tr>
                  @endforeach

                  </tbody>
                  <tfoot>
                 <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Controller Name</th>
                    <th>Method Name</th>
                    <th>Action</th>
                    <!-- <th>CSS grade</th> -->
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection