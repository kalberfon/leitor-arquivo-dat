<?php


namespace App\Adapters;


use App\Interfaces\FileTypeInterface;
use App\StandardsClasses\FileResult;

/**
 * Class FileAdapter
 * @package App\Adapters
 */
class FileAdapter implements FileTypeInterface
{
    /**
     * @return FileResult
     */
    public function analyze(): FileResult
  {
      return new FileResult();
  }
}
