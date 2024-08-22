<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Result;
use App\Models\Label;
use App\Models\Implementation_status;
use App\Models\Assessment;
use App\Models\User_overview;
use App\Models\User_visa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class VendorController extends Controller
{
    // display vendor dashboard
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
        return redirect()->intended(route('vendor_dashboard'))->with('info', 'Password was updated!');
    }

    // display form
    public function form(): View
    {
        $user_overview = User_overview::where('user_id', Auth::id())->first();
        $user_visa = User_visa::where('user_id', Auth::id())->first();
        $user_visa_comment = User_visa::where('user_id', Auth::id())
            ->whereNotNull('halodoc_comment')
            ->first();
        $user_visa_feedback = User_visa::where('user_id', Auth::id())
            ->whereNotNull('vendor_feedback')
            ->first();
        return view('page.form', compact('user_overview', 'user_visa', 'user_visa_comment', 'user_visa_feedback'));
    }

    // display form overview
    public function formOverview(): View
    {
        return view('page.form_overview');
    }

    // form overview Post
    public function formOverviewPost(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'vendor_information' => ['required', 'string', 'max:800'],
            'vendor_name' => ['required', 'string', 'max:100'],
            'vendor_pic' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:300'],
            'vendor_email_address' => ['required', 'string', 'max:100'],
            'data_sensitivty' => ['required', 'string', 'max:300'],
        ]);

        $user_overview = User_overview::create([
            'user_id' => $request->user_id,
            'vendor_information' => $request->vendor_information,
            'vendor_name' => $request->vendor_name,
            'vendor_pic' => $request->vendor_pic,
            'address' => $request->address,
            'vendor_email_address' => $request->vendor_email_address,
            'data_sensitivty' => $request->data_sensitivty,
        ]);

        event(new Registered($user_overview));

        $user = Auth::user();
        // Check and update the results table
        $result = Result::where('user_id', $user->id)->first();

        if ($result) {
            // Update existing result
            $result->update([
                'overview' => true,
                'result_status_id' => 2,
                'completed_at' => $result->updated_at,
            ]);
        } else {
            // Create new result entry
            Result::create([
                'user_id' => $user->id,
                'overview' => true,
                'visa' => false,
                'result_status_id' => 1,
            ]);
        }
        return redirect()->intended(route('vendor_form'))->with('info', 'Overview has been answered!');
    }


    // display form Visa
    public function formVisa(): View
    {
        $implementation_status = Implementation_status::all();
        $assessments = Assessment::where('visibility', 1)
            ->orderBy('label_id')
            ->get();
        $label_ids = $assessments->pluck('label_id')->unique();
        $labels = Label::whereIn('id', $label_ids)->get();
        return view('page.form_visa', compact('assessments', 'labels', 'implementation_status'));
    }

    // form Visa Post
    public function formVisaPost(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'assessment_id.*' => 'required|exists:assessments,id',
            'implementation_status_id.*' => 'required|numeric',
            'answer.*' => 'required|string',
            'evidence.*' => 'required|string',
            'remarks.*' => 'required|string',
        ]);

        foreach ($data['assessment_id'] as $index => $assessmentId) {
            $implementation_status_id = $data['implementation_status_id'][$index] ?? 4;
            User_visa::create([
                'user_id' => $user->id,
                'assessment_id' => $assessmentId,
                'implementation_status_id' => $implementation_status_id,
                'answer' => $data['answer'][$index],
                'evidence' => $data['evidence'][$index],
                'remarks' => $data['remarks'][$index],
            ]);
        }

        // Check and update the results table
        $result = Result::where('user_id', $user->id)->first();

        if ($result) {
            // Update existing result
            $result->update([
                'visa' => true,
                'result_status_id' => 2,
                'completed_at' => $result->updated_at,
            ]);
        } else {
            // Create new result entry
            Result::create([
                'user_id' => $user->id,
                'overview' => false,
                'visa' => true,
                'result_status_id' => 1,
            ]);
        }

        return redirect()->route('vendor_form')->with('info', 'Visa form has been submitted!');
    }

    // display form Visa Feedback
    public function formVisaFeedback()
    {
        $user_id = Auth::user()->id;
        $labels = Label::all();
        $result = Result::where('user_id', $user_id)->firstOrFail();
        $user_overview = User_overview::where('user_id', $user_id)->firstOrFail();
        $user_visa = User_visa::where('user_id', $user_id)->get();
        $assessment_ids = $user_visa->pluck('assessment_id')->unique();

        $assessments = Assessment::whereIn('id', $assessment_ids)
            ->orderBy('label_id')
            ->get();
        $label_ids = $assessments->pluck('label_id')->unique();
        $labels = Label::whereIn('id', $label_ids)->get();
        return view('page.result_feedback', compact('labels', 'assessments', 'result', 'user_overview', 'user_visa'));
    }

    // update result/give Comment submit
    public function formVisaFeedbackPost(Request $request)
    {
        $user_id = Auth::user()->id;
        $data = $request->validate([
            'assessment_id.*' => 'required|exists:assessments,id',
            'vendor_feedback.*' => 'required|string'
        ]);

        foreach ($data['assessment_id'] as $index => $assessmentId) {
            $user_visa = User_visa::where('user_id', $user_id)
                ->where('assessment_id', $assessmentId)
                ->first();
            if ($user_visa) {
                $user_visa->update([
                    'vendor_feedback' => $data['vendor_feedback'][$index],
                ]);
            }
        }

        $result = Result::where('user_id', $user_id)->first();

        if ($result) {
            // Update existing result
            $result->result_status_id = 4;
            $result->save();
        }
        return redirect()->intended(route('vendor_form'))->with('info', 'Feedback has been sent!');
    }
}
