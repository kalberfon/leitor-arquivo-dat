<?php

namespace App\Interfaces;

/**
 * Interface HandleDatInterface
 */
interface HandleDatInterface
{
    /**
     * @return void
     */
    public function processIn(): void;

    /**
     * @return array
     */
    public function getFiles(): array;

    /**
     * @param $file
     * @param FileTypeInterface $fileAdapter
     */
    public function createDoneFile($file, FileTypeInterface $fileAdapter): void;

    /**
     * @param $fileName
     * @return bool
     */
    public function getContentDoneFile($fileName): bool;


    /**
     * @param $fileName
     * @return array
     */
    public function analizeSpecificFile($fileName): array;

    /**
     * @param $fileName
     * @return array
     */
    public function outputSpecificFile($fileName): array;
}
