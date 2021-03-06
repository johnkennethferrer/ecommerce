@extends('layouts.app')

@section('content')

  @include('partials.sidebar')

  <main role="main" class="col-md-9 col-lg-9 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>

    @include('partials.errors')
        @include('partials.success') 

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
      <h1 class="h2"><i class="fa fa-line-chart"></i> Sales report</h1>
    </div>

    <div class="col-md-12">
      <div class="col-md-9">

        <form method="post" action="{{ route('showreports') }}">
          @csrf
          <div class="row">
              <?php 
                  $mydatetime = Carbon\Carbon::now();
                  $datetoday = $mydatetime->toDateString();

                  //formatted date
                  $dateformat = new DateTime($datetoday);
                  $dateformatted = $dateformat->format('M d, Y');

                  $df = new DateTime($datefrom);
                  $dff = $df->format('M d, Y');

                  $dt = new DateTime($dateto);
                  $dtf = $dt->format('M d, Y');

              ?>
          
              <div class="col-md-4">
                <label>From :</label>
                
                <input type="date" name="date_from" class="form-control" value="{{$datefrom}}" required>
              </div>

              <div class="col-md-4">
                <label>To :</label>
                <input type="date" name="date_to" class="form-control" value="{{$dateto}}" required>
              </div>

              <div class="col-md-2">
                <br>
                <button class="btn btn-primary mt-2">Submit</button>
              </div>

          </div>

        </form>
      </div>

      <div class="col-md-12 border mt-3 clearfix ">

        <h4 class="m-3 bg-secondary text-white p-4 ">Sales ( {{$dff}} - {{$dtf}} ) <a href="{{ route('printreport', ['datefrom' => $datefrom, 'dateto' => $dateto]) }}" target="_blank" class="btn btn-success float-right"><i class="fa fa-print"></i> Print</a></h4>
        <div class="col-md-12">
          <table class="table table-striped">
            <thead>
              <th>Order #</th>
              <th>Date ordered</th>
              <th>Amount ordered</th>
            </thead>
            <tbody>
              @foreach($sales as $sale)
                <tr>
                  <td>{{ $sale->id }}</td>
                  <td><?php 
                    $datetime = new DateTime($sale->created_at);
                    $dtformat = $datetime->format('M d, Y H:m A');
                    echo $dtformat
                   ?></td>
                  <td><span>&#8369; </span>{{ number_format($sale->total_amount, 2) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>

          <div class="col-md-5 float-right p-0">
            <h5 class="bg-success p-3 text-white">Total sales: <strong><u><span>&#8369; </span>{{ number_format($totalsale, 2) }}</u></strong></h5>
          </div>
        </div>

      </div>
      
    </div>

  </main>


@endsection