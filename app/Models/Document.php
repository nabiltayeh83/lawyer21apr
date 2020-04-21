<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{

    use SoftDeletes;
    protected $table = 'documents';
    protected $fillable = ['parent_id','office_id','title','project_id','responsible_lawyer','document_date','file'];

    public function project() {
        return $this->BelongsTo('App\Models\Project', 'project_id')->withTrashed();
    }

    public function employee(){
        return $this->BelongsTo('App\User', 'responsible_lawyer')->withTrashed();
    }

    public function files(){
        return $this->hasMany('App\Models\Document', 'parent_id', 'id')->orderBy('document_date', 'asc');
    }

    public function getFileAttribute($value){
        if(!is_null($value)){
            return url("uploads/websitefiles/attachments/" . $value);    
        }
    }

}

