<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

trait HasFile
{
    public function upload_file(Request $request, string $column, string $folder): ?string
    {
        return $request->hasFile($column) ? $request->file($column)->store($folder) : null;
    }

    public function update_file(Request $request, Model $model, string $column, string $folder): ?string
    {
        if($request->hasFile($column)) {
            $this->delete_file($model, $column);
            $thumbnail = $request->file($column)->store($folder);
        } else {
            $thumbnail = $model->$column;
        }

        return $thumbnail;
    }

    public function delete_file(Model $model, string $column): Void
    {
        if($model->$column) {
            Storage::delete($model->$column);
        }
    }
}