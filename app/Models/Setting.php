<?php
namespace App\Models;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Translatable;
    public $translatedAttributes = ['title','join_description','description', 'address', 'key_words'];
    protected $hidden = ['translations'];

    public function getLogoAttribute($logo)
    {
        return !is_null($logo)?url('uploads/settings/'.$logo):null;
    }

    public function getLogoWhiteAttribute($logo_white)
    {
        return !is_null($logo_white)?url('uploads/settings/'.$logo_white):null;
    }

     public function getVedioAttribute($vedio)
    {
    	if($vedio){
        	if (isset(explode("v=",$vedio)[1])){
            $x = explode("v=",$vedio)[1];
            return 'https://www.youtube.com/embed/'.$x ;
            }else{
            return $vedio;
            }
        }else{
            return ""; 
        }
    }


}
