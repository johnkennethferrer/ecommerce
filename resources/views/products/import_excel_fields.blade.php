@extends('layouts.app')

@section('content')
    @include('partials.sidebar')
    <main role="main" class="col-md-9 col-lg-9 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
        
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3>Parse Excel Data</h3></div>

                        <div class="panel-body mt-5">
                            <form class="form-horizontal" method="POST" action="{{ route('processexcel') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="excel_data_file_id" value="{{ $excel_data_file->id }}" />

                                <table class="table">
                                    @foreach ($excel_data as $row)
                                        <tr>
                                        @foreach ($row as $key => $value)
                                            <td>{{ $value }}</td>

                                        @endforeach
                                        </tr>
                                    @endforeach
                                </table>

                                <a href="/home" class="btn btn-danger float-right ml-3"><i class="fa fa-times"></i> Cancel</a>
                                <button type="submit" class="btn btn-primary float-right">
                                    <i class="fa fa-arrow-down"></i> Import Data
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
