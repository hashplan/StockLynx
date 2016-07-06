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
        return $this->hasMany(RosettaTree::class, 'id', 'id');
    }

//    public function scopeWithContact($query, $stockId)
//    {
//        $query->whereHas('contacts', function ($q) use ($stockId) {
//            $q->where('contact_id', $stockId);
//        });
//    }

    public function setCapitalizationIdAttribute($capitalizationId)
    {
        $this->save();
        $tree = TreeCapitalization::find($capitalizationId);
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
