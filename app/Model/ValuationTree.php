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

    public function scopeOwn($query)
    {
        $query->where('user_id', Auth::user()->id);
    }

    public function scopeByNode($query, $nodeId)
    {
        $query->where('tree_id', $nodeId);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            if(!Auth::guest()) {
                $model->user_id = Auth::user()->id;
                $model->level = RosettaTree::level($model->tree_id)->lists('depth')[0];
//                $model->ev = ;
//	            $model->mkt_cap = ;
//	            $model->diluted_shares = ;
	            $model->discount_days = floor(strtotime($model->valuation_date) - time())/(60*60*24);
//	            $model->value_per_share_raw = ;
//	            $model->value_per_share_current = ;
            }
        });

        static::updating(function($model)
        {
            if(!Auth::guest()) {
                $model->user_id = Auth::user()->id;
                $model->level = RosettaTree::level($model->tree_id)->lists('depth')[0];
                $model->discount_days = floor(strtotime($model->valuation_date) - time())/(60*60*24);
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
}
