@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Feedbacks</h2>
            </div>
            <div class="pull-right">
                @can('feedback-create')
                    <a class="btn btn-success" href="{{ route('feedbacks.create') }}"> Create New Feedback</a>
                @endcan
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Client ID</th>
            <th>Client created datetime</th>
            <th>@sortablelink('created_at', 'Feedback created datetime')</th>
            <th>Client name</th>
            <th>Client email</th>
            <th>Feedback title</th>
            <th>Feedback details</th>
            <th>Feedback file link</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($feedbacks as $feedback)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $feedback->user_id }}</td>
                <td>{{ \App\Models\User::find($feedback->user_id)->created_at }}</td>
                <td>{{ $feedback->created_at }}</td>
                <td>{{ \App\Models\User::find($feedback->user_id)->name }}</td>
                <td>{{ \App\Models\User::find($feedback->user_id)->email }}</td>
                <td>{{ $feedback->title }}</td>
                <td>{{ $feedback->detail }}</td>
                <td>
                    <a href="{{$url = url('storage/app/public'.$feedback->filename)}}">
                        {{$feedback->filename}}
                    </a>
                </td>
                <td>
                    <form action="{{ route('feedbacks.destroy',$feedback->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('feedbacks.show',$feedback->id) }}">Show</a>
                        @can('feedback-edit')
                            <a class="btn btn-primary" href="{{ route('feedbacks.edit',$feedback->id) }}">Edit</a>
                        @endcan
                        @csrf
                        @method('DELETE')
                        @can('feedback-delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        @endcan
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {!! $feedbacks->appends($_GET)->links('pagination::bootstrap-4') !!}
@endsection
