@extends('layouts.app')

@section('content')

  @include('partials.sidebar')

  <main role="main" class="col-md-9 col-lg-9 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>

    @include('partials.errors')
    @include('partials.success') 

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
      <h1 class="h2"><i class="fa fa-users"></i> Customers</h1>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-sm" id="table">
          <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Email address</th>
            <th>Contact no</th>
            <th>Address</th>
            <!-- <th>Action</th> -->
          </thead>
          <tbody>
            @foreach($customers as $customer)
              <tr>
                <td>{{ $customer->id }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->contact_no }}</td>
                <td><textarea class="form-control" rows="3" readonly>{{ $customer->address }}</textarea></td>
                <!-- <td><a href="" class="btn btn-success">View</a></td> -->
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
  </main>  

  <script> 
    $(document).ready( function () {
        $('#table').DataTable();
    });
  </script>

@endsection
