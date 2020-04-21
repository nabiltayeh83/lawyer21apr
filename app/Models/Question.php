<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    

    protected  $table='questions';
    protected $fillable = [
        'question_number',
        'text',
        'answer',
        'section_id',
        'page_number',
        'logo',
        'status',
        'sort',
    ];

    
    protected $appends=['first_photo','in_favorite'];

    public function scopePublic($query, $isActive = '1', $orderBy = 'asc')
    {
        return $query->orderBy('sort', $orderBy)->orderBy('section_id', $orderBy);
    }


    public function scopeLast($query, $isActive = '1', $orderBy = 'desc')
    {
        return $query->orderBy('sort', $orderBy)->orderBy('section_id', $orderBy);
    }


    public function section()
    {
        return $this->belongsTo(Section::class,'section_id')->withTrashed();
    }


    public function getLogoAttribute($value)
    {
        if ($value && (request()->method() === 'GET')) {
            return \Storage::disk('public')->url($value);
        }
        return $value;
    }


    public function questions_img()
    {
        return $this->morphMany(Attatchment::class, 'attatchmentable')->where('type','1');
    }
    
    public function answer_img()
    {
        return $this->morphMany(Attatchment::class, 'attatchmentable')->where('type','2');
    }


    public function getFirstPhotoAttribute()
    {
       $first_photo=Attatchment::where('attatchmentable_id',$this->id)
           ->where('attatchmentable_type','App\Models\Question')
           ->where('type',1)->first();

       if($first_photo)
       {
           return $first_photo->image;
       }
       else
       {
           return null;
       }



    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'question_id');
    }

    public function views()
    {
        return $this->hasMany(History::class, 'question_id');
    }

    public function getInFavoriteAttribute()
    {
        $user = userExists(session()->get('uuid'));

        if($user)
        {
            $fav=Favorite::where('user_id',$user->id)
                ->where('question_id',$this->id)
                ->where('status',1)
                ->first();
            if($fav)
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }
        else
        {
            return null;
        }

    }



}
