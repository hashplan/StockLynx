<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Baum\Node;
use Auth;
use DB;

class RosettaTree extends Node
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'comment',
        'status'
    ];

    public function scopeLevel($query, $id)
    {
        $query->where('id', $id);
    }

    public function scopeOwn($query)
    {
        $query->where('user_id', Auth::user()->id);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            if(!Auth::guest()) {
                $model->user_id = Auth::user()->id;
//                $model->depth = ++RosettaTree::level($model->parent_id)->lists('depth')[0];
            }
        });

        static::updating(function($model)
        {
            if(!Auth::guest()) {
                $model->user_id = Auth::user()->id;
//                $model->depth = ++RosettaTree::level($model->parent_id)->lists('depth')[0];
            }
        });
    }

    public function trees()
    {
        return $this->hasMany(ValuationTree::class, 'tree_id');//$this->belongsTo(Stocks::class);
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
