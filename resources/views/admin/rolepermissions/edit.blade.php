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
                <a class="btn btn-primary" href="{{ route('admin.rolepermissions.index') }}"> Back</a>
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
          <?php 
              $roles = $all['roles'];
              $permissions = $all['permissions'];
              $roleexits = $all['roleexits'];
              $rolepermissions = $all['rolepermissions']; 
              $permissionexits = $all['permissionexits'];
              // echo "<pre>";
              // print_r($roles->toarray());
          ?>
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Quick Example</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('admin.rolepermissions.update') }}" method="POST">
              @csrf

              <div class="card-body">
                <!-- <div class="form-group">
                  <label>Disabled Result</label>
                  <select class="form-control select2" style="width: 100%;">
                    <option selected="selected">Alabama</option>
                    <option>Alaska</option>
                    <option disabled="disabled">California (disabled)</option>
                    <option>Delaware</option>
                    <option>Tennessee</option>
                    <option>Texas</option>
                    <option>Washington</option>
                  </select>
                </div> -->
                <div class="form-group">
                  <label>Select Role</label>
                  <select class="select2" name="role_id" data-placeholder="Select a State" style="width: 100%;">
                      @foreach ($roles as $value)
                          <option value="{{ $value->id }}" <?php if(in_array($value->id, $roleexits)){ echo "selected";}?> <?php if(!in_array($value->id, $roleexits)){ echo "disabled";}?> > {{ $value->id }}{{ $value->rolename }}</option>
                      @endforeach
                  </select>
                </div>
                
                <div class="form-group">
                  <label>Select Permissions</label>
                  <select class="select2" multiple="multiple" name="permission_id[]" data-placeholder="Select a State" style="width: 100%;">
                      @foreach ($permissions as $value)
                        <option value="{{ $value->id }}" <?php if(in_array($value->id, $permissionexits)){ echo "selected";}?> <?php if($value->controller == "RoleController" && $roleexits['id'] == "1"){ echo "selected"; }?> > {{ $value->id }}{{ $value->name }} </option>
                      @endforeach
                  </select>
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

@endsection