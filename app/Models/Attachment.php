<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{

    use SoftDeletes;
    protected $table = "attachments";
    protected $fillable = ["attachment_name", "attachtype_id", "file", "reference_number", "attachmentable_id", "attachmentable_type"];
    protected $appends  = ["file"];

    public function attachtype(){
        return $this->BelongsTo('App\Models\Attachtype')->withTrashed();
    }

    public function getFileAttribute($value){
        if(!is_null($value)){
            return url("uploads/websitefiles/attachments/" . $value);
        }
    }

}
