<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of breadcrumb
 *
 * @author Ajay Shrestha Home
 */
if (!function_exists('createBreadcrumb')) {

    function createBreadcrumb($segment1, $segment2, $filter = 'none') {
        //selecting segment1 for module selection. and segment 2 for action.
        $moduleSelection = array('dashboard' => base_url() . 'dashboard',
            'configuration' => base_url() . 'index.php/configuration',
            'newsletter' => base_url().'index.php/newsletter',
			'news' => base_url().'index.php/news',
			'subscribers' => base_url().'index.php/subscribers',
			'article' => base_url().'index.php/article',
			'templates'=>base_url().'index.php/templates',
			'template_type'=>base_url().'index.php/template_type',
			'category'=>base_url().'index.php/category',
			'product_attributes'=>base_url().'index.php/product_attributes',
			'quote_color'=>base_url().'index.php/quote_color',
			'options'=>base_url().'index.php/options',
			'industry'=>base_url().'index.php/industry',
			'hear_from'=>base_url().'index.php/hear_from',
			'customer_role'=>base_url().'index.php/customer_role',
			'couriers'=>base_url().'index.php/couriers',
			'email_template'=>base_url().'index.php/email_template',
			'users'=>base_url().'index.php/users',
			'customers'=>base_url().'index.php/customers',
			'coupon'=>base_url().'index.php/coupon',
			'quote'=>base_url().'index.php/quote',
			'match_quote'=>base_url().'index.php/match_quote',
			'additional_option'=>base_url().'index.php/additional_option',
			'additional_option_item'=>base_url().'index.php/additional_option_item',
			'coupon'=>base_url().'index.php/coupon',
			'product'=>base_url().'index.php/product/listall',
			'faq'=>base_url().'index.php/faq',
			'faq_category'=>base_url().'index.php/faq_category',
			'generalsettings'=>base_url().'index.php/generalsettings',
			'order'=>base_url().'index.php/order',
			'report'=>base_url().'index.php/report',
			'rootcompany'=>base_url().'index.php/rootcompany'
        );
        $actionDisplayName = array('listall' => 'List',
            'gridall' => 'Grid',
            'add' => 'Add',
            'edit' => 'Edit',
            'detail' => 'Detail',
            'listclient' => 'Client List',
            'listemployee' => 'Employee List',
            'listpartners' => 'Partner List',
			'view'=>'View',
			'purchase_order'=>'Purchase Order',
			'add_purchase_order'=>'Add Purchase Order'
        );
        //This is for filter type for contact type
        $filterUrl = array();
        $moduleDisplayName = array(
			'newsletter'=> 'Newsletter',
			'news'=>'News',
			'subscribers'=>'Subscribers',
			'article'=>'Static Page',
			'templates'=>'Templates',
			'template_type'=>'Template Type',
			'category'=>'Product Category',
			'product_attributes'=>'Product Attributes',
			'quote_color'=>'Quote Color',
			'options'=>'Product Options',
			'industry'=>'Industry',
			'hear_from'=>'Hear From',
			'customer_role'=>'Role',
			'couriers'=>'Couriers',
			'email_template'=>'Email Template',
			'users'=>'Users',
			'customers'=>'Customers',
			'coupon'=>'Coupons',
			'quote'=>'Quote',
			'match_quote'=>'Match Quote',
			'additional_option'=>'Additional Option',
			'additional_option_item'=>'Additional Option Item',
			'coupon'=>'Coupon',
			'product'=>'Products',
			'faq'=>'FAQ',
			'faq_category'=>'FAQ Category',
			'generalsettings'=>'General Settings',
			'order'=>'Order',
			'report'=>'Report',
			'rootcompany'=>'Root Company'
        );
        $moduleCategoryDisplayName = array(
            'configuration' => 'default',
            'student' => 'Student',
            'invoice' => 'Invoice',
            'designation' => 'Master Data',
            'employee' => 'Human Resource',
            'job' => 'Master Data',
            'organization' => 'Master Data',
            'project' => 'Project',
            'travelallowance' => 'Master Data',
            'users' => 'Users',
            'holidayspolicies' => 'Master Data'
        );
        $breadcrumb = '<ol class="breadcrumb">';
        if ($segment1 == 'dashboard') {
            echo '';
        } else {
            $breadcrumb .= '<li><a href="' . $moduleSelection['dashboard'] . '">Dashboard</a></li>';
            if (isset($moduleCategoryDisplayName[$segment1]) && $moduleCategoryDisplayName[$segment1] !== 'default') {
                $breadcrumb .= '<li class="active">' . $moduleCategoryDisplayName[$segment1] . '</li>';
            }
            $breadcrumb .= isset($moduleSelection[$segment1]) && isset($moduleDisplayName[$segment1]) ? '<li><a href="' . $moduleSelection[$segment1] . ($filter != 'none' && isset($filterUrl[strtolower($filter)]) ? ("/" . $filterUrl[strtolower($filter)]) : "") . '">' . $moduleDisplayName[$segment1] . '</a></li>' : "";
            $breadcrumb .= isset($moduleDisplayName[$segment1]) && isset($actionDisplayName[$segment2]) ? '<li class="active">' . $actionDisplayName[$segment2] . '</li>' : "";
        }
        $breadcrumb .= '</ol>';
        echo $breadcrumb;
    }

}
?>
