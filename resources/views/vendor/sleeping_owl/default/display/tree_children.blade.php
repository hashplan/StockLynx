<style type="text/css">
    .valuation_items {    margin-bottom: 0;
        margin-top: 0;
    }
</style>
@foreach ($children as $entry)

    <li class="dd-item dd3-item {{ $reorderable ? '' : 'dd3-not-reorderable' }}" data-id="{{{ $entry->id }}}">
        @if ($reorderable)
            <div class="dd-handle dd3-handle"></div>
        @endif
        <div class="dd3-content">

            {{{ $entry->$value }}}

            <div class="pull-right">
                @if(is_a($entry, 'App\Model\RosettaTree'))
                    {{--/admin/valuation/create?stock_id={{$entry->stock_id}}&node_id={{$entry->id}}--}}
                    @if(is_null(count(App\Model\ValuationTree::byNode($entry->id)->get())) || ('Levered FCF' == App\Model\ValuationTree::byNode($entry->id)->first()->toArray()['metric']))
                        <a href="/admin/scenario?stock_id={{$entry->stock_id}}&node_id={{$entry->id}}" class="btn btn-default btn-xs"><span class="fa fa-money"></span> Add valuation</a>
                    @endif
                    <a href="/admin/trees/create?stock_id={{$entry->stock_id}}&node_id={{$entry->id}}" class="btn btn-default btn-xs"><span class="fa fa-plus"></span> Add Child</a>
                    <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#node_{{$entry->id}}"><span class="fa fa-search-plus"></span> Details</a>
                @endif

                @foreach ($controls as $control)
                    @if($control instanceof \SleepingOwl\Admin\Contracts\ColumnInterface)
                        <?php $control->setModel($entry); ?>
                    @endif
                    {!! $control->render() !!}
                @endforeach
            </div>
        </div>
            @if(is_a($entry, 'App\Model\RosettaTree'))
                <div class="modal fade" id="node_{{$entry->id}}" tabindex="-1" role="dialog" aria-labelledby="node_{{$entry->id}}">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="label_{{$entry->id}}"> {{{ $entry->$value }}}</h4>
                            </div>
                            <div class="modal-body">
                                {!! $entry->comment !!}
                            </div>
                        </div>
                    </div>
                </div>
            <ul class="list-group valuation_items">
            @foreach(App\Model\ValuationTree::byNode($entry->id)->get() as $valuation)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-5 pull-left"><span class="fa fa-money"></span>&nbsp;&nbsp;&nbsp;{{$valuation->scenario_name}}</div>
                        <div class="col-md-1">{{$valuation->class}}</div>
                        <div class="col-md-1">{{$valuation->framework}}</div>
                        <div class="col-md-1">{{$valuation->valuation_method}}</div>
                        <div class="col-md-1">{{$valuation->metric}}</div>
                        <div class="col-md-1">{{$valuation->modifier}}</div>
                        <div class="col-md-2">
                            <div class="pull-right">
                            <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#valuation_{{$valuation->id}}"><span class="fa fa-search-plus"></span> Details</a>
                            <a href="/admin/valuation/{{$valuation->id}}/edit?stock_id={{$entry->stock_id}}&node_id={{$entry->id}}&valuation-type={{App\Model\ValuationTree::getTransactValues($valuation->metric)}}" class="btn btn-default btn-xs"><span class="fa fa-pencil"></span></a>
                            <form action="/admin/valuation/{{$valuation->id}}/delete?stock_id={{$entry->stock_id}}" method="POST" style="display:inline-block;">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-danger btn-xs btn-delete" data-toggle="tooltip" title="" data-original-title="Delete">
                                    <i class="fa fa-times"></i>
                                </button>
                            </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="valuation_{{$valuation->id}}" tabindex="-1" role="dialog" aria-labelledby="valuation_{{$valuation->id}}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="label_{{$valuation->id}}"> {{{ $valuation->scenario_name }}}</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4">Class:</div>
                                        <div class="col-md-8">{!! $valuation->class !!}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Framework:</div>
                                        <div class="col-md-8">{!! $valuation->framework !!}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Scenario Comment:</div>
                                        <div class="col-md-8">{!! $valuation->scenario_comment !!}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Valuation Method:</div>
                                        <div class="col-md-8">{!! $valuation->valuation_method !!}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Valuation Date:</div>
                                        <div class="col-md-8">{!! $valuation->valuation_date !!}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Metric:</div>
                                        <div class="col-md-8">{!! $valuation->metric_value !!}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Metric Comment:</div>
                                        <div class="col-md-8">{!! $valuation->metric_comment !!}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Modifier:</div>
                                        <div class="col-md-8">{!! $valuation->modifier !!}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Modifier Comment:</div>
                                        <div class="col-md-8">{!! $valuation->modifier_comment !!}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Cash:</div>
                                        <div class="col-md-8">{!! $valuation->cash !!}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Cash Comment:</div>
                                        <div class="col-md-8">{!! $valuation->cash_comment !!}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Debt:</div>
                                        <div class="col-md-8">{!! $valuation->debt !!}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Debt Comment:</div>
                                        <div class="col-md-8">{!! $valuation->debt_comment !!}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Discount Rate:</div>
                                        <div class="col-md-8">{!! $valuation->discount_rate !!}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Discount Rate Comment:</div>
                                        <div class="col-md-8">{!! $valuation->discount_rate_comment !!}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Discount Days:</div>
                                        <div class="col-md-8">{!! $valuation->discount_days !!}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Valuation Comment:</div>
                                        <div class="col-md-8">{!! $valuation->valuation_comment !!}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
            </ul>
            @endif
        @if ($entry->children->count() > 0)
            <ol class="dd-list">
                @include(AdminTemplate::getViewPath('display.tree_children'), ['children' => $entry->children])
            </ol>
        @endif
    </li>

@endforeach