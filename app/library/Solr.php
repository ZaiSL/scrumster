<?php
/**
 * User: km
 * Date: 01.10.12
 * Time: 14:51
 */


define('SOLR_TEXT_LIMIT', 400);
define('SOLR_BASE_URL', 'http://localhost:8984/solr/');
define('SOLR_SEARCH_URL', SOLR_BASE_URL.'select');

class Solr {

    public static function getQueryString($params){
        $queryString = http_build_query($params);
        return preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '=', $queryString);
    }

    public static function escape($query){
        $pattern = '/(\+|-|&&|\|\||!|\(|\)|\{|}|\[|]|\^|"|~|\*|\?|:|\\\)/';
        $replace = '\\\$1';

        return preg_replace($pattern, $replace, $query);
    }


    public static function search($searchword, $offset=0, $limit=10){
        
        $searchword = str_replace('"',' ',$searchword);

        $params = array(
            'q' => self::escape($searchword),
            'start' => $offset,
            'rows' => $limit,
            'wt' => 'json',
            'fl' => 'id,entityId,type,source,text,ordering,title,author_name,for_name,created_at,comments_count,important_count,hits_count',
            'hl' => 'true',
            'hl.fl' => 'text,title',
            'hl.snippets' => 1,
            'hl.fragsize' => SOLR_TEXT_LIMIT,
            'f.text.hl.alternateField' => 'text',
            'f.title.hl.alternateField' => 'title',
            'hl.maxAlternateFieldLength' => SOLR_TEXT_LIMIT
        );

        $queryString = self::getQueryString($params);

        $url = SOLR_SEARCH_URL.'?'.$queryString;

        $curl = CURL::init($url)
            ->setHeader(false)
            ->setReturnTransfer(true)
            ->setFollowLocation(false);

        if ($json = $curl->execute()){
            return json_decode($json);
        }

        return false;
    }


}