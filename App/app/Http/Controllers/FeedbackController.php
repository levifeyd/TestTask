<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FeedbackController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct() {
        $this->middleware('permission:feedback-list', ['only' => ['index','show']]);
        $this->middleware('permission:feedback-create', ['only' => ['create','store']]);
        $this->middleware('permission:feedback-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:feedback-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $feedbacks = Feedback::sortable()->paginate($limit);

        return view('feedbacks.index',compact('feedbacks'))
            ->with('i', (request()->input('page', 1) - 1) * 5)
            ->with('limit', $limit);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('feedbacks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        request()->validate([
            'title' => 'required',
            'detail' => 'required',
            'file' => 'required|file|mimes:jpg,png,jpeg,xls,pdf|max:3072'
        ]);
        $lastFeedback = Feedback::where('user_id', Auth::user()->id)->latest()->first();
        if (!is_null($lastFeedback) && Carbon::now()->diffInDays($lastFeedback->created_at) < 1) {
            return back()->withErrors( 'You can create feeedback only once a day');
        }
        $fileName = time() . '_' . $request->file->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('/', $fileName, 'public');

        $input = $request->all();
        $input['filename'] = $filePath;
        $input['user_id'] = Auth::user()->id;
        Feedback::create($input);

        return redirect()->route('feedbacks.index')
            ->with('success','Feedback created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        return view('feedbacks.show',compact('feedback'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {
        return view('feedbacks.edit',compact('feedback'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $feedback->update($request->all());

        return redirect()->route('feedbacks.index')
            ->with('success','Feedback updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return redirect()->route('feedbacks.index')
            ->with('success','Feedback deleted successfully');
    }
}
