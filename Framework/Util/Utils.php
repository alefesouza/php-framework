<?php

namespace Framework\Util;

class Utils
{
    const LOCATION = '';

    public static function rootFolder()
    {
        return dirname(dirname(dirname(dirname(__FILE__))));
    }

    public static function pathCombine()
    {
        $paths = func_get_args();

        return join(DIRECTORY_SEPARATOR, $paths);
    }

    public static function saveFile($folder, $file, $full_path = false, $base64 = true)
    {
        $size = $file->size;

        if ($size === 0) {
            return '';
        }

        $temp_path = self::pathCombine(self::rootFolder(), 'files', $folder);

        if (!file_exists($temp_path)) {
            mkdir($temp_path, 0777, true);
        }

        $final_path = self::filterFile($temp_path, $file->name);

        $upload_file = basename($final_path);

        if ($base64) {
            self::makeFileBase64($file->data, $temp_path, $upload_file);
        } else {
            file_put_contents($final_path, $file->data);
        }

        if ($full_path) {
            return $final_path;
        }

        return $upload_file;
    }

    public static function removeFile($folder, $file)
    {
        $final_path = self::pathCombine(self::rootFolder(), 'files', $folder, $file);

        if (file_exists($final_path)) {
            unlink($final_path);
        }
    }

    public static function filterFile($path, $file_name)
    {
        $final_path = self::pathCombine($path, $file_name);

        if (!file_exists($final_path)) {
            return $final_path;
        }
    
        $date = date('d_m_Y__H_i_s');

        $extension = pathinfo($file_name)['extension'];

        $file_name = str_replace('.'.$extension, '', $file_name);

        $file_name .= '_'.$date.'.'.$extension;

        $final_path = self::pathCombine($path, $file_name);

        return $final_path;
    }

    private static function makeFileBase64($base64, $path, $file_name)
    {
        $base64 = preg_replace('#^data:(.*?)/[^;]+;base64,#', '', $base64);

        if (!file_exists($path)) {
            mkdir($path);
        }

        $final_path = self::pathCombine($path, $file_name);

        $data = base64_decode($base64);

        file_put_contents($final_path, $data);
    }
}
