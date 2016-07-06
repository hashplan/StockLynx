<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Baum\Node;
use DB;

class RosettaTree extends Node
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'comment',
        'status'
    ];

//    protected $hidden = [
//        'updated_at'
//    ];

    public function trees()
    {
        return $this->hasMany(ValuationTree::class, 'tree_id');//$this->belongsTo(Stocks::class);
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

    public static function getPossibleEnumValues($name){
        $instance = new static; // create an instance of the model to be able to get the table name
        $type = DB::select( DB::raw('SHOW COLUMNS FROM '.$instance->getTable().' WHERE Field = "'.$name.'"') )[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach(explode(',', $matches[1]) as $value){
            $v = trim( $value, "'" );
            $enum[$v] = $v;
        }
        return $enum;
    }
}
