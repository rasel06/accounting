<?php
// app/Traits/Processable.php
namespace App\Livewire\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait Processable
{
    // Create a new model instance
    public function createModel(array $attributes)
    {
        $model = new static();
        $this->validateAttributes($attributes, $model);
        $model->fill($attributes);
        $model->save();

        return $model;
    }

    // Read a model instance by ID
    public function readModel($id)
    {
        return static::findOrFail($id);
    }

    // Update a model instance by ID
    public function updateModel($id, array $attributes)
    {
        $model = static::findOrFail($id);
        $this->validateAttributes($attributes, $model);
        $model->fill($attributes);
        $model->save();

        return $model;
    }

    // Delete a model instance by ID
    public function deleteModel($id)
    {
        $model = static::findOrFail($id);
        $model->delete();

        return $model;
    }

    // Validate attributes against the model's rules
    protected function validateAttributes(array $attributes, Model $model)
    {
        $validator = Validator::make($attributes, $model->rules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    // Optionally define validation rules in the model
    public function rules()
    {
        return [];
    }
}
