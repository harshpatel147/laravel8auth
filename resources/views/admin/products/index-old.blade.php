@extends('template')
@section('content')
<div class="container">
<div class="row">
  <div class="col-lg-12 margin-tb mb-4">
    <div class="pull-right">
        <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
    </div>
  </div>
</div>
@if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
@endif
<table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
         @foreach ($products as $value)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ $value->detail }}</td>
            <td>
                <form action="{{ route('products.destroy',$value->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('products.show',$value->id) }}">Show</a>
    
                    <a class="btn btn-primary" href="{{ route('products.edit',$value->id) }}">Edit</a>
                 @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>   
            </td>
        </tr>
        @endforeach
</table>
    <!-- {{ $products->links() }} -->
    <?php echo $products->links()?>
@endsection