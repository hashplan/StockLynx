<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class TreeCapitalization extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'type_capitalization',
        'shares',
        'debt_value',
        'cash_value',
        'exercise_price'
    ];

    public function capitalization()
    {
//        return $this->belongsToMany(Contact::class);
    }

    public function trees()
    {
        return $this->hasOne(RosettaTree::class, 'id', 'id');
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
            }
        });

        static::updating(function($model)
        {
            if(!Auth::guest()) {
                $model->user_id = Auth::user()->id;
            }
        });
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
