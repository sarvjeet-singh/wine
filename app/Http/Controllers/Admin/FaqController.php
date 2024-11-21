<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqSection;
use App\Models\FaqQuestion;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\FaqSectionRequest;
use App\Http\Requests\FaqQuestionRequest;
use App\Traits\ErrorHandler;
use DB;

class FaqController extends Controller
{
    use ErrorHandler;
    /**
     * Display a listing of the packages.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Render index view
        return view('admin.faqs.index');
    }

    /**
     * Get all vehicle types for DataTables.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        try {
            // Select fields to fetch from the repository
            $fields = ['id', 'account_type', 'section_name', 'status', 'created_at', 'updated_at'];
            $faqs = FaqSection::select($fields)
                ->orderBy('id', 'desc')
                ->get();;

            // Return data formatted for DataTables
            return DataTables::of($faqs)
                ->addColumn('action', function ($faq) {
                    // Render actions view with vehicle type data
                    return view('admin.faqs.partials.actions', compact('faq'))->render();
                })
                ->editColumn('created_at', function ($faq) {
                    // Format the created_at date
                    return $faq->created_at->format('m/d/Y h:i:s A');
                })
                ->editColumn('account_type', function ($faq) {
                    // Format the updated_at date
                    return ucfirst($faq->account_type);
                })
                ->editColumn('updated_at', function ($faq) {
                    // Format the updated_at date
                    return $faq->updated_at->format('m/d/Y h:i:s A');
                })
                ->make(true); // Return JSON response for DataTables
        } catch (\Exception $e) {
            // Handle exceptions and return error response
            return $this->handleJsonException($e);
        }
    }

    public function checkDuplicate(Request $request)
    {
        $isUnique = !FaqSection::where('section_name', $request->section_name)
            ->where('account_type', $request->account_type)
            ->exists();
        return response()->json(['is_unique' => $isUnique]);
    }

    /**
     * Toggle the status of a faq.
     *
     * @param int $faq_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus($faq_id)
    {
        try {
            // Find the package by ID
            $faq = FaqSection::find($faq_id);

            // Check if the package exists
            if (!$faq) {
                // If the package does not exist, throw an exception with a specific error message
                return $this->handleError('Faq not found.', true, 404);
            }

            // Toggle the status field
            $faq->status = $faq->status == 0 ? 1 : 0;
            $faq->save();

            // Return success JSON response
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            // Handle exceptions and return error response
            return $this->handleJsonException($e);
        }
    }

    /**
     * Show the form for creating a new package.
     *
     * @return \Illuminate\View\View
     */
    public function createSection()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.faqs.add-section', compact('categories'));
    }

    public function editSection($id)
    {
        $section = FaqSection::find($id);
        $categories = Category::where('status', 1)->get();
        return view('admin.faqs.add-section', compact('section', 'categories'));
    }

    public function createQuestion($section_id)
    {
        $questions = FaqQuestion::where('faq_section_id', $section_id)->get();
        return view('admin.faqs.add-question', compact('section_id', 'questions'));
    }

    /**
     * Store a newly created package in storage.
     *
     * @param StorePackageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeSection(FaqSectionRequest $request)
    {
        try {
            // Validate and get validated data
            $data = $request->validated();
            $message = '';
            if (isset($data['id'])) {
                $faq = FaqSection::find($data['id']);
                $faq->section_name = $data['section_name'];
                $faq->account_type = $data['account_type'];
                $created = $faq->save();
                $message = 'Section updated successfully.';
            } else {
                $faq = new FaqSection();
                $faq->section_name = $data['section_name'];
                $faq->account_type = $data['account_type'];
                $created = $faq->save();
                $message = 'Section created successfully.';
            }

            if ($created) {
                // Redirect with success message
                return response()->json([
                    'success' => true,
                    'message' => $message,
                ], 200);
            } else {
                // Redirect with error message
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create section.',
                ], 500);
            }
        } catch (\Exception $e) {
            // Handle exceptions and redirect back with error message
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function storeQuestion(FaqQuestionRequest $request, $section_id)
    {
        try {
            // Validate and get validated data
            $data = $request->validated();
            // Start a database transaction
            DB::beginTransaction();

            // Initialize an empty array to hold created items
            $createdItems = [];
            $message = '';
            // Loop through questions and answers
            foreach ($data['question'] as $index => $question) {
                // Check if corresponding answer exists
                if (isset($data['answer'][$index])) {
                    // Create a new FAQ using the repository
                    if (isset($data['question_id'][$index]) && $data['question_id'][$index] > 0) {
                        $created = FaqQuestion::where('id', $data['question_id'][$index])->update([
                            'question' => $question,
                            'answer' => $data['answer'][$index],
                            'faq_section_id' => $section_id,
                        ]);
                        $message = 'Question updated successfully.';
                    } else {
                        $created = FaqQuestion::create([
                            'question' => $question,
                            'answer' => $data['answer'][$index],
                            'faq_section_id' => $section_id,
                        ]);
                        $message = 'Question added successfully.';
                    }

                    // Store the result of each creation attempt
                    $createdItems[] = $created;
                }
            }

            // Check if any items were created successfully
            if (in_array(true, $createdItems)) {
                // Commit the transaction
                DB::commit();
                // Redirect with success message
                return response()->json([
                    'success' => true,
                    'message' => $message,
                ], 200);
            } else {
                // Rollback the transaction if no items were created
                DB::rollBack();
                // Redirect with error message
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add questions.',
                ], 500);
            }
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();
            // Handle exceptions and redirect back with error message
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified package from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $faq = FaqSection::find($id);
            if (!$faq) {
                // If the package does not exist, throw an exception with a specific error message
                return $this->handleError('Faq not found.', true, 404);
            }
            // Delete the package using repository
            $faq->delete($id);

            // Return success JSON response
            return response()->json(['message' => 'Faq deleted successfully']);
        } catch (\Exception $e) {
            // Handle exceptions and return error response
            return $this->handleJsonException($e);
        }
    }

    public function destroyQuestion($id)
    {
        try {
            $faq = FaqQuestion::find($id);
            if (!$faq) {
                // If the package does not exist, throw an exception with a specific error message
                return $this->handleError('Question not found.', true, 404);
            }
            // Delete the package using repository
            $faq->delete($id);

            // Return success JSON response
            return response()->json(['message' => 'Question deleted successfully']);
        } catch (\Exception $e) {
            // Handle exceptions and return error response
            return $this->handleJsonException($e);
        }
    }
}
