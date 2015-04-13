<?php

namespace App\Core;

class FileProcessor 
{
    /**
     * Delete a file or recursively delete a directory
     *
     * @param string $str Path to file or directory
     */
    public static function recursiveDelete($str){
        if(is_file($str)){
            return @unlink($str);
        }
        elseif(is_dir($str)){
            $scan = glob(rtrim($str,'/').'/*');
            foreach($scan as $index=>$path) {
                self::recursiveDelete($path);
            }
            return @rmdir($str);
        }
    }
    
    public static function clearDir($str){
        $scan = glob(rtrim($str,'/').'/*');
        foreach($scan as $index=>$path) {
            self::recursiveDelete($path);
        }
    }
}