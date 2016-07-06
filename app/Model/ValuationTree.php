<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ValuationTree extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'tree_id',
        'scenario_id',
        'identifier',
        'class',
        'framework',
        'level',
        'scenario_name',
        'scenario_comment',
        'valuation_method',
        'valuation_date',
        'metric',
        'metric_comment',
        'modifier',
        'modifier_comment',
        'cash',
        'cash_comment',
        'debt',
        'debt_comment',
        'ev',
        'mkt_cap',
        'diluted_shares',
        'discount_rate',
        'discount_rate_comment',
        'discount_days',
        'value_per_share_raw',
        'value_per_share_current',
        'valuation_comment'
    ];

    public function valuations()
    {
//        return $this->belongsToMany(Contact::class);
    }

//    public function scopeWithContact($query, $stockId)
//    {
//        $query->whereHas('contacts', function ($q) use ($stockId) {
//            $q->where('contact_id', $stockId);
//        });
//    }

    public function setValuationIdAttribute($valuationId)
    {
        $this->save();
        $tree = ValuationTree::find($valuationId);
//        $this->stocks()->attach($contact);
    }

    public function setCreatedAtAttribute($value)
    {
        // to Disable
    }
}
