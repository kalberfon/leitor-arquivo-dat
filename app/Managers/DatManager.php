<?php


namespace App\Managers;

use App\Adapters\FileDatAdapter;
use App\Interfaces\FileTypeInterface;
use App\Interfaces\HandleDatInterface;
use Illuminate\Support\Facades\Storage;

class DatManager implements HandleDatInterface
{
    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function processIn(): void
    {
        foreach (Storage::disk("dat")->allFiles("in") as $file) {
            if (preg_match("/([a-zA-Z0-9\s_\\.\-\(\):])+(.dat)$/", $file)) {
                $this->analizeSpecificFile($file);
            }
        }
    }

    /**
     * @return array
     */
    public function getFiles(): array
    {
        $it = [];
        foreach (Storage::disk("dat")->allFiles("out") as $file) {
            if (preg_match("/([a-zA-Z0-9\s_\\.\-\(\):])+(.dat)$/", $file)) {
                $it[] = $file;
                $this->analizeSpecificFile($file);
            }
        }
        return $it;
    }

    /**
     * @param $file
     * @param FileTypeInterface $fileAdapter
     */
    public function createDoneFile($file, FileTypeInterface $fileAdapter): void
    {
        preg_match("/(?<=in\/)(.*)(?=.dat)/", $file, $mat);
        $fileName = $mat[0];
        Storage::disk("dat")->put("out/{$fileName}.done.dat", json_encode($fileAdapter->fileToArray()));
    }

    /**
     * @param $fileName
     * @return bool
     */
    public function getContentDoneFile($fileName): bool
    {
        return Storage::disk("dat")->get($fileName);
    }

    /**
     * @param $fileName
     * @return array
     */
    public function analizeSpecificFile($fileName): array
    {
        $rows = Storage::disk("dat")->get($fileName);
        $results = (new FileDatAdapter($rows));
        $results->analyze();
        $this->createDoneFile($fileName, $results);

        return $results->fileToArray();
    }

    /**
     * @param $fileName
     * @return array
     */
    public function outputSpecificFile($fileName): array
    {
        $retArr = [];
        preg_match("/(?<=in\/)(.*)(?=.dat)/", $fileName, $mat);
        $fileName = $mat[0];
        if (Storage::disk("dat")->exists("out/{$fileName}.done.dat")) {
            $auxArr = Storage::disk("dat")->get("out/{$fileName}.done.dat");
            $retArr = json_decode($auxArr, true);
        }
        return $retArr;
    }
}
