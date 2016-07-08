<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
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

    public function scopeRest($query)
    {
        $query->whereNotIn('id', function($query) {
            $query->from('user_stocks')
                ->select('stock_id')
                ->where('user_id', '=', Auth::user()->id);
        });
    }
}
