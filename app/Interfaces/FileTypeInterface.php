<?php


namespace App\Interfaces;


use App\StandardsClasses\FileResult;

/**
 * Interface FileTypeInterface
 * @package App\Interfaces
 */
interface FileTypeInterface
{
    /**
     * @return FileResult
     */
    public function analyze(): FileResult;

    /**
     * @return array
     */
    public function fileToArray(): array;

}
