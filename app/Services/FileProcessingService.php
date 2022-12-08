<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileProcessingService
{
    /**
     * Proccessing image (save to dir + return image path for DB).
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
    public function imageStoring($file)
    {
        if (isset($file)) {
            $newImageName = $file->hashName();
            $firstSaveDir = strtolower(substr($newImageName, 0, 2));
            $secondSaveDir = strtolower(substr($newImageName, 2, 2));
            $fileSaveDir = $firstSaveDir . '/' . $secondSaveDir;
            $file->storeAs('shopItems/' . $fileSaveDir, $newImageName);

            return $fileSaveDir . '/' . $newImageName;
        } else {
            return 'noimage.jpg';
        }
    }

    /**
     * Deleting image from directory.
     *
     * @param string $filePath
     *
     * @return void
     */
    public function deleteFromDir($filePath)
    {
        if ($filePath != '') {
            Storage::delete('shopItems/' . $filePath);
        }
    }

    /**
     * Deleting empty directory.
     *
     * @param string $filePath
     *
     * @return void
     */
    public function deleteEmptyDir($filePath)
    {
        $path = explode('/', $filePath);
        $firstDir = $path[0];
        $secondDir = $path[1];
        if (isset($firstDir) && isset($secondDir)) {
            @rmdir('shopItems/' . $firstDir . '/' . $secondDir);
            @rmdir('shopItems/' . $firstDir);
        }
    }
}
