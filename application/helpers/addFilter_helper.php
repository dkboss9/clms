<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of add_filter_helper
 *
 * @author Ajay Shrestha Home
 */
if(! function_exists('addFilter')) {
    
    function addFilter($filter,$sortFilter=false,$sortby='') {
        //put your code here
        $url = '';
        
        
        //Additional filter options
        //Sort Filter for sorting url on tables
        if($sortFilter){
            $filter['sortby'] = $sortby;
            isset($filter['sort'])&&$filter['sort']=='asc'?$filter['sort']='desc':$filter['sort']='asc';
        }
        
        
        //this is where string creation takes place
        if(isset($filter)&&count($filter)>0){
            $url = '?';
            $i = 1;
            foreach ($filter as $key => $value) {
                if($i==1){
                    $url .= $key.'='.$value;
                } else{
                    $url .= '&'.$key.'='.$value;
                }
                $i = $i + 1;
            }
            return $url;
        }
        return $url;
    }
}
?>
