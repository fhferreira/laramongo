<?php namespace Traits;

interface ToTreeInterface
{
    /**
     * Should contain a STATIC protected attribute
     * containing the options of the tree
     */
    /*
    static protected $treeOptions = array(
        'nodeView' => 'tree_node',
        'nodeName' => 'category'
    );
    */

    /**
     * Should return an array of parent objects
     */
    public function parents();

    /**
     * Will render the tree based 
     */
    public static function renderTree();

    /**
     * isRoot should return true for the root nodes.
     * This method will be used to detect whenever a iten
     * is a root or not. 
     *
     * example: 
     * public function isRoot(){
     *     return count($this->parents()) == 0;
     * }
     *
     */
    public function isRoot();
}