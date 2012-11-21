<?php
/**
 * Created by JetBrains PhpStorm.
 * User: km
 * Date: 29.10.12
 * Time: 14:11
 * To change this template use File | Settings | File Templates.
 */


class TreeBuilder
{
    /**
     * @var array
     */
    private $_list;
    private $_tree;

    public $total = 0;


    public function __construct($list){

        $this->_list = array();

        foreach ($list as $item){
            
            $child = new stdClass;
            $child->id          = $item->id;
            $child->state       = $item->state;
            $child->parent_id   = $item->parent_id;
            $child->title       = $item->title;
            $child->slug        = $item->slug;
            $child->created_at  = $item->created_at;
            $child->children_count = 0;

            $this->total+=$child->state;

            $this->_list[] = $child;
        }
    }

    /**
     * Построить деррево относительно заданного корня
     *
     * @param int $root
     * @return array
     */
    public function build($root){
        $this->_tree = $this->_getChildren($root);
        return $this->_tree;
    }

    /**
     * Получить всех потомков родителя
     *
     * @param int $parent
     * @return array
     */
    private function _getChildren($parent){

        $children = array();

        foreach ($this->_list as $item){

            if ($item->parent_id == $parent){

                $child = $item;
                $child->children = $this->_getChildren($item->id);

                for ($i=0; $i<count($child->children);$i++){
                    $child->children_count += $child->children[$i]->state;
                }

                $children[] = $child;
            }
        }
        return $children;
    }


}