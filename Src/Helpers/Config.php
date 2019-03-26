<?php
declare(strict_types = 1);

namespace App\Helpers;


use App\Exception\NotFoundException;

class Config
{

    public static function get(string $filename, string $key = null)
    {
        $fileContent = self::getFileContent($filename);
        if($key === null){
            return $fileContent;
        }
        return isset($fileContent[$key]) ? $fileContent[$key] : [];
    }

    public static function getFileContent(string $filename): array
    {
        $fileContent = [];
        try{
            $path = realpath(sprintf(__DIR__ . '/../Configs/%s.php', $filename));
           if(file_exists($path)) {
               $fileContent = require $path;
           }
        }catch (\Throwable $exception){
            throw new NotFoundException(
              sprintf('The specified file: %s was not found', $filename), [
                  'not found file', 'data is passed']
            );
        }
        return $fileContent;
    }

}