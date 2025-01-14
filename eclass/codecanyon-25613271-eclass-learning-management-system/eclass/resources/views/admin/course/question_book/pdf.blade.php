<!DOCTYPE html>
<html>

<head>
    <title>Question Book</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .objective-options {
            list-style-type: none;
            padding: 0;
        }

        .objective-options li {
            padding: 4px 0;
        }
    </style>
</head>

<body>
    <h1>{{ __('Question Book') }}</h1>

    <h2>{{ __('Course: ') }} {{ $course->title }}</h2>

    @php
    // Check if there are any subjective questions
    $hasSubjectiveQuestions = $questions->where('type', 'subjective')->isNotEmpty();
    // Check if there are any objective questions
    $hasObjectiveQuestions = $questions->where('type', 'objective')->isNotEmpty();
    @endphp

    @if($hasSubjectiveQuestions)
    <h2>{{ __('Subjective Questions') }}</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('Question') }}</th>
                <th>{{ __('Answer') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions->where('type', 'subjective')->values() as $index => $question)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $question->question }}</td>
                <td>{!! $question->answer !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if($hasObjectiveQuestions)
    <h2>{{ __('Objective Questions') }}</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('Question') }}</th>
                <th>{{ __('Options') }}</th>
                <th>{{ __('Correct Option') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions->where('type', 'objective')->values() as $index => $question)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $question->question }}</td>
                <td>
                    <ul class="objective-options">
                        @if($question->option_one) <li>{{ __('Option A: ') }} {{ $question->option_one }}</li> @endif
                        @if($question->option_two) <li>{{ __('Option B: ') }} {{ $question->option_two }}</li> @endif
                        @if($question->option_three) <li>{{ __('Option C: ') }} {{ $question->option_three }}</li> @endif
                        @if($question->option_four) <li>{{ __('Option D: ') }} {{ $question->option_four }}</li> @endif
                    </ul>
                </td>
                <td>{{ $question->correct_option }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</body>

</html>
