<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment Result PDF</title>
    <style>
        body {
            font-family: 'Arial, sans-serif';
            color: #333;
            margin: 4.5rem 2.5rem 0rem 2.5rem;
            padding: 0;
        }
        .header, .footer {
            width: 100%;
            position: fixed;
        }
        
        .header {
            top: 0px;
        }
        .footer {
            text-align: center;
            bottom: 0px;
        }
        .pagenum:before {
            content: counter(page);
        }
        .container {
            width: 100%;
            box-sizing: border-box;
            margin-top: 30px;
        }
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        h4 {
            font-size: 14px;
            padding: -20px;
            margin-bottom: 20px;
        }
        .section-title-1 {
            text-transform: uppercase;
            margin-top: 30px;
            margin-bottom: 10px;
            padding: 10px 0px;
            font-weight: bold;
        }
        .section-title-2 {
            text-transform: uppercase;
            margin-top: 15px;
            margin-bottom: 5px;
            padding: 10px 0px;
            font-weight: bold;
        }
        .label {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 5px;
        }
        .label-question {
            text-transform: uppercase;
            font-weight: bold;
            margin-top: 5px;
            margin-bottom: 5px;
        }
        .label-first {
            font-weight: bold;
            margin-top: 5px;
            margin-bottom: 5px;
        }
        .label_visa {
            text-transform: uppercase;
            font-weight: bold;
            margin-top: 5px;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 10px;
        }
        .border-box {
            border: 1px solid #ccc;
            padding: 15px;
            margin-top: 5px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .border-box-answer {
            border: 1px solid #ccc;
            padding: 15px;
            margin-top: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .visa-box {
            padding: 0px 15px;
            margin-bottom: 20px;
        }
        .page-break {
            page-break-before: always;
        }
        .date {
            font-size: 14px;
            margin-top: -10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('asset/image/halodoc-logo.png') }}" alt="Your Company" style="height: 35px; margin-bottom:-25px;">
        @if ($result->overview)
            <h4>Assessment Result of {{ $user_overview->vendor_name }}</h4>
        @else
            <h4>Assessment Result of {{ $result->user['username'] }}</h4>
        @endif
    </div>
    <div class="container">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
            @if ($result->overview)
                Assessment Result of <span class="uppercase">{{ $user_overview->vendor_name }}</span>
            @else
                Assessment Result of <span class="uppercase">{{ $result->user['username'] }}</span>
            @endif
        </h2>
        <div class="date">Finished at {{ $result->updated_at->translatedFormat('j F Y, H:i:s') }}</div>
        @if ($result->overview)
            <div class="section-title-1">A. Overview</div>
            <div class="border-box">
                <div class="label-first">Vendor Information</div>
                <div class="content">{{ $user_overview->vendor_information }}</div>
                <div class="label">Vendor's Name</div>
                <div class="content">{{ $user_overview->vendor_name }}</div>
                <div class="label">Vendor's PIC</div>
                <div class="content">{{ $user_overview->vendor_pic }}</div>
                <div class="label">Address</div>
                <div class="content">{{ $user_overview->address }}</div>
                <div class="label">Vendor's Email Address</div>
                <div class="content">{{ $user_overview->vendor_email_address }}</div>
                <div class="label">Data Sensitivity</div>
                <div class="content">{{ $user_overview->data_sensitivty }}</div>
            </div>
        @endif 

        @if ($result->overview && $result->visa)
        <div class="page-break"></div>
        @endif
        
        @if ($result->visa)
            <div class="section-title-2">B. VISA</div>
            @php
                $deleteLabelAssessment = [];
                foreach ($user_visa as $visa){
                    $deleteLabelAssessment[$visa->id] = true;
                }
            @endphp
            @php $num_label = 1; @endphp
            @foreach ($labels as $label)
                <div class="visa-box">
                    <div class="label_visa">{{ $num_label++ }}. {{ $label->label }}</div>
                    @php $num = 1; @endphp
                    @foreach ($user_visa as $visa)
                        @if ($visa->assessment)
                            @if ($visa->assessment->label_id == $label->id)
                                @php
                                    unset($deleteLabelAssessment[$visa->id]);
                                @endphp
                                <div class="label-question">Question {{ $num++ }}</div>
                                <div class="content">{!! nl2br(e($visa->assessment->question)) !!}</div>
                                <div class="label">Halodoc Expectation</div>
                                <div class="content">{!! nl2br(e($visa->assessment->halodoc_expectation)) !!}</div>
                                <div class="label">Expected Evidence</div>
                                <div class="content">{!! nl2br(e($visa->assessment->expected_evidence)) !!}</div>
                                <div class="border-box-answer">
                                    <div class="label-first">Implementation Status</div>
                                    <div class="content">{!! nl2br(e($visa->implementation_status->status)) !!}</div>
                                    <div class="label">Answer</div>
                                    <div class="content">{!! nl2br(e($visa->answer)) !!}</div>
                                    <div class="label">Evidence</div>
                                    <div class="content">{!! nl2br(e($visa->evidence)) !!}</div>
                                    <div class="label">Remarks</div>
                                    <div class="content">{!! nl2br(e($visa->remarks)) !!}</div>
                                    @if ($visa->halodoc_comment || $visa->vendor_feedback)
                                        @if ($visa->halodoc_comment)
                                            <div class="label">Halodoc Comment</div>
                                            <div class="content">{!! nl2br(e($visa->halodoc_comment)) !!}</div>
                                        @endif  
                                        @if ($visa->vendor_feedback)
                                            <div class="label">Vendor Feedback</div>
                                            <div class="content">{!! nl2br(e($visa->vendor_feedback)) !!}</div>
                                        @endif
                                    @endif
                                </div>
                                @if (!$loop->last || !empty($deleteLabelAssessment))
                                    <div class="page-break"></div>
                                @endif
                            @endif
                        @endif         
                    @endforeach
                </div>
            @endforeach
            @if((!empty($deleteLabelAssessment)))
                <div class="visa-box">
                    <div class="label_visa">{{ $num_label++ }}. Deleted Label & Assessment</div>
                    @php
                        $num = 1;
                        $deleteLabelAssessmentKeys = array_keys($deleteLabelAssessment);
                        $lastDeleteLabelIndex = count($deleteLabelAssessmentKeys) - 1;
                    @endphp
                    @foreach ($user_visa as $visa)
                        @if (isset($deleteLabelAssessment[$visa->id]))
                            @php
                                $currentIndex = array_search($visa->id, $deleteLabelAssessmentKeys);
                            @endphp
                            @if (isset($visa->assessment))
                                <div class="label-question">Question {{ $num++ }}</div>
                                <div class="content">{!! nl2br(e($visa->assessment->question)) !!}</div>
                                <div class="label">Halodoc Expectation</div>
                                <div class="content">{!! nl2br(e($visa->assessment->halodoc_expectation)) !!}</div>
                                <div class="label">Expected Evidence</div>
                                <div class="content">{!! nl2br(e($visa->assessment->expected_evidence)) !!}</div>
                            @else
                                <div class="label-question">Question {{ $num++ }}</div>
                                <div class="content">[Assessment has been deleted]</div>
                            @endif
                            <div class="border-box-answer">
                                <div class="label-first">Implementation Status</div>
                                <div class="content">{!! nl2br(e($visa->implementation_status->status)) !!}</div>
                                <div class="label">Answer</div>
                                <div class="content">{!! nl2br(e($visa->answer)) !!}</div>
                                <div class="label">Evidence</div>
                                <div class="content">{!! nl2br(e($visa->evidence)) !!}</div>
                                <div class="label">Remarks</div>
                                <div class="content">{!! nl2br(e($visa->remarks)) !!}</div>
                                @if ($visa->halodoc_comment || $visa->vendor_feedback)
                                    @if ($visa->halodoc_comment)
                                        <div class="label">Halodoc Comment</div>
                                        <div class="content">{!! nl2br(e($visa->halodoc_comment)) !!}</div>
                                    @endif  
                                    @if ($visa->vendor_feedback)
                                        <div class="label">Vendor Feedback</div>
                                        <div class="content">{!! nl2br(e($visa->vendor_feedback)) !!}</div>
                                    @endif
                                @endif
                            </div>
                            @if ($currentIndex !== $lastDeleteLabelIndex)
                                <div class="page-break"></div>
                            @endif
                        @endif
                    @endforeach
                </div>
            @endif
        @endif        
    </div>
    <div class="footer bottom-0">
        <p><span class="pagenum"></span></p>
    </div>
</body>
</html>
