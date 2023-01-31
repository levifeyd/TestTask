@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Feedback</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('feedbacks.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('feedbacks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Title:</strong>
                    <input name="title" type="text"  class="form-control" placeholder="Title" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Detail:</strong>
                    <input class="form-control" style="height:100px" name="detail"  required>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <input type="file" id="file" name="file" class="form-control" placeholder="Enter File" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center"><br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection
