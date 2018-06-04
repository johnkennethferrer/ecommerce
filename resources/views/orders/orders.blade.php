@extends('layouts.app')

@section('content')

  @include('partials.sidebar')
  <div id="loader" hidden></div>

  <main role="main" class="col-md-9 col-lg-9 px-4 main"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>

    @include('partials.errors')
    @include('partials.success') 

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
      <h1 class="h2"><i class="fa fa-file"></i> Order Management</h1>
    </div>

    <div class="table-responsive">
        <button class="text-white p-3 float-left border-0 tablink" style="cursor:pointer; width:20%;" onclick="openPage('Orders', this, 'green')" id="defaultOpen"><strong>Orders (Pending) 
          @if($counterorder)
            <sup class="badge badge-danger">{{ $counterorder }}</sup>
          @endif
        </strong></button>

        <button class="text-white p-3 float-left border-0 tablink" style="cursor:pointer; width:20%;" onclick="openPage('Delivery', this, 'green')"><strong>Delivery 
          @if($counterdelivery)
            <sup class="badge badge-danger">{{ $counterdelivery }}</sup>
          @endif
        </strong></button>

        <button class="text-white p-3 float-left border-0 tablink" style="cursor:pointer; width:20%;" onclick="openPage('Completed', this, 'green')"><strong>Completed
        </strong></button>

        <button class="text-white p-3 float-left border-0 tablink" style="cursor:pointer; width:20%;" onclick="openPage('Cancelled', this, 'green')"><strong>Cancelled  
          @if($countercancelled)
            <sup class="badge badge-danger">{{ $countercancelled }}</sup>
          @endif
        </strong></button>

        <button class="text-white p-3 float-left border-0 tablink" style="cursor:pointer; width:20%;" onclick="openPage('Rejected', this, 'green')"><strong>Rejected</strong></button>


        <div id="Orders" class="tabcontent border p-3">

            <br/><br/><br/>
            <div class="table-responsive">
              <table class="table table-striped table-sm" id="tableOrders">
                <thead>
                  <th>Order #</th>
                  <th>Customer</th>
                  <th>Total amount</th>
                  <th>Status</th>
                  <th width="100px">Action</th>
                </thead>
                <tbody>
                  @foreach($allorders as $allorder)
                    <tr>
                      <td>{{ $allorder->id }}</td>
                      <td>{{ $allorder->user->name }}</td>
                      <td><span>&#8369; </span>{{ $allorder->total_amount }}</td>
                      <td><span class="badge badge-info">{{ $allorder->status }}</span></td>
                      <td><button type="button" class="btn btn-success" data-toggle="modal" data-target=".vieworder{{$allorder->id}}"><i class="fa fa-eye"></i> View order</button></td>

                      <div class="modal fade bd-example-modal-lg vieworder{{$allorder->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">

                              <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="exampleModalLabel">Manage order</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>

                              <div class="modal-body">
                                <h5><strong>Order <u>#{{$allorder->id}}</u></strong></h5>

                                  <div class="row mt-3">
                                    <div class="col-md-12">
                                      <strong>Name : {{ $allorder->user->name }}</strong>
                                    </div>
                                    <div class="col-md-6">
                                      <strong>Email address : {{ $allorder->user->email }}</strong>
                                    </div>
                                    <div class="col-md-6">
                                      <strong>Contact number : {{ $allorder->user->contact_no }}</strong>
                                    </div>
                                    <div class="col-md-12">
                                      <strong>Address : {{ $allorder->user->address }}</strong>
                                    </div>
                                  </div>  

                                  <div class="row mt-3">
                                    <div class="col-md-2 border p-3">
                                      <strong>Image</strong>
                                    </div>
                                    <div class="col-md-3 border p-3">
                                      <strong>Product name</strong>
                                    </div>
                                    <div class="col-md-1 border p-3">
                                      <strong>Qty</strong>
                                    </div>
                                    <div class="col-md-2 border p-3">
                                      <strong>Price</strong>
                                    </div>
                                    <div class="col-md-2 border p-3">
                                      <strong>Subtotal</strong>
                                    </div>
                                    <div class="col-md-2 border p-3">
                                      <strong>Action</strong>
                                    </div>
                                  </div>

                                  @foreach($orderlists as $orderlist)
                                    @if($orderlist->transaction_id == $allorder->id)
                                                                 
                                      <div class="row">
                                        <div class="col-md-2 border p-3">
                                          @if($orderlist->image == null)
                                            <img class="card-img-top image-responsive" src="{{ asset('storage/no_image.png') }}" alt="No image" style="height:100px; width:100px">
                                            @else
                                            <img class="card-img-top image-responsive" src="{{ asset('storage/') }}/{{ $orderlist->image }}" style="height:100px; width:100px">
                                          @endif
                                        </div>
                                        <div class="col-md-3 border p-3">
                                          {{ $orderlist->name }}
                                        </div>
                                        <div class="col-md-1 border p-3">
                                          {{ $orderlist->quantity }}
                                        </div>
                                        <div class="col-md-2 border p-3">
                                          <span>&#8369; </span>{{ $orderlist->price }}
                                        </div>
                                        <div class="col-md-2 border p-3">
                                          <span>&#8369; </span>{{ number_format($orderlist->price * $orderlist->quantity, 2) }}
                                        </div>
                                        <div class="col-md-2 border p-3">
                                          <a href="{{ route('notify', ['pid' => $orderlist->pid, 'oid' => $allorder->id]) }}" class="btn btn-warning text-white" id="send-nostock"><i class="fa fa-envelope-o"></i> (No stock)</a>
                                        </div>
                                      </div>

                                    @endif
                                  @endforeach


                                <h5 class="mt-3"><strong>Total amount : <span>&#8369; </span>{{$allorder->total_amount}}</strong></h5>
                              </div>

                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                <a href="{{ route('rejectorder', ['id' => $allorder->id])}}" class="btn btn-danger" id="reject-order"><i class="fa fa-times"></i> REJECT ORDER</a>
                                <a href="{{ route('processorder', ['id' => $allorder->id])}}" class="btn btn-primary" id="process-order" ><i class="fa fa-check"></i> PROCESS ORDER</a>
                              </div>

                          </div>
                        </div>
                      </div>
                    
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
         
        </div>

        <div id="Delivery" class="tabcontent border p-3">
          
            <br/><br/><br/>
            <div class="table-responsive">
              <table class="table table-striped table-sm" id="tableDelivery">
                <thead>
                  <th>Order #</th>
                  <th>Customer</th>
                  <th>Total amount</th>
                  <th>Status</th>
                  <th width="100px">Action</th>
                </thead>
                <tbody>
                  @foreach($deliveries as $delivery)
                    <tr>
                      <td>{{ $delivery->id }}</td>
                      <td>{{ $delivery->user->name }}</td>
                      <td><span>&#8369; </span>{{ $delivery->total_amount }}</td>
                      <td><span class="badge badge-primary">{{ $delivery->status }}</span></td>
                      <td><button type="button" class="btn btn-success" data-toggle="modal" data-target=".viewdelivery{{$delivery->id}}"><i class="fa fa-truck"></i> Deliver</button></td>  

                        <div class="modal fade bd-example-modal-sm viewdelivery{{$delivery->id}}  " tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Deliver Order #{{$delivery->id}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <strong>Are you sure do you want to deliver Order #{{$delivery->id}}?</strong>
                              </div>
                              <div class="modal-footer">
                                <a href="{{ route('deliverorder',['id' => $delivery->id ]) }}" class="btn btn-primary">Yes</a>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                              </div>
                            </div>
                          </div>
                        </div>

                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

        </div>

        <div id="Completed" class="tabcontent border p-3">
            
            <br/><br/><br/>
            <div class="table-responsive">
              <table class="table table-striped table-sm" id="tableCompleted">
                <thead>
                  <th>Order #</th>
                  <th>Customer</th>
                  <th>Total amount</th>
                  <th>Status</th>
                  <th width="100px">Action</th>
                </thead>
                <tbody>
                  @foreach($completed as $completeorders)
                    <tr>
                      <td>{{ $completeorders->id }}</td>
                      <td>{{ $completeorders->user->name }}</td>
                      <td><span>&#8369; </span>{{ $completeorders->total_amount }}</td>
                      <td><span class="badge badge-success">{{ $completeorders->status }}</span></td>
                      <td><button type="button" class="btn btn-success" data-toggle="modal" data-target=".viewcompelete{{$completeorders->id}}"><i class="fa fa-eye"></i> View order</button></td>

                      <div class="modal fade bd-example-modal-lg viewcompelete{{$completeorders->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">

                              <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="exampleModalLabel">Order list</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>

                              <div class="modal-body">
                                <h5><strong>Order <u>#{{$completeorders->id}}</u></strong></h5>

                                  <div class="row mt-3">
                                    <div class="col-md-12">
                                      <strong>Name : {{ $completeorders->user->name }}</strong>
                                    </div>
                                    <div class="col-md-6">
                                      <strong>Email address : {{ $completeorders->user->email }}</strong>
                                    </div>
                                    <div class="col-md-6">
                                      <strong>Contact number : {{ $completeorders->user->contact_no }}</strong>
                                    </div>
                                    <div class="col-md-12">
                                      <strong>Address : {{ $completeorders->user->address }}</strong>
                                    </div>
                                  </div>  

                                  <div class="row mt-3">
                                    <div class="col-md-2 border p-3">
                                      <strong>Image</strong>
                                    </div>
                                    <div class="col-md-4 border p-3">
                                      <strong>Product name</strong>
                                    </div>
                                    <div class="col-md-2 border p-3">
                                      <strong>Quantity</strong>
                                    </div>
                                    <div class="col-md-2 border p-3">
                                      <strong>Price</strong>
                                    </div>
                                    <div class="col-md-2 border p-3">
                                      <strong>Price</strong>
                                    </div>
                                  </div>

                                  @foreach($orderlists as $orderlist)
                                    @if($orderlist->transaction_id == $completeorders->id)
                                                                 
                                      <div class="row">
                                        <div class="col-md-2 border p-3">
                                          @if($orderlist->image == null)
                                            <img class="card-img-top image-responsive" src="{{ asset('storage/no_image.png') }}" alt="No image" style="height:100px; width:100px">
                                            @else
                                            <img class="card-img-top image-responsive" src="{{ asset('storage/') }}/{{ $orderlist->image }}" style="height:100px; width:100px">
                                          @endif
                                        </div>
                                        <div class="col-md-4 border p-3">
                                          {{ $orderlist->name }}
                                        </div>
                                        <div class="col-md-2 border p-3">
                                          {{ $orderlist->quantity }}
                                        </div>
                                        <div class="col-md-2 border p-3">
                                          <span>&#8369; </span>{{ $orderlist->price }}
                                        </div>
                                        <div class="col-md-2 border p-3">
                                          <span>&#8369; </span>{{ number_format($orderlist->price * $orderlist->quantity, 2) }}
                                        </div>
                                      </div>

                                    @endif
                                  @endforeach

                                <h5 class="mt-3"><strong>Total amount paid : <span>&#8369; </span>{{$completeorders->total_amount}}</strong></h5>
                              </div>

                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>

                          </div>
                        </div>
                      </div>
                    
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

        </div>

        <div id="Cancelled" class="tabcontent border p-3">
          
          <br/><br/><br/>
            <div class="table-responsive">
              <table class="table table-striped table-sm" id="tableCancelled">
                <thead>
                  <th>Order #</th>
                  <th>Customer</th>
                  <th>Total amount</th>
                  <th>Status</th>
                  <th width="100px">Action</th>
                </thead>
                <tbody>
                  @foreach($cancelled as $cancelledorders)
                    <tr>
                      <td>{{ $cancelledorders->id }}</td>
                      <td>{{ $cancelledorders->user->name }}</td>
                      <td><span>&#8369; </span>{{ $cancelledorders->total_amount }}</td>
                      <td><span class="badge badge-danger">{{ $cancelledorders->status }}</span></td>
                      <td><button type="button" class="btn btn-success" data-toggle="modal" data-target=".viewcancelled{{$cancelledorders->id}}"><i class="fa fa-eye"></i> View order</button></td>

                      <div class="modal fade bd-example-modal-lg viewcancelled{{$cancelledorders->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">

                              <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="exampleModalLabel">Order list</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>

                              <div class="modal-body">
                                <h5><strong>Order <u>#{{$cancelledorders->id}}</u></strong></h5>

                                  <div class="row mt-3">
                                    <div class="col-md-12">
                                      <strong>Name : {{ $cancelledorders->user->name }}</strong>
                                    </div>
                                    <div class="col-md-6">
                                      <strong>Email address : {{ $cancelledorders->user->email }}</strong>
                                    </div>
                                    <div class="col-md-6">
                                      <strong>Contact number : {{ $cancelledorders->user->contact_no }}</strong>
                                    </div>
                                    <div class="col-md-12">
                                      <strong>Address : {{ $cancelledorders->user->address }}</strong>
                                    </div>
                                  </div>  

                                  <div class="row mt-3">
                                    <div class="col-md-2 border p-3">
                                      <strong>Image</strong>
                                    </div>
                                    <div class="col-md-4 border p-3">
                                      <strong>Product name</strong>
                                    </div>
                                    <div class="col-md-2 border p-3">
                                      <strong>Quantity</strong>
                                    </div>
                                    <div class="col-md-2 border p-3">
                                      <strong>Price</strong>
                                    </div>
                                    <div class="col-md-2 border p-3">
                                      <strong>Price</strong>
                                    </div>
                                  </div>

                                  @foreach($orderlists as $orderlist)
                                    @if($orderlist->transaction_id == $cancelledorders->id)
                                                                 
                                      <div class="row">
                                        <div class="col-md-2 border p-3">
                                          @if($orderlist->image == null)
                                            <img class="card-img-top image-responsive" src="{{ asset('storage/no_image.png') }}" alt="No image" style="height:100px; width:100px">
                                            @else
                                            <img class="card-img-top image-responsive" src="{{ asset('storage/') }}/{{ $orderlist->image }}" style="height:100px; width:100px">
                                          @endif
                                        </div>
                                        <div class="col-md-4 border p-3">
                                          {{ $orderlist->name }}
                                        </div>
                                        <div class="col-md-2 border p-3">
                                          {{ $orderlist->quantity }}
                                        </div>
                                        <div class="col-md-2 border p-3">
                                          <span>&#8369; </span>{{ $orderlist->price }}
                                        </div>
                                        <div class="col-md-2 border p-3">
                                          <span>&#8369; </span>{{ number_format($orderlist->price * $orderlist->quantity, 2) }}
                                        </div>
                                      </div>

                                    @endif
                                  @endforeach

                                <h5 class="mt-3"><strong>Total amount paid : <span>&#8369; </span>{{$cancelledorders->total_amount}}</strong></h5>
                              </div>

                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>

                          </div>
                        </div>
                      </div>
                    
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

        </div>

        <div id="Rejected" class="tabcontent border p-3">
          
          <br/><br/><br/>
            <div class="table-responsive">
              <table class="table table-striped table-sm" id="tableRejected">
                <thead>
                  <th>Order #</th>
                  <th>Customer</th>
                  <th>Total amount</th>
                  <th>Status</th>
                  <th width="100px">Action</th>
                </thead>
                <tbody>
                  @foreach($rejected as $rejectedorders)
                    <tr>
                      <td>{{ $rejectedorders->id }}</td>
                      <td>{{ $rejectedorders->user->name }}</td>
                      <td><span>&#8369; </span>{{ $rejectedorders->total_amount }}</td>
                      <td><span class="badge badge-warning text-white">{{ $rejectedorders->status }}</span></td>
                      <td><button type="button" class="btn btn-success" data-toggle="modal" data-target=".viewrejected{{$rejectedorders->id}}"><i class="fa fa-eye"></i> View order</button></td>

                      <div class="modal fade bd-example-modal-lg viewrejected{{$rejectedorders->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">

                              <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="exampleModalLabel">Order list</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>

                              <div class="modal-body">
                                <h5><strong>Order <u>#{{$rejectedorders->id}}</u></strong></h5>

                                  <div class="row mt-3">
                                    <div class="col-md-12">
                                      <strong>Name : {{ $rejectedorders->user->name }}</strong>
                                    </div>
                                    <div class="col-md-6">
                                      <strong>Email address : {{ $rejectedorders->user->email }}</strong>
                                    </div>
                                    <div class="col-md-6">
                                      <strong>Contact number : {{ $rejectedorders->user->contact_no }}</strong>
                                    </div>
                                    <div class="col-md-12">
                                      <strong>Address : {{ $rejectedorders->user->address }}</strong>
                                    </div>
                                  </div>  

                                  <div class="row mt-3">
                                    <div class="col-md-2 border p-3">
                                      <strong>Image</strong>
                                    </div>
                                    <div class="col-md-4 border p-3">
                                      <strong>Product name</strong>
                                    </div>
                                    <div class="col-md-2 border p-3">
                                      <strong>Quantity</strong>
                                    </div>
                                    <div class="col-md-2 border p-3">
                                      <strong>Price</strong>
                                    </div>
                                    <div class="col-md-2 border p-3">
                                      <strong>Price</strong>
                                    </div>
                                  </div>

                                  @foreach($orderlists as $orderlist)
                                    @if($orderlist->transaction_id == $rejectedorders->id)
                                                                 
                                      <div class="row">
                                        <div class="col-md-2 border p-3">
                                          @if($orderlist->image == null)
                                            <img class="card-img-top image-responsive" src="{{ asset('storage/no_image.png') }}" alt="No image" style="height:100px; width:100px">
                                            @else
                                            <img class="card-img-top image-responsive" src="{{ asset('storage/') }}/{{ $orderlist->image }}" style="height:100px; width:100px">
                                          @endif
                                        </div>
                                        <div class="col-md-4 border p-3">
                                          {{ $orderlist->name }}
                                        </div>
                                        <div class="col-md-2 border p-3">
                                          {{ $orderlist->quantity }}
                                        </div>
                                        <div class="col-md-2 border p-3">
                                          <span>&#8369; </span>{{ $orderlist->price }}
                                        </div>
                                        <div class="col-md-2 border p-3">
                                          <span>&#8369; </span>{{ number_format($orderlist->price * $orderlist->quantity, 2) }}
                                        </div>
                                      </div>

                                    @endif
                                  @endforeach

                                <h5 class="mt-3"><strong>Total amount paid : <span>&#8369; </span>{{$rejectedorders->total_amount}}</strong></h5>
                              </div>

                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>

                          </div>
                        </div>
                      </div>
                    
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

        </div>

    </div>
  </main>  

  <script> 
    $(document).ready( function () {
        $('#tableOrders').DataTable();
        $('#tableDelivery').DataTable();
        $('#tableCompleted').DataTable();
        $('#tableCancelled').DataTable();
        $('#tableOrderlist').DataTable();
        $('#tableRejected').DataTable();
    });
  </script>

  <script>
    function openPage(pageName,elmnt,color) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].style.backgroundColor = "#6c757d";
        }
        document.getElementById(pageName).style.display = "block";
        elmnt.style.backgroundColor = color;

    }
    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
    </script>

@endsection
