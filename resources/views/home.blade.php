@extends('layouts.master')
@section('content')
@include('layouts.partials.header')
<div class="container" style="padding: 50px">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" >
                <div class="panel-heading">Benchmarks
                    <button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#myModal">New</button>
                </div>
                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="row">
                        <div class="span5">
                            <table class="table table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Date Created</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($benchmarks as $benchmark)
                                    <tr>
                                        <td>{{ $benchmark->title }}</td>
                                        <td>{{ $benchmark->created_at }}</td>
                                        <td>{{ $benchmark->since }}</td>
                                        <td>{{ $benchmark->until }}</td>
                                        <td><span class="label label-{{ $benchmark->getStatus()['class'] }}">
                                       {{ $benchmark->getStatus()['text'] }}</span></td>
                                        <td>
                                        @if($benchmark->status == 0)
                                        <form class="inline" action="payment/pay/{{ $benchmark->order->id }}" method="POST" style="">
                                             {{ csrf_field() }}
                                            <button type="submit" class="btn btn-primary btn-sm" >Pay</button>
                                        </form>
                                        @endif
                                            <a class="btn btn-primary btn-sm" target="_blank"
                                            href="@if($benchmark->status == 2) /benchmarks/{{ $benchmark->id }}  @else javascript::void(0) @endif" @if($benchmark->status != 2) disabled  @endif >View</a>
                                            <a class="btn btn-primary btn-sm" target="_blank" href="@if($benchmark->status == 2) /benchmarks/download/{{ $benchmark->id }} @else javascript::void(0) @endif"
                                            @if($benchmark->status != 2) disabled  @endif >Download</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New Benchmark</h4>
            </div>
            <div class="modal-body">
                <div class="home-form">
                    <form id="submit_pages" action="{{ route('newBench') }}" method="POST" >
                        {{ csrf_field() }}
                        <div class="hf-header">
                            <h2>
                            Add facebook pages
                            </h2>
                            <p>
                                Copy paste the url of the facebook pages you want to compare. It only takes a few seconds.
                            </p>
                            <div id="min" class="alert alert-danger" style="display: none">
                                <strong>Danger!</strong> Minimum : 2 pages.
                            </div>
                        </div>
                        <div style="padding: 10px" class="row">
                            <input class="col-md-6" type="date" name="since">
                            <input class="col-md-6" type="date" name="until">
                        </div>
                        <div class="fb-wrap">
                            <div class="media fb-box focused">
                                <div class="media-left fb-icon">
                                    <i class="icon-facebook"></i>
                                </div>
                                <div id="f_0" class="media-body fb-inner error_c">
                                    <h4 class="fb-nb">First page</h4>
                                    <input id="fb_page_0" class="fb-input" type="text" name="accounts[]" placeholder="https://www.facebook.com/exemple">
                                </div>
                            </div>
                            <div class="media fb-box">
                                <div class="media-left fb-icon">
                                    <i class="icon-facebook"></i>
                                </div>
                                <div id="f_1" class="media-body fb-inner error_c">
                                    <h4 class="fb-nb">Second page</h4>
                                    <input id="fb_page_1" class="fb-input" type="text" name="accounts[]" placeholder="https://www.facebook.com/exemple">
                                </div>
                            </div>
                        </div>
                        <div class="media mail">
                            <div class="media-right mail-submit">
                                <button class="btn btn-primary" id="trigger" type="button" waves-hover>
                                Generate
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
