@extends('layouts.app')

@section('content')


        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                <li class="active">Dashboard</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-6">
                <h1 class="page-header">Dashboard</h1>
            </div>
        </div><!--/.row-->

        <div class="panel panel-default">
            <div class="panel-body tabs">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1"  style="font-size: 24px; font-weight: bold;" data-toggle="tab">Sales and Inquires</a></li>
                    {{--<li><a href="#tab2" style="font-size: 24px; font-weight: bold;" data-toggle="tab">Jobs</a></li>--}}
                    <li><a href="#tab3" style="font-size: 24px; font-weight: bold;" data-toggle="tab">Installation</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab1">
                        <h4>Sales and Inquires Dashbaord</h4>
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Sales Target Vs. Achievement</div>
                                    <div class="panel-body">
                                        <div class="canvas-wrapper">
                                            <canvas class="main-chart" id="bar-chart" height="200" width="600"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Sales By Agent</div>
                                    <div class="panel-body">
                                        <div class="canvas-wrapper">
                                            <canvas class="chart" id="doughnut-chart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Sales Trend Analysis (Approved Quotation)</div>
                                    <div class="panel-body">
                                        <div class="canvas-wrapper">
                                            <canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--/.row-->

                        <div class="row">
                            <div class="col-xs-12 col-md-6 col-lg-4">
                                <div class="panel panel-blue panel-widget">
                                    <div class="row no-padding">
                                        <a href="#">
                                            <div class="col-sm-3 col-lg-5 widget-left">
                                                <i class="fa fa-motorcycle fa-5x" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-sm-9 col-lg-7 widget-right">
                                                <div style="padding-top: 20px;" class="large">17</div>
                                                <div class="text-muted">Inquiries Not Visited</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 col-lg-4">
                                <div class="panel panel-teal panel-widget ">
                                    <div class="row no-padding">
                                        <a href="#">
                                            <div class="col-sm-3 col-lg-5 widget-left">
                                                <i class="fa fa-exclamation fa-5x" aria-hidden="true"></i>

                                            </div>
                                            <div class="col-sm-9 col-lg-7 widget-right">
                                                <div style="padding-top: 20px;" class="large">10</div>
                                                <div class="text-muted">Inquiry Delays</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 col-lg-4">
                                <div class="panel panel-blue panel-widget ">
                                    <div class="row no-padding">
                                        <a href="#">
                                            <div class="col-sm-3 col-lg-5 widget-left">
                                                <i class="fa fa-fax fa-5x" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-sm-9 col-lg-7 widget-right">
                                                <div style="padding-top: 15px;" class="large">09</div>
                                                <div class="text-muted">Visited & Quotations<br/>Pending</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 col-lg-4">
                                <div class="panel panel-orange panel-widget">
                                    <div class="row no-padding">
                                        <a href="#">
                                            <div class="col-sm-3 col-lg-5 widget-left">
                                                <i class="fa fa-book fa-5x" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-sm-9 col-lg-7 widget-right">
                                                <div class="large">10</div>
                                                <div class="text-muted">Potencial Orders</div>
                                                <p class="potencial-orders">LKR 8,540,000</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 col-lg-4">
                                <div class="panel panel-teal panel-widget">
                                    <div class="row no-padding">
                                        <a href="#">
                                            <div class="col-sm-3 col-lg-5 widget-left">
                                                <i class="fa fa-eye fa-5x" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-sm-9 col-lg-7 widget-right">
                                                <div class="large">7</div>
                                                <div class="text-muted">Invoices This Month</div>
                                                <p class="pending-installations">LKR 5,870,500</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 col-lg-4">
                                <div class="panel panel-blue panel-widget ">
                                    <div class="row no-padding">
                                        <a href="#">
                                            <div class="col-sm-3 col-lg-5 widget-left">
                                                <i class="fa fa-ban fa-5x" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-sm-9 col-lg-7 widget-right">
                                                <div class="large">05</div>
                                                <div class="text-muted">Cancelled</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div><!--/.row-->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Latest Inquiries</div>
                                    <div class="panel-body">
                                        @if($inquiries->count() > 0)
                                            <table data-toggle="table" id="example2" data-row-style="rowStyle">
                                                <thead>

                                                <tr>
                                                    {{--<th>Select <input type="checkbox" id="selectAll" value="{{ $collectionId->toJson() }}"></th>--}}
                                                    {{--<th>Id</th>--}}
                                                    <th>Inquiry Id</th>
                                                    <th>Customer Name</th>
                                                    <th>Customer Phone</th>
                                                    <th>Customer Email</th>
                                                    {{--<th>Customer Address</th>--}}
                                                    <th>Agent</th>

                                                    {{--<th>Planned Visit Date Time</th>--}}
                                                    {{--<th>Inq Source</th>--}}
                                                    {{--<th>Max Discount</th>--}}
                                                    {{--<th>Actual Visit Date Time</th>--}}
                                                    {{--<th>Cancel Reason</th>--}}
                                                    <th>Source</th>
                                                    <th>Status</th>
                                                    {{--<th>Re-Schedule</th>--}}
                                                    {{--<th>View</th>--}}
                                                    {{--@if(Auth::User()->can('CanEditRoles'))--}}
                                                    {{--@endif--}}
                                                    {{--@if(Auth::User()->can('CanTrackRoles'))--}}
                                                    {{--<th>Track</th>--}}
                                                    {{--@endif--}}
                                                </tr>
                                                </thead>

                                                <tbody>

                                                @php
                                                    $id=1;
                                                @endphp

                                                @foreach ($inquiries as $inquiry)
                                                    <tr>
                                                        {{--<td><input type="checkbox" class="checkbox1" value="{{ $product->id }}"></td>--}}
                                                        {{--<td>{{ (($inquiries->currentPage()-1)*$inquiries->perPage())+$id }}</td>--}}
                                                        <td>{{ 'inq_'.sprintf('%08d', $inquiry->id) }}</td>
                                                        <td>{{ $inquiry->saleslead->customer->name }}</td>
                                                        <td>{{ $inquiry->saleslead->customer->mobile }}</td>
                                                        <td>{{ $inquiry->saleslead->customer->email }}</td>
                                                        {{--<td>{{ $inquiry->saleslead->customer->address }}</td>--}}
                                                        <td>{{ $inquiry->agent->name }}</td>
                                                        {{--<td>{{ $inquiry->planned_visit_date_time}}</td>--}}
                                                        {{--<td>{{ $inquiry->inquiry_source }}</td>--}}
                                                        {{--<td>{{ $inquiry->maximum_discount }}</td>--}}
                                                        {{--<td>{{ $inquiry->actual_visit_date_time }}</td>--}}
                                                        {{--<td>{{ $inquiry->cancel_reason }}</td>--}}
                                                        {{--<td>{{ $inquiry->status }}</td>--}}
                                                        <td>@if($inquiry->inquiry_source == '1')<span class='label label-success'>Internal</span>@else<span class='label label-warning'>External</span>@endif</td>
                                                        <td>@if($inquiry->status == '1')<span class='label label-info'>Assigned</span>@elseif($inquiry->status == '2')<span class='label label-warning'>Visited</span>@else<span class='label label-success'>Cancelled</span>@endif</td>
                                                        {{--<td><a class="link1" href='{{  url("/inquiries/$inquiry->id/reschedule") }}'><i class="fa fa-bars"></i></a></td>--}}
                                                        {{--@if(Auth::User()->can('CanTrackRoles'))--}}
                                                        {{--<td><a  href='{{  url("/inquiries/$inquiry->id/view") }}'><i class="fa fa-eye" aria-hidden="true"></i></a></td>--}}
                                                        {{--<td><a class="link" href='{{  url("/activities/$inquiry->id/Inquiry") }}'><i class="fa fa-road"></i></a></td>--}}
                                                        {{--@endif--}}
                                                        @php $id++; @endphp
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <table data-toggle="table" id="example3" data-row-style="rowStyle">
                                                <tr>
                                                    <td>No Result Found</td>
                                                </tr>
                                            </table>
                                        @endif
                                        {{--<div class="fixed-table-pagination"><div class="pull-left pagination-detail"><span class="pagination-info">Showing 1 to 10 of 21 rows</span><span class="page-list"><span class="btn-group dropup"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="page-size">10</span> <span class="caret"></span></button><ul class="dropdown-menu" role="menu"><li class="active"><a href="javascript:void(0)">10</a></li><li><a href="javascript:void(0)">25</a></li><li><a href="javascript:void(0)">50</a></li><li><a href="javascript:void(0)">100</a></li></ul></span> records per page</span></div><div class="pull-right pagination"><ul class="pagination"><li class="page-first disabled"><a href="javascript:void(0)">&lt;&lt;</a></li><li class="page-pre disabled"><a href="javascript:void(0)">&lt;</a></li><li class="page-number active disabled"><a href="javascript:void(0)">1</a></li><li class="page-number"><a href="javascript:void(0)">2</a></li><li class="page-number"><a href="javascript:void(0)">3</a></li><li class="page-next"><a href="javascript:void(0)">&gt;</a></li><li class="page-last"><a href="javascript:void(0)">&gt;&gt;</a></li></ul></div></div>--}}
                                        {{--<br/>--}}
                                        {{--<div class="block">--}}
                                        {{--<a href="#" class="btn btn-primary pull-right">View All</a>--}}
                                        {{--</div>--}}
                                    </div>

                                </div>

                            </div>


                        </div><!--/.row-->

                    </div>
                    {{--<div class="tab-pane fade" id="tab2">--}}
                        {{--<h4>Jobs Dashbaord</h4>--}}
                        {{--<br/>--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-xs-12 col-md-6 col-lg-4">--}}
                                {{--<div class="panel panel-teal panel-widget">--}}
                                    {{--<div class="row no-padding">--}}
                                        {{--<a href="#">--}}
                                            {{--<div class="col-sm-3 col-lg-5 widget-left">--}}
                                                {{--<i class="fa fa-eye fa-5x" aria-hidden="true"></i>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-sm-9 col-lg-7 widget-right">--}}
                                                {{--<div class="large">7</div>--}}
                                                {{--<div class="text-muted">Jobs Pending (Count)</div>--}}
                                            {{--</div>--}}
                                        {{--</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="col-xs-12 col-md-6 col-lg-4">--}}
                                {{--<div class="panel panel-teal panel-widget">--}}
                                    {{--<div class="row no-padding">--}}
                                        {{--<a href="#">--}}
                                            {{--<div class="col-sm-3 col-lg-5 widget-left">--}}
                                                {{--<i class="fa fa-eye fa-5x" aria-hidden="true"></i>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-sm-9 col-lg-7 widget-right">--}}
                                                {{--<div class="large">4</div>--}}
                                                {{--<div class="text-muted">Jobs On-Going (In Progress)</div>--}}
                                            {{--</div>--}}
                                        {{--</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="col-xs-12 col-md-6 col-lg-4">--}}
                                {{--<div class="panel panel-teal panel-widget">--}}
                                    {{--<div class="row no-padding">--}}
                                        {{--<a href="#">--}}
                                            {{--<div class="col-sm-3 col-lg-5 widget-left">--}}
                                                {{--<i class="fa fa-eye fa-5x" aria-hidden="true"></i>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-sm-9 col-lg-7 widget-right">--}}
                                                {{--<div class="large">2</div>--}}
                                                {{--<div class="text-muted">Jobs Completed</div>--}}
                                                {{--<p class="pending-installations">LKR 1,170,000</p>--}}
                                            {{--</div>--}}
                                        {{--</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="tab-pane fade" id="tab3">
                        <h4>Installation Dashbaord</h4>
                        <br/>
                        <div class="row">
                            <div class="col-xs-12 col-md-6 col-lg-6">
                                <div class="panel panel-teal panel-widget">
                                    <div class="row no-padding">
                                        <a href="#">
                                            <div class="col-sm-3 col-lg-5 widget-left">
                                                <i class="fa fa-eye fa-5x" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-sm-9 col-lg-7 widget-right">
                                                <div class="large">2</div>
                                                <div class="text-muted">Pending Installations</div><p class="pending-installations">LKR 1,170,000</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-6 col-lg-6">
                                <div class="panel panel-teal panel-widget">
                                    <div class="row no-padding">
                                        <a href="#">
                                            <div class="col-sm-3 col-lg-5 widget-left">
                                                <i class="fa fa-eye fa-5x" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-sm-9 col-lg-7 widget-right">
                                                <div class="large">4</div>
                                                <div class="text-muted">Installation Delays</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.panel-->



@endsection






