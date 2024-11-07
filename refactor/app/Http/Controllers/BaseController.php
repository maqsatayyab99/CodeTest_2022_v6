<?php

namespace DTApi\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BaseController extends Controller
{
    /**
     * Execute the given callback within a try-catch block.
     * If an exception is thrown, return a JSON response with the error message.
     *
     * @param \Closure $callback The callback function to be executed.
     * @return JsonResponse The JSON response.
     */
    protected function tryCatch(\Closure $callback): JsonResponse
    {
        try {
            return $callback();
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Validate the given ID against the specified model class.
     * If the validation fails, throw a ValidationException.
     *
     * @param mixed $id The ID to be validated.
     * @param string $modelClass The fully qualified class name of the model.
     * @throws ValidationException
     * @return void
     */

    protected function validateId($id, $modelClass)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:' . $modelClass . ',id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
