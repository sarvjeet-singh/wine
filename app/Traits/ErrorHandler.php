<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Redirect;

trait ErrorHandler
{
    /**
     * Handle errors with appropriate error message.
     *
     * @param string $errorMessage
     * @return \Illuminate\Http\RedirectResponse
     */
    private function handleError($errorMessage, $json = false, $statusCode = 500)
    {
        $message = env('APP_DEBUG') === true ? $errorMessage : 'An error occurred.';
        if ($json) {
            return response()->json(['error' => $message], $statusCode);
        }
        return redirect()->back()->with('error', $message)->withInput();
    }

    /**
     * Handle exceptions with appropriate error message.
     *
     * @param Exception $e
     * @return \Illuminate\Http\RedirectResponse
     */
    private function handleException(Exception $e,$redirect = true)
    {
        $message = env('APP_DEBUG') === true ? $e->getMessage() : 'An error occurred.';
        if ($redirect) {
            return redirect()->back()->with('error', $message)->withInput();
        }
        return Redirect::route('admin.dashboard')->with('error', $message);
    }

    /**
     * Handle exceptions with appropriate JSON response.
     *
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleJsonException(Exception $e)
    {
        $message = env('APP_DEBUG') === true ? $e->getMessage() : 'An error occurred.';
        return response()->json(['error' => $message], 500);
    }
}
