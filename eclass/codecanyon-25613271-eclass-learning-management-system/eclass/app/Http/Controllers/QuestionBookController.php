<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\QuestionBook;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use PDF;
use App\QuestionBookPdf;
use Illuminate\Support\Facades\File;

class QuestionBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:questionbook.view', ['only' => ['index']]);
        $this->middleware('permission:questionbook.create', ['only' => [ 'store','import','generatePdf']]);
        $this->middleware('permission:questionbook.edit', ['only' => ['edit','update','noticestatus']]);
        $this->middleware('permission:questionbook.delete', ['only' => ['destroy','bulk_delete']]);
    
    }

    public function index()
    {
        return view('admin.course.question_book.index');
    }

    public function create()
    {

    }


    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'course_id' => 'required|integer',
            'type' => 'required|array',
            'question' => 'required|array',
            'type.*' => 'required|string|in:subjective,objective',
            'question.*' => 'required|string',
            'answer.*' => 'nullable|string', // Only required for subjective questions
            'option_one.*' => 'nullable|string', // Only required for objective questions
            'option_two.*' => 'nullable|string',
            'option_three.*' => 'nullable|string',
            'option_four.*' => 'nullable|string',
            'correct_option.*' => 'nullable|string', // Only required for objective questions
        ]);

        $courseId = $request->input('course_id');
        $types = $request->input('type');
        $questions = $request->input('question');
        $answers = $request->input('answer');
        $optionsOne = $request->input('option_one');
        $optionsTwo = $request->input('option_two');
        $optionsThree = $request->input('option_three');
        $optionsFour = $request->input('option_four');
        $correctOptions = $request->input('correct_option');

        foreach ($questions as $index => $questionText) {
            $question = new QuestionBook();
            $question->course_id = $courseId;
            $question->type = $types[$index];
            $question->question = $questionText;

            if ($types[$index] === 'subjective') {
                $question->answer = $answers[$index] ?? null;
            } else if ($types[$index] === 'objective') {
                $question->option_one = $optionsOne[$index] ?? null;
                $question->option_two = $optionsTwo[$index] ?? null;
                $question->option_three = $optionsThree[$index] ?? null;
                $question->option_four = $optionsFour[$index] ?? null;
                $question->correct_option = $correctOptions[$index] ?? null;
            }
            $question->save();
        }
        return redirect()->back()->with('success', 'Questions added successfully.');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $question = QuestionBook::find($id);
        $courses = Course::all();
        return view('admin.course.question_book.edit', compact('question','courses'));
    }

    public function destroy($id)
    {
        $notice = QuestionBook::findOrFail($id);
        $notice->delete();
        return redirect()->back()->with('success', 'Question Deleted successfully.');
    }

    public function bulk_delete(Request $request)
    {
        $validator = Validator::make($request->all(), ['checked' => 'required']);
        if ($validator->fails()) {
        return back()->with('error',trans('Please select field to be deleted.'));
        }
        QuestionBook::whereIn('id',$request->checked)->delete();

        return back()->with('error',trans('Selected Question has been deleted.'));      
    }


    public function update(Request $request, $id)
    {
        // Find the existing question
        $question = QuestionBook::find($id);
    
        // Validate the input data
        $request->validate([
            'course_id' => 'required|integer|exists:courses,id',
            'type' => 'required|string|in:subjective,objective',
            'question' => 'required|string|max:255',
            'answer' => 'nullable|string',
            'option_one' => 'nullable|string',
            'option_two' => 'nullable|string',
            'option_three' => 'nullable|string',
            'option_four' => 'nullable|string',
            'correct_option' => 'nullable|string',
        ]);
    
        // Update the question
        $question->course_id = $request->course_id;
        $question->type = $request->type;
        $question->question = $request->question;
    
        if ($request->type == 'subjective') {
            $question->answer = $request->answer;
            $question->option_one = null;
            $question->option_two = null;
            $question->option_three = null;
            $question->option_four = null;
            $question->correct_option = null;
        } elseif ($request->type == 'objective') {
            $question->answer = null;
            $question->option_one = $request->option_one;
            $question->option_two = $request->option_two;
            $question->option_three = $request->option_three;
            $question->option_four = $request->option_four;
            $question->correct_option = $request->correct_option;
        }
    
        // Save the changes
        $question->save();
    
        // Redirect or return a response
        return redirect()->back()->with('success', 'Question updated successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        $file = $request->file('file');
        $fileContents = file($file->getPathname());
        $header = str_getcsv(array_shift($fileContents));

        foreach ($fileContents as $line) {
            $data = str_getcsv($line);

            // Ensure that the CSV line has the correct number of fields
            if (count($data) === count($header)) {
                $data = array_combine($header, $data);

                // Extract data based on CSV fields and database columns
                QuestionBook::updateOrInsert(
                    ['course_id' => $data['course_id'], 'question' => $data['question']], // Unique constraints
                    [
                        'type'           => $data['type'] ?? null, // Optional field
                        'answer'         => $data['answer'] ?? null,
                        'option_one'     => $data['option_one'] ?? null,
                        'option_two'     => $data['option_two'] ?? null,
                        'option_three'   => $data['option_three'] ?? null,
                        'option_four'    => $data['option_four'] ?? null,
                        'correct_option' => $data['correct_option'] ?? null,
                    ]
                );
            } else {
                // Handle rows with incorrect number of columns
                continue; // Skip this line if it doesn't match the header count
            }
        }

        return redirect()->back()->with('success', 'Data imported successfully.');
    }    

  
    public function generatePdf(Request $request)
    {
        $courseId = $request->query('course_id');

        $questions = QuestionBook::where('course_id', $courseId)
            ->orderBy('created_at', 'desc')
            ->get();

        $course = Course::find($courseId);

        if ($questions->isEmpty()) {
            return response()->json(['error' => 'No questions found for this course'], 400);
        }

        $pdf = PDF::loadView('admin.course.question_book.pdf', [
            'questions' => $questions,
            'course' => $course
        ]);

        // Check if a PDF already exists for this course
        $existingPdf = QuestionBookPdf::where('course_id', $courseId)->first();

        if ($existingPdf) {
            // Use the existing filename
            $fileName = $existingPdf->file_name;
        } else {
            // Generate a new filename
            $fileName = 'questionbook_' . $courseId . '.pdf';
        }
        
        // Create the directory if it doesn't exist
        $directory = public_path('images/question_book_pdfs');
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }

        // Full path for the file
        $filePath = $directory . '/' . $fileName;

        // Save the PDF to the filesystem
        $pdf->save($filePath);

        if ($existingPdf) {
            // Update the existing record's updated_at timestamp
            $existingPdf->touch();
        } else {
            // Create a new QuestionBookPdf record
            QuestionBookPdf::create([
                'course_id' => $courseId,
                'file_name' => $fileName,
            ]);
        }

        // Return the PDF for download
        return response()->download($filePath, $fileName);
    }
}
