<?php

namespace App\Http\Requests;

use App\Models\Jobs;
use Illuminate\Foundation\Http\FormRequest;


class BaseRequest extends FormRequest
{
    protected $model;

    public function __construct($model)
    {
        parent::__construct();

        $this->model = $model;
    }
    /**
     * Retrieve the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules()
    {
        // Define the allowed models for validation
        $allowedModels = [
            Jobs::class,
        ];

        // Check if the provided model is valid
        if (!in_array($this->model, $allowedModels)) {
            throw new \InvalidArgumentException("Invalid model for validation");
        }

        // Get the table name of the model
        $tableName = (new $this->model)->getTable();

        // Define the common validation rules
        return [
            'search' => 'sometimes|string|max:255',
        ];
    }
}
