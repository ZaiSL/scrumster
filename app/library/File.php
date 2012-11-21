<?php


class File
{

    /**
     * Формирование вложенного пути к файлу с учетом разделения по каталогам
     *
     * @tutorial File::make_file_location( 1 );
     * @tutorial File::make_file_location( 123 );
     * @tutorial File::make_file_location( 123456789123456789 );
     *
     * @param integer $id - номер файла в БД
     *
     * @return string - путь к файлу в структуре подкаталогов
     *
     *
     */
    public static function make_file_location($id, $split_by = 3, $capacity = 9, $round = false)
    {

        // округляем
        $id = $round ? (int) round($id / $round) : $id;

        if (!is_integer($id)) {
            throw new FileLibrariesException('Параметр $id должен иметь цельночисленное значение');
        }

        if (!is_integer($split_by)) {
            throw new FileLibrariesException('Параметр $split_by должен иметь цельночисленное значение');
        }

        if (!is_integer($capacity)) {
            throw new FileLibrariesException('Параметр $capacity должен иметь цельночисленное значение');
        }

        $p = sprintf('%0' . $capacity . 'd', $id);
        $h = str_split($p, $split_by);
        return implode('/', $h);
    }

    /**
     * Получение MIME типа файла
     *
     * @tutorial  joosFile::get_mime_content_type( __FILE__ );
     * @tutorial  joosFile::get_mime_content_type( JPATH_BASE . DS . 'media' . DS . 'favicon.ico' );
     * @tutorial  joosFile::get_mime_content_type( JPATH_BASE . DS . 'media' . DS . 'js' . DS . 'jquery.js');
     *
     * @param string $file_name
     *
     * @return string
     */
    public static function get_mime_content_type($file_name) {

        if(function_exists('finfo_open')){
            $options=defined('FILEINFO_MIME_TYPE') ? FILEINFO_MIME_TYPE : FILEINFO_MIME;
            $info= finfo_open($options);

            if($info && ($result=finfo_file($info,$file_name))!==false){
                return $result;
            }
        }

        if(function_exists('mime_content_type') && ($result=mime_content_type($file_name))!==false){
            return $result;
        }

        return self::get_mime_content_type_by_extension($file_name);

    }

    /*
     * Получение расширения по имени файла
     * */
    public static function get_ext($file_name){
        $file_info = pathinfo($file_name);
        $ext = isset($file_info['extension']) ? $file_info['extension'] : false;
        return $ext;
    }


    /**
     * Проверка существования файла
     *
     * @tutorial joosFile::exists( JPATH_BASE . DS. 'index.php' );
     *
     * @param string $file_name
     *
     * @return bool результат проверки
     */
    public static function exists($file_name) {
        return (bool) ( file_exists($file_name) && is_file($file_name) );
    }

    /**
     * Проверка прав доступа на запись в файл
     *
     * @param string $file_location полный путь к каталогу
     *
     * @return bool результат проверки доступа на запись в указанный каталог
     */
    public static function is_writable($file_location) {
        return (bool) is_writable($file_location);
    }

    /**
     * Проверка прав доступа на чтение файла
     *
     * @param string $file_location полный путь к каталогу
     *
     * @return bool результат проверки доступа на запись в указанный каталог
     */
    public static function is_readable($file_location) {
        return (bool) is_readable($file_location);
    }

    /**
     * Получение MIME типа файла по расширению
     *
     * @tutorial  File::get_mime_content_type_by_extension( __FILE__ );
     * @tutorial  File::get_mime_content_type_by_extension( JPATH_BASE . DS . 'media' . DS . 'favicon.ico' );
     * @tutorial  File::get_mime_content_type_by_extension( JPATH_BASE . DS . 'media' . DS . 'js' . DS . 'jquery.js');
     *
     * @param string $file_name
     *
     * @return string
     */
    public static function get_mime_content_type_by_extension($file_name) {
        $mime_types = array(// all
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',
            'sql' => 'text/x-sql',
            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
            'tga' => 'image/x-targa',
            'psd' => 'image/vnd.adobe.photoshop',
            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',
            'gz' => 'application/x-gzip',
            'tgz' => 'application/x-gzip',
            'bz' => 'application/x-bzip2',
            'bz2' => 'application/x-bzip2',
            'tbz' => 'application/x-bzip2',
            'tar' => 'application/x-tar',
            '7z' => 'application/x-7z-compressed',
            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            'avi' => 'video/x-msvideo',
            'dv' => 'video/x-dv',
            'mp4' => 'video/mp4',
            'mpeg' => 'video/mpeg',
            'mpg' => 'video/mpeg',
            'wm' => 'video/x-ms-wmv',
            'mkv' => 'video/x-matroska',
            // adobe
            'pdf' => 'application/pdf',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',
            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet'
        );

        $ext = self::get_ext($file_name);
        if ( isset($mime_types[$ext])) {
            return $mime_types[$ext];
        } else {
            return 'application/octet-stream';
        }
    }
}



/**
 * Обработчик ошибок для библиотеки File
 */
class FileLibrariesException extends Exception {

}
