<?php

namespace App\Nrna\Services;

class ImageService
{
    /**
     * @param $request
     * @param $field
     * @return mixed
     */
    public  function uploadImage($request, $field)
    {
        $data = $request->except($field);

        if ($request->file($field)) {
            $file = $request->file($field);
            $request->file($field);
            $fileName  = $this->rename_file($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $path      = '/uploads/' . str_plural($field);
            $move_path = public_path() . $path;
            $file->move($move_path, $fileName);
            $data[$field] = $path . $fileName;
        }

        return $data;
    }

    /**
     * @param $filename
     * @param $mime
     * @return mixed|string
     */
    public function rename_file($filename, $mime)
    {
        // remove extension first
        $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
        $filename = str_slug($filename, "-");
        $filename = '/' . $filename . '_' . str_random(32) . '.' . $mime;

        return $filename;
    }
}
