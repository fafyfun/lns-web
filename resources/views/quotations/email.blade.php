<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link href="{{ url('/') }}/css/bootstrap.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/styles.css" rel="stylesheet">
</head>
<body>



<div class="row">
    <div class="col-lg-12">
        <img class="img-responsive" src="{{ url('/images/lns-logo.png') }}" style="width:200px;height:100px;margin-left: auto;margin-right: auto;margin-top: 1%">
    </div>
</div>

<div class="row">
    <div class="col-lg-12 ">
        <div style="text-align: center;">
            <h3>INSTALLATION JOB CARD</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div>
            Planned Deleivery Date : {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $installation->planned_delivery_date_time )->toDateString() }}
        </div>
        <div>
            Planned Deleivery Time : {{ Carbon\Carbon::parse($installation->planned_delivery_date_time )->format('g:i A') }}
        </div>
        <div>
            Actual Deleivery Date : @if(isset($installation->actual_delivery_date_time)){{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $installation->actual_delivery_date_time )->toDateString() }} @endif
        </div>
        <div>
            Actual Deleivery Time : @if(isset($installation->actual_delivery_date_time)){{ Carbon\Carbon::parse($installation->actual_delivery_date_time )->format('g:i A') }} @endif
        </div>
    </div>
    <div class="col-lg-4">
        <div>
            Installation ID : INST-{{ sprintf('%08d', $installation->id) }}
        </div>
        <div>
            Installation Agent : {{ $installation->insatllaionlead->name }}
        </div>
    </div>
    <div class="col-lg-4">
        <div>
            Customer Name : {{ $installation->job->quotation->inquiry->saleslead->customer->name }}
        </div>
        <div>
            Customer Email : {{ $installation->job->quotation->inquiry->saleslead->customer->email }}
        </div>
        <div>
            Customer Phone : {{ $installation->job->quotation->inquiry->saleslead->customer->mobile }}
        </div>
        <div class="row">
            <div class="col-xs-4">CustomerAddress:</div>
            <div class="col-xs-4">{{ $installation->job->quotation->inquiry->saleslead->customer->address }}</div>
        </div>
    </div>
</div>
<br>
@foreach($installation->job->quotation->rooms as $room)
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $room->name }}
                </div>
                <div class="panel-body">
                    @foreach($room->walls as $wall)
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    {{ $wall->name }}
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <img class="img-responsive" src='{{ url("/images/products/{$wall->product->image}") }}' style="width:200px;height:100px;">
                                    </div>
                                    <div class="col-lg-3">
                                        <div>
                                            prod-{{ sprintf('%08d', $wall->product->id) }}
                                        </div>
                                        <div>
                                            <b>{{ $wall->product->name }}</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>

                                </div>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div>
                                            Width : 50ft
                                        </div>
                                        <div>
                                            Height : 50ft
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div>
                                            Width : 50ft
                                        </div>
                                        <div>
                                            Height : 50ft
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endforeach



</body>
</html>


