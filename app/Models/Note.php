<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;
    protected $table = 'notes';
    protected $fillable = ['note', 'note_date', 'noteable_id', 'noteable_type'];
}

