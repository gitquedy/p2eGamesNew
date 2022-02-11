<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = ['user_id', 'game_id', 'subject', 'description', 'rating', 'screenshots',  'status'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function game() {
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }

    public function screenshotUrl($screenshot){
        return asset('images/game/screenshots/'. $screenshot);
    }

    public function useful(){
        return $this->hasMany(Useful::class, 'review_id');
    }

    public function getDropdown(){
        $html = '<div class="d-flex align-items-center col-actions">';

        $html .= '<a href="#" class="me-1 show_modal" data-action="'. route('review.show', $this) .'" data-bs-toggle="tooltip" data-bs-placement="top" title="View"><i data-feather="eye"></i></a>';
        if($this->status == 0){
            $html .= '<a href="#" class="me-1 confirmation" data-title="Are you sure to approve review #'. $this->id .'" data-action="'. route('review.approve', $this) .'" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve"><i data-feather="check"></i></a>';
        }
        $html .=' <a class="me-1 modal_button" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-action="'. route('review.delete', $this) . '"><i data-feather="trash" class="me-50"></i></a>';
        $html .= '</div>';
        return $html;
    }
}
