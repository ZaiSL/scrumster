<?php

/**
 * Работа с постраничной навигацией
 *
 * @version    1.0
 * @package    Core\Libraries
 * @subpackage Pager
 * @category   Libraries
 * @author     Joostina Team <info@joostina.ru>
 * @copyright  (C) 2007-2012 Joostina Team
 * @license    MIT License http://www.opensource.org/licenses/mit-license.php
 * Информация об авторах и лицензиях стороннего кода в составе Joostina CMS: docs/copyrights
 *
 * @todo    переписать joosPager на joosRoute и привести к общему виду
 *
 * @author     Leng Sheng Hong <darkredz@gmail.com>
 * @link       http://www.doophp.com/
 * @copyright  Copyright &copy; 2009 Leng Sheng Hong
 * @license    http://www.doophp.com/license
 *
 * */
class Pagination
{
    /**
     * Contain the list of components to be used in view. (pages, jump menu, page_size, current_page, total_page)
     *
     * @var array
     */
    public $components;
    /**
     * Items to be displayed per page
     *
     * @var int
     */
    public $item_per_page = 10;
    /**
     * The current page number
     *
     * @var int
     */
    public $current_page = 1;
    /**
     * Maximum Pager length
     *
     * @var int
     */
    public $max_length = 10;
    /**
     * Total items to be split in the pagination
     *
     * @var int
     */
    public $total_item;
    /**
     * Total pages in the pagination
     *
     * @var int
     */
    public $total_page;
    /**
     * The pages HTML output
     *
     * @var string
     */
    public $output;
    /**
     * The URL prefix for all the pagination links
     *
     * @var string
     */
    public $base_url;
    //----- for SQL use -----
    /**
     * Position of the record to begin the pagination LIMIT query
     *
     * @var string
     */
    public $low;
    /**
     * Position of the record to end the pagination LIMIT query
     *
     * @var string
     */
    public $high;
    /**
     * To be use with the pagination LIMIT query LIMIT $limit
     *
     * @var string
     */
    public $limit;
    public $offset;
    /**
     * @var string
     */
    private $_output;

    public function __construct($base_url = '', $total_items = 120, $item_per_page = 10, $max_length = 11, $extra_url = '')
    {
        $this->base_url = $base_url;
        $this->base_url = $extra_url ? $this->base_url . $extra_url : $this->base_url;
        $this->total_item = $total_items;
        $this->max_length = $max_length;
        $this->item_per_page = $item_per_page;
    }

    public function paginate($page, $item_per_page = 0)
    {
        if ($item_per_page === 0) {
            $item_per_page = $this->item_per_page;
        } else {
            $this->item_per_page = $item_per_page;
        }

        $this->total_page = ceil($this->total_item / $item_per_page);

        $this->current_page = (int) $page;

        if ($this->current_page < 1 || !is_numeric($this->current_page)) {
            $this->current_page = 1;
        }

        if ($this->current_page > $this->total_page) {
            $this->current_page = $this->total_page;
        }

        $prev_page = $this->current_page - 1;
        $next_page = $this->current_page + 1;

        $this->_output .= '';

        //-----------------------------------------------------------------------------------------------"НАЗАД"
	    $_prev = ($this->current_page != 1) ? "<a class=\"page_left\" href=\"{$this->base_url}{$prev_page}/\">&larr; предыдущая</a>" : '<span>&larr; предыдущая</span>';
        $this->components['prev'] = $_prev;

        //Вывод джампером (с разрывом, если кол-во страниц > допустимого интервала)
        if ( true || $this->total_page > $this->max_length) {
            $midRange = $this->max_length - 2;

            $start_range = $this->current_page - floor($midRange / 2);
            $end_range = $this->current_page + floor($midRange / 2);

            if ($start_range <= 0) {
                $end_range += abs($start_range) + 1;
                $start_range = 1;
            }

            if ($end_range > $this->total_page) {
                $start_range -= $end_range - $this->total_page;
                $end_range = $this->total_page;
            }

            while ($end_range - $start_range + 1 < $this->max_length - 1) {
                $end_range++;
            }

            $modulus = (int) $this->max_length % 2 == 0;
            $center = floor($this->max_length / 2);

            if ($this->current_page > $center) {
                $end_range--;
            }

            if ($modulus == 0 && $this->total_page - $this->current_page + 1 <= $center) {
                while ($end_range - $start_range + 1 < $this->max_length - 1) {
                    $start_range--;
                }
            }
            $range = range($start_range, $end_range);

            for ($i = 1; $i <= $this->total_page; $i++) {
                if ($i == 1 || $i == $this->total_page || in_array($i, $range)) {
                    $lastDot = '';

                    if ($modulus == 1) {
                        if ($i == $this->total_page && $this->current_page < ($this->total_page - ($this->max_length - $center - $modulus))) {
                            $lastDot = '...';
                        }
                    } else {
                        if ($i == $this->total_page && $this->current_page <= ($this->total_page - ($this->max_length - $center))) {
                            $lastDot = '...';
                        }
                    }

                    //-----------------------------------------------------------------------------НОМЕРА СТРАНИЦ
                    $_number = "<a href=\"{$this->base_url}$i/\">$lastDot $i";

                    if ($range[0] > 2 && $i == 1) {
                        $_number .= " ...</a>";
                    } else {
                        $_number .= '</a>';
                    }

	                $_number = ($i == $this->current_page) ? '<span>'.$i.'</span>' : $_number;
                    $this->_output .= '<li>' . $_number . '</li>';
                }
            }

            //-----------------------------------------------------------------------------"ВПЕРЕД"
	        $_next = ($this->current_page != $this->total_page && $this->total_item >= $this->max_length) ?  "<a class=\"page_right\"  href=\"{$this->base_url}$next_page/\">следущая &rarr;</a>" : '<span>следующая</span>';
            $this->components['next'] =  $_next;

        } else {
            //-----------------------------------------------------------------------------НОМЕРА СТРАНИЦ
            for ($i = 1; $i <= $this->total_page; $i++) {
	            //-----------------------------------------------------------------------------НОМЕРА СТРАНИЦ
	            $lastDot = '';
	            $_number = "<a href=\"{$this->base_url}$i/\">$lastDot $i";
	            $_number = ($i == $this->current_page) ? '<span>'.$i.'</span>' : $_number;
	            $this->_output .= '<li>' . $_number . '</li>';
            }

            //-----------------------------------------------------------------------------"ВПЕРЕД"
            $_next = "<a class=\"page_right\"  href=\"{$this->base_url}$next_page/\">&rarr;</a>";

	        $_next = ($this->current_page != $this->total_page && $this->total_item >= $this->max_length) ?  "<a class=\"page_right\"  href=\"{$this->base_url}$next_page/\">следущая &rarr;</a>" : '<span>следующая</span>';
	        $this->components['next'] =  $_next;


        }

        $this->low = ($this->current_page - 1) * $this->item_per_page;
        $this->high = ($this->current_page * $this->item_per_page) - 1;
        $this->low = $this->low < 0 ? 0 : $this->low;
        $this->limit = $this->item_per_page;
        $this->offset = $this->low;

        $this->components['current_page'] = $this->current_page;
        $this->components['total_page'] = $this->total_page;

        $this->output = '<div class="pagination">Страницы: '. $this->components['prev'] .' '. $this->components['next'] .'<ul class="pagination-links">' . $this->_output . '</ul></div>';

        $this->output = $this->total_item > 0 && $this->total_page > 1 ? $this->output : '';

        $this->components['pages'] = $this->output;

        return $this->components;
    }

}
