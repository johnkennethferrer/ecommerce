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
        <div class="row">
        
          <div class="col-md-4">
            <label>From :</label>
            <?php 
              $mydatetime = Carbon\Carbon::now();
              $datetoday = $mydatetime->toDateString();

              // $date1 = str_replace('-', '/', $datetoday);
              // $datetomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
             ?>
            <input type="date" name="date_from" class="form-control" max="{{ $datetoday }}" required="">
          </div>

          <div class="col-md-4">
            <label>To :</label>
            <input type="date" name="date_to" class="form-control" min="{{ $datetoday }}" required="">
          </div>

          <div class="col-md-4">
            <label>Status :</label>
            <select class="form-control">
              <option>Completed</option>
              <option>Processed</option>
              <option>Pending</option>
            </select>
          </div>

        </div>
      </div>

      <div class="col-md-12 border mt-3">
        
      </div>
      
    </div>

	</main>


@endsection