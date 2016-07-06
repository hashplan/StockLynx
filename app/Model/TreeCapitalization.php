<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TreeCapitalization extends Model
{
    protected $fillable = [
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
}
