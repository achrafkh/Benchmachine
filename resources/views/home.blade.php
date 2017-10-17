@extends('layouts.master')
@section('content')

@include('layouts.partials.header')

<div class="container" style="padding: 50px">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Benchmarks</div>
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
                                        <td><span class="label label-{{ ($benchmark->status) ? 'success'  : 'warning' }}">
                                        {{ ($benchmark->status) ? 'Ready'  : 'Processing' }}</span></td>
                                        <td>
                                        @if($benchmark->status)
                                        <a class="btn btn-primary btn-sm" target="_blank" href="/benchmarks/{{ $benchmark->id }}">View</a>
                                        <a class="btn btn-primary btn-sm" target="_blank" href="/benchmarks/download/{{ $benchmark->id }}">Download</a>
                                        @else

                                        @endif
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
@endsection
