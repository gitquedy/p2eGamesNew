<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Utilities extends Model
{
    public static function format_date($date, $format = 'm-d-Y'){
        return date_format(date_create($date), $format);
    }

    public static function getFeatherIcons(){
        return [
            'Edit' => 'edit-2',
            'Delete' => 'trash',
            'Approve' => 'check',
            // 'Web' => 'user',
            // 'Android' => 'te',
            // 'IOS' => 'te',
            // 'Windows' => 'te',
            // 'Linux' => 'te',
            // 'Playstation' => 'te',
            // 'XBOX' => 'te',
            // 'Nintendo' => 'te',
        ];
    }

    public static function getBtnClasses(){
        return [
            'Live' => 'primary',
            'Presale' => 'success',
            'Alpha' => 'secondary',
            'Beta' => 'warning',
            'Development' => 'info',
            'Cancelled' => 'dark',
            'Free-To-Play' => 'success',
            'NFT Required' => 'danger',
            'Crypto Required' => 'danger',
            'Game Required' => 'danger',
        ];
    }

    public function actionDropdown($actions){
        $html = '<div class="dropdown">
                  <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                    <i data-feather="more-vertical"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">';
        $icons = static::getFeatherIcons();
        foreach($actions as $action){
            $html .=' <a class="dropdown-item modal_button" href="#" data-action="'. $action['route'] . '">
                          <i data-feather="'. $icons[$action['name']] .'" class="me-50"></i>
                          <span>'. $action['name'] .'</span>
                       </a>';
        }
        $html .= '</div></div>';
        return $html;
    }

    public static function viewButtonHref($action){
        return'<a target="_blank" href="'. $action .'" data-toggle="tooltip" data-placement="top" title="View"" class="btn btn-primary btn-sm margin-r-10"><i class="fa fa-eye"></i>';
    }

    public static function viewButton($action){
        return'<a href="#" data-toggle="tooltip" data-placement="top" title="View"" data-href="'. $action . '" class="btn btn-primary btn-sm margin-r-10 modal_button"><i class="fa fa-eye"></i>';
    }

    public static function editButton($action){
        return'<a href="#" data-toggle="tooltip" data-placement="top" title="Edit"" data-href="'. $action . '" class="btn btn-primary btn-sm margin-r-10 modal_button"><i class="fa fa-edit"></i>';
    }

    public static function deleteButton($action){
        return '<a href="#" data-toggle="tooltip" data-placement="top" title="Delete" data-href="'. $action . '" class="btn btn-danger btn-sm modal_button"><i class="fa fa-trash"></i>';
    }

    public static function nameLink($action, $name){
        return '<a target="_blank" href="'. $action .'"> '. $name .' <a/>';
    }
}
