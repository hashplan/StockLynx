<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

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
        'percentage',
        'metric',
        'metric_value',
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

    public function scopeOwn($query)
    {
        $query->where('user_id', Auth::user()->id);
    }

    public function scopeByNode($query, $nodeId)
    {
        $query->where('tree_id', $nodeId);
    }

    public static function countNodePercentage($nodeId)
    {
        $res = 0.0;

        $val = self::byNode($nodeId)->get();

        foreach($val as $v) {
            $res += $v->percentage;
        }

        return 100.0-$res;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            if(!Auth::guest()) {
                $model->user_id = Auth::user()->id;
                $model->level = RosettaTree::level($model->tree_id)->lists('depth')[0];
                $model->ev = self::calculateEV($model);//$model->metric * $model->modifier;
	            $model->mkt_cap =  self::calculateMktCap($model);//$model->metric * $model->modifier;
//	            $model->diluted_shares = ;
	            $model->discount_days = floor(strtotime($model->valuation_date) - time())/(60*60*24);
	            $model->value_per_share_raw = self::calculateValuePerShareRaw($model);
	            $model->value_per_share_current = $model->value_per_share_raw / ((1+$model->discount_rate) ** ($model->discount_days/365));
            }
        });

        static::updating(function($model)
        {
            if(!Auth::guest()) {
                $model->user_id = Auth::user()->id;
                $model->level = RosettaTree::level($model->tree_id)->lists('depth')[0];

                $model->ev = self::calculateEV($model);//$model->metric * $model->modifier;
                $model->mkt_cap =  self::calculateMktCap($model);//$model->metric * $model->modifier;
//	            $model->diluted_shares = ;
                $model->discount_days = floor(strtotime($model->valuation_date) - time())/(60*60*24);
                $model->value_per_share_raw = self::calculateValuePerShareRaw($model);
                $model->value_per_share_current = $model->value_per_share_raw / ((1+$model->discount_rate) ** ($model->discount_days/365));
                //dd([$model->ev, $model->mkt_cap, $model->value_per_share_raw]);
            }
        });
    }

    public function trees()
    {
        return $this->hasMany(RosettaTree::class, 'id');//$this->belongsTo(Stocks::class);
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

    public static function getTransactValues($v){

        //return strtoupper(str_replace(' ', '_', $v));
        //'Net Income','EPS','EBITDA','Revenue','Levered FCF','Levered FCF per Share','Unlevered FCF','Dividend per Share'
        //'NET INCOME','EPS','EBITDA','REVENUE','LEVERED FCF','LEVERED FCF PER SHARE','UNLEVERED FCF','DIVIDEND PER SHARE'
        $result = 0;

        switch(strtoupper(str_replace(' ', '_', $v))){
            case 'NET_INCOME':
                $result = 0;
                break;
            case 'EPS':
                $result = 'pe';
                break;
            case 'EBITDA':
                $result = 'evebitda';
                break;
            case 'REVENUE':
                $result = 0;
                break;
            case 'LEVERED_FCF':
                $result = 'fcfy';
                break;
            case 'LEVERED_FCF_PER_SHARE':
                $result = 0;
                break;
            case 'UNLEVERED_FCF':
                $result = 0;
                break;
            case 'DIVIDEND_PER_SHARE':
                $result = 0;
                break;
        }

        return $result;
    }

    private static function calculateEV($model){

        switch($model->metric){
            case 'NULL':
                $result = 0;
                break;
            case 'Net Income':
                $result = $model->metric_value * $model->modifier + $model->debt - $model->cash;
                break;
            case 'EPS':
                $result = $model->metric_value * $model->modifier * $model->diluted_shares + $model->debt - $model->cash;
                break;
            case 'EBITDA':
                $result = $model->metric_value * $model->modifier;
                break;
            case 'Revenue':
                $result = $model->metric_value * $model->modifier;
                break;
            case 'Levered FCF':
                $result = $model->metric_value / $model->modifier + $model->debt - $model->cash;
                break;
            case 'Levered FCF per Share':
                $result = $model->metric_value / $model->modifier * $model->diluted_shares + $model->debt - $model->cash;
                break;
            case 'Unlevered FCF':
                $result = $model->metric_value / $model->modifier;
                break;
            case 'Dividend per Share':
                $result = $model->metric_value / $model->modifier * $model->diluted_shares + $model->debt - $model->cash;
                break;
        }

        return $result;
    }

    private static function calculateMktCap($model){

        switch($model->metric){
            case 'NULL':
                $result = 0;
                break;
            case 'Net Income':
                $result = $model->metric_value * $model->modifier;
                break;
            case 'EPS':
                $result = $model->metric_value * $model->modifier * $model->diluted_shares;
                break;
            case 'EBITDA':
                $result = $model->metric_value * $model->modifier - $model->debt + $model->cash;
                break;
            case 'Revenue':
                $result = $model->metric_value * $model->modifier - $model->debt + $model->cash;
                break;
            case 'Levered FCF':
                $result = $model->metric_value / ($model->modifier / 100);
                break;
            case 'Levered FCF per Share':
                $result = $model->metric_value / $model->modifier * $model->diluted_shares;
                break;
            case 'Unlevered FCF':
                $result = $model->metric_value / $model->modifier - $model->debt + $model->cash;
                break;
            case 'Dividend per Share':
                $result = $model->metric_value / $model->modifier * $model->diluted_shares;
                break;
        }

        return $result;
    }

    private static function calculateValuePerShareRaw($model){

        switch($model->metric){
            case 'NULL':
                $result = 0;
                break;
            case 'Net Income':
                $result = $model->metric_value * $model->modifier / $model->diluted_shares;
                break;
            case 'EPS':
                $result = $model->metric_value * $model->modifier;
                break;
            case 'EBITDA':
                $result = ($model->metric_value * $model->modifier - $model->debt + $model->cash) / $model->diluted_shares;
                break;
            case 'Revenue':
                $result = ($model->metric_value * $model->modifier - $model->debt + $model->cash) / $model->diluted_shares;
                break;
            case 'Levered FCF':
                $result = ($model->metric_value / $model->modifier) / $model->diluted_shares * 100;
                break;
            case 'Levered FCF per Share':
                $result = $model->metric_value / $model->modifier;
                break;
            case 'Unlevered FCF':
                $result = ($model->metric_value / $model->modifier - $model->debt + $model->cash) / $model->diluted_shares;
                break;
            case 'Dividend per Share':
                $result = $model->metric_value / $model->modifier;
                break;
        }

        return $result;
    }
}
