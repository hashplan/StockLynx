<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    protected $fillable = [
        'securityID',
        'ISIN',
        'CUSIP',
        'symbol',
        'exchange',
        'securityName',
        'securityType',
        'issuerID',
        'issuerName'
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function stocks()
    {
//        return $this->belongsToMany(Contact::class);
    }

//    public function scopeWithContact($query, $stockId)
//    {
//        $query->whereHas('contacts', function ($q) use ($stockId) {
//            $q->where('contact_id', $stockId);
//        });
//    }

    public function setStocksIdAttribute($stockId)
    {
        $this->save();
        $contact = Stocks::find($stockId);
//        $this->stocks()->attach($contact);
    }

    public function setCreatedAtAttribute($value)
    {
        // to Disable
    }
}
