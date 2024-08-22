<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Result;
use App\Models\Label;
use App\Models\Assessment;
use App\Models\User_overview;
use App\Models\User_visa;
use App\Models\Result_status;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;

class GuestController extends Controller
{
    // display guest dashboard
    public function index(): View
    {
        $user = User::with('role')->get();
        $search = null;
        return view('page.dashboard', compact('user', 'search'));
    }

    // profile
    public function profile()
    {
        $user = Auth::user();
        return view(
            'page.profile',
            compact('user')
        );
    }

    // profile submit
    public function profilePost(Request $request, String $id)
    {
        $rules = [
            'password' => 'required|min:8'
        ];
        $validatedData = $request->validate($rules);

        $user = User::findOrFail($id);
        $user->update($validatedData);
        return redirect()->intended(route('guest_dashboard'))->with('info', 'Password was updated!');
    }

    // display result
    public function result(): View
    {
        $count = [
            '1'  => Result::where('result_status_id', 1)->count(),
            '2'  => Result::where('result_status_id', 2)->count(),
            '3'  => Result::where('result_status_id', 3)->count(),
            '4'  => Result::where('result_status_id', 4)->count(),
            '5'  => Result::where('result_status_id', 5)->count()
        ];
        $results = Result::paginate(10);
        $results_status = Result_status::all();
        $search = null;
        return view('page.result', compact('results', 'results_status', 'count', 'search'));
    }

    // search result
    public function searchResult(Request $request)
    {
        $search = $request->input('search');
        $results = Result::whereHas('user', function ($query) use ($search) {
            $query->where('username', 'like', "%{$search}%");
        })
            ->orWhereHas('result_status', function ($query) use ($search) {
                $query->where('result_status', 'like', "%{$search}%");
            })
            ->with('user', 'result_status')
            ->paginate(10);
        $results_status = Result_status::all();
        $search_result = route('guest_search_result');
        if ($request->ajax()) {
            return view('page.partials.table_result', compact('results', 'results_status', 'search_result'))->render();
        }
    }

    // view result
    public function resultView(String $user_id)
    {
        $result = Result::where('user_id', $user_id)->firstOrFail();
        $user_overview = User_overview::where('user_id', $user_id)->first();
        $user_visa = User_visa::where('user_id', $user_id)->get();
        $assessment_ids = $user_visa->pluck('assessment_id')->unique();
        $assessments = Assessment::whereIn('id', $assessment_ids)->get();
        $label_ids = $assessments->pluck('label_id')->unique();
        $labels = Label::whereIn('id', $label_ids)->get();
        return view('page.result_view', compact('labels', 'result', 'user_overview', 'user_visa'));
    }

    // Download Result PDF
    public function resultDownload(String $user_id)
    {
        $result = Result::where('user_id', $user_id)->firstOrFail();
        $user_overview = User_overview::where('user_id', $user_id)->first();
        $user_visa = User_visa::where('user_id', $user_id)->get();
        $assessment_ids = $user_visa->pluck('assessment_id')->unique();
        $assessments = Assessment::whereIn('id', $assessment_ids)->get();
        $label_ids = $assessments->pluck('label_id')->unique();
        $labels = Label::whereIn('id', $label_ids)->get();
        // return view('page.result_pdf', compact('labels', 'result', 'user_overview', 'user_visa'));

        $pdf = PDF::loadView('page/result_pdf', compact('result', 'user_overview', 'user_visa', 'labels'));
        return $pdf->download('assessment_result_' . $result->user['username'] . '_' . $result->user['id'] . '.pdf');
    }
}
