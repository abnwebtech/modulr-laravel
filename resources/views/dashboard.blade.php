@extends('layouts.app')

@section('content')
    <div class="container-fluid dashboard">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default panel-dashboard">
                    <div class="panel-heading">
                        <p class="lead">Tasks</p>
                        <a href="/tasks" class="pull-right">View all</a>
                    </div>
                    <div class="panel-body" style="height:300px; overflow-y:scroll;">
                        <tasks></tasks>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel panel-default panel-dashboard">
                    <div class="panel-heading">
                        <p class="lead">News</p>
                        <a href="/news" class="pull-right">View all</a>
                    </div>
                    <div class="panel-body" style="height:300px; overflow-y:scroll;">
                        <news-list></news-list>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default panel-dashboard">
                    <div class="panel-heading">
                        <p class="lead">Files</p>
                        <a href="/files" class="pull-right">View all</a>
                    </div>
                    <div class="panel-body" style="height:300px; overflow-y:scroll;">
                        <files></files>
                    </div>
                </div>
            </div>
          </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default panel-dashboard">
                    <div class="panel-heading">
                        <p class="lead">Contacts</p>
                        <a href="/contacts" class="pull-right">View all</a>
                    </div>
                    <div class="panel-body" style="height:500px; overflow-y:scroll;">
                        <contacts></contacts>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
