<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RosettaTree extends Model
{
    protected $fillable = [
        'name',
        'comment',
        'status'
    ];

//    protected $hidden = [
//        'updated_at'
//    ];

    public function tree()
    {
//        return $this->belongsToMany(Contact::class);
    }

//    public function scopeWithContact($query, $stockId)
//    {
//        $query->whereHas('contacts', function ($q) use ($stockId) {
//            $q->where('contact_id', $stockId);
//        });
//    }

    public function setTreeIdAttribute($treeId)
    {
        $this->save();
        $tree = RosettaTree::find($treeId);
//        $this->stocks()->attach($contact);
    }

    public function setCreatedAtAttribute($value)
    {
        // to Disable
    }
}
