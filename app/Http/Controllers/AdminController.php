<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Implementation_status;
use App\Models\User;
use App\Models\Label;
use App\Models\Role;
use App\Models\Result;
use App\Models\Result_status;
use App\Models\User_overview;
use App\Models\User_visa;
use App\Mail\ResultEmail;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    //display admin dashboard
    public function index(): View
    {
        $users = User::with('role')->paginate(10);
        $count = [
            'number_of_user'    => User::count(),
            'number_of_admin'  => User::where('role_id', 1)->count(),
            'number_of_vendor'  => User::where('role_id', 2)->count(),
            'number_of_guest'   => User::where('role_id', 3)->count()
        ];
        $search = null;
        return view('page.dashboard', compact('users', 'count', 'search'));
    }

    // search user
    public function searchUser(Request $request)
    {
        $search = $request->input('search');
        $users = User::where('username', 'like', "%{$search}%")
            ->orWhereHas('role', function ($query) use ($search) {
                $query->where('role', 'like', "%{$search}%");
            })
            ->with('role')
            ->paginate(10);
        if ($request->ajax()) {
            return view('page.partials.table_user', compact('users'))->render();
        }
    }

    // delete user
    public function userDelete(String $id)
    {
        Result::where('user_id', $id)->delete();
        User_overview::where('user_id', $id)->delete();
        User_visa::where('user_id', $id)->delete();
        User::destroy($id);
        return redirect()->intended(route('admin_dashboard'))->with('error', 'User has been deleted!');;
    }

    // update user
    public function userUpdate(String $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('page.user_update', compact('user', 'roles'));
    }

    // update user submit
    public function userUpdatePost(Request $request, String $id)
    {

        $rules = [
            'password' => 'required|min:8',
            'role_id' => 'required'
        ];
        $user = User::findOrFail($id);

        if ($request->username != $user->username) {
            $rules['username'] = ['required', 'string', 'max:255', 'unique:' . User::class];
        }

        $validatedData = $request->validate($rules);

        $user->update($validatedData);
        return redirect()->intended(route('admin_dashboard'))->with('info', 'User was updated!');
    }

    // profile
    public function profile()
    {
        $user = Auth::user();
        return view('page.profile', compact('user'));
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
        return redirect()->intended(route('admin_dashboard'))->with('info', 'Password was updated!');
    }

    // display assessment
    public function assessment(): View
    {
        $visibleCount = Assessment::where('visibility', 1)->count();
        $assessments = Assessment::with('label')->paginate(10);
        $search = null;
        return view('page.assessment', compact('assessments', 'visibleCount', 'search'));
    }

    // search assessment
    public function searchAssessment(Request $request)
    {
        $search = $request->input('search');
        $visibilityValue = null;

        if (strtolower($search) === 'true') {
            $visibilityValue = true;
        } elseif (strtolower($search) === 'false') {
            $visibilityValue = false;
        }

        $assessments = Assessment::where('question', 'like', "%{$search}%")
            ->orWhere('halodoc_expectation', 'like', "%{$search}%")
            ->orWhere('expected_evidence', 'like', "%{$search}%")
            ->orWhere(function ($query) use ($visibilityValue) {
                if (!is_null($visibilityValue)) {
                    $query->where('visibility', $visibilityValue);
                }
            })
            ->orWhereHas('label', function ($query) use ($search) {
                $query->where('label', 'like', "%{$search}%");
            })
            ->with('label')
            ->paginate(10);
        if ($request->ajax()) {
            return view('page.partials.table_assessment', compact('assessments'))->render();
        }
    }

    // delete assessment
    public function assessmentDelete(String $id)
    {
        Assessment::destroy($id);
        return redirect()->intended(route('admin_assessment'))->with('error', 'Assessment has been deleted!');;
    }

    // update assessment
    public function assessmentUpdate(String $id)
    {
        $assessment = Assessment::findOrFail($id);
        $count = Assessment::where('id', '<=', $id)->count();
        $labels = Label::all();
        return view('page.assessment_update', compact('assessment', 'labels', 'count'));
    }

    // assessment update submit
    public function assessmentUpdatePost(Request $request, String $id)
    {
        $rules = [
            'label_id' => 'required',
            'question' => ['required', 'string', 'max:700'],
            'halodoc_expectation' => ['required', 'string', 'max:700'],
            'expected_evidence' => ['required', 'string', 'max:700'],
        ];

        $assessment = Assessment::findOrFail($id);

        $validatedData = $request->validate($rules);
        $validatedData['visibility'] = $request->has('visibility') ? 1 : 0;

        $assessment->update($validatedData);
        return redirect()->intended(route('admin_assessment'))->with('info', 'Assessment was updated!');
    }

    // display assessment add
    public function assessmentAdd(): View
    {
        $labels = Label::all();
        $count = Assessment::count();
        return view('page.assessment_add', compact('labels', 'count'));
    }

    // assessment add submit
    public function assessmentAddPost(Request $request)
    {
        $request->validate([
            'label_id' => 'required',
            'question' => ['required', 'string', 'max:700'],
            'halodoc_expectation' => ['required', 'string', 'max:700'],
            'expected_evidence' => ['required', 'string', 'max:700'],
        ]);

        $assessment = Assessment::create([
            'label_id' => $request->label_id,
            'question' => $request->question,
            'halodoc_expectation' => $request->halodoc_expectation,
            'expected_evidence' => $request->expected_evidence,
        ]);

        event(new Registered($assessment));
        return redirect()->intended(route('admin_assessment'))->with('message', 'Assessment added successfully!');;
    }

    // display label
    public function label(): View
    {
        $labels = Label::paginate(10);
        $search = null;
        return view('page.label', compact('labels', 'search'));
    }

    // search label
    public function searchLabel(Request $request)
    {
        $search = $request->input('search');
        $labels = Label::where('label', 'like', "%{$search}%")
            ->orWhere('kode', 'like', "%{$search}%")
            ->paginate(10);
        if ($request->ajax()) {
            return view('page.partials.table_label', compact('labels'))->render();
        }
    }

    // delete label
    public function labelDelete(String $id)
    {
        Label::destroy($id);
        return redirect()->intended(route('admin_label'))->with('error', 'Label has been deleted!');;
    }

    // update label
    public function labelUpdate(String $id)
    {
        $label = Label::findOrFail($id);
        return view('page.label_update', compact('label'));
    }

    // update label submit
    public function labelUpdatePost(Request $request, String $id)
    {
        $rules = [
            'label' => ['required', 'string']
        ];

        $label = Label::findOrFail($id);

        if ($request->kode != $label->kode) {
            $rules['kode'] = ['required', 'string', 'max:255', 'unique:' . Label::class];
        }

        $validatedData = $request->validate($rules);

        $label->update($validatedData);
        return redirect()->intended(route('admin_label'))->with('info', 'Label was updated!');;
    }

    // display label add
    public function labelAdd(): View
    {
        return view('page.label_add');
    }

    // label add submit
    public function labelAddPost(Request $request)
    {
        $request->validate([
            'kode' => ['required', 'string', 'max:255', 'unique:' . Label::class],
            'label' => ['required', 'string']
        ]);

        $label = Label::create([
            'kode' => $request->kode,
            'label' => $request->label,
        ]);

        event(new Registered($label));
        return redirect()->intended(route('admin_label'))->with('message', 'Label added successfully!');;
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
        $search_result = route('admin_search_result');
        $results_status = Result_status::all();
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

    // Comment result
    public function resultComment(String $user_id)
    {
        $result = Result::where('user_id', $user_id)->firstOrFail();
        $user_overview = User_overview::where('user_id', $user_id)->firstOrFail();
        $user_visa = User_visa::where('user_id', $user_id)->get();
        $assessment_ids = $user_visa->pluck('assessment_id')->unique();

        $assessments = Assessment::whereIn('id', $assessment_ids)
            ->orderBy('label_id')
            ->get();
        $label_ids = $assessments->pluck('label_id')->unique();
        $labels = Label::whereIn('id', $label_ids)->get();
        return view('page.result_comment', compact('labels', 'assessments', 'result', 'user_overview', 'user_visa'));
    }

    // update result/give Comment submit
    public function resultCommentPost(Request $request, String $user_id)
    {
        $data = $request->validate([
            'assessment_id.*' => 'required|exists:assessments,id',
            'halodoc_comment.*' => 'required|string'
        ]);

        foreach ($data['assessment_id'] as $index => $assessmentId) {
            $user_visa = User_visa::where('user_id', $user_id)
                ->where('assessment_id', $assessmentId)
                ->first();
            if ($user_visa) {
                $user_visa->update([
                    'halodoc_comment' => $data['halodoc_comment'][$index],
                ]);
            }
        }

        $updated = User_visa::whereNotNull('halodoc_comment')->where('user_id', $user_id)->exists();
        if ($updated) {
            $result = Result::where('user_id', $user_id)->first();

            if ($result) {
                // Update existing result
                $result->result_status_id = 3;
                $result->save();
            }
            return redirect()->intended(route('admin_result'))->with('info', 'Comment has been sent!');
        } else {
            return redirect()->intended(route('admin_result'))->with('error', 'Comment not sent!');
        }
    }

    // result enough
    public function resultCommentEnough(String $user_id)
    {
        $result = Result::where('user_id', $user_id)->first();

        if ($result) {
            // Update existing result
            $result->result_status_id = 5;
            $result->save();
        }
        return redirect()->intended(route('admin_result'))->with('info', 'VISA assessment is finished!');
    }

    // delete result
    public function resultDelete(String $user_id)
    {
        Result::where('user_id', $user_id)->delete();
        User_overview::where('user_id', $user_id)->delete();
        User_visa::where('user_id', $user_id)->delete();
        return redirect()->intended(route('admin_result'))->with('error', 'Result has been deleted!');
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

    // display Email
    public function resultEmail(String $user_id)
    {
        $result = Result::where('user_id', $user_id)->firstOrFail();
        $user_overview = User_overview::where('user_id', $user_id)->first();
        $subject = "Comments of Halodoc VISA Portal";
        $message = "Dear {$user_overview->vendor_pic},

We hope this message finds you well. We would like to inform you that we have reviewed the assessment completed by you as {$user_overview->vendor_name} in {$result->completed_at->translatedFormat('j F Y')}. We have provided some comments that require your attention.

Please find the detailed comments in VISA Portal via link below:
http://visa-portal-halodoc.test:8800/

We kindly request you to review these comments and take the necessary actions to address them. If you have any questions or need further clarification, please do not hesitate to reach out to us.

Thank you for your cooperation and prompt attention to this matter.

Best regards,
ISDP Halodoc Team";

        return view('page.email', compact('user_overview', 'subject', 'message', 'result'));
    }

    // display Email Finish
    public function resultEmailFinish(String $user_id)
    {
        $result = Result::where('user_id', $user_id)->firstOrFail();
        $user_overview = User_overview::where('user_id', $user_id)->first();
        $subject = "Completion of Halodoc VISA Portal";
        $message = "Dear {$user_overview->vendor_pic},

We would like to express our gratitude for your participation and cooperation in completing the Information Security Assessment at Halodoc VISA Portal.

This assessment is a crucial step in ensuring that high standards of information security are maintained and that sensitive data managed by {$user_overview->vendor_name} is consistently protected at an optimal level.

We hope that the results of this assessment will serve as a strong foundation for further improvements and strengthening of your information security practices. If you have any questions or require further clarification, please do not hesitate to contact us.

Thank you for your attention and cooperation.

Best regards,
ISDP Halodoc Team";

        return view('page.email', compact('user_overview', 'subject', 'message', 'result'));
    }


    public function resultEmailPost(Request $request, $user_id)
    {
        // Validate request data
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Send the email
        Mail::to($request->email)->send(new ResultEmail($request->subject, $request->message));

        // Redirect back with a success message
        return redirect()->route('admin_result')->with('message', 'Email sent successfully.');
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
        return redirect()->intended(route('admin_form'))->with('info', 'Overview has been answered!');
    }

    // display form Visa
    public function formVisa(): View
    {
        $labels = Label::all();
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

        return redirect()->route('admin_form')->with('info', 'Visa form has been submitted!');
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
        return redirect()->intended(route('admin_form'))->with('info', 'Feedback has been sent!');
    }
}
