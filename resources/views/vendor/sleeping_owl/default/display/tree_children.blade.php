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
                    <a href="/admin/valuation/create?stock_id={{$entry->stock_id}}&node_id={{$entry->id}}" class="btn btn-default btn-xs"><span class="fa fa-money"></span> Add valuation</a>
                    <a href="/admin/trees/create?stock_id={{$entry->stock_id}}&node_id={{$entry->id}}" class="btn btn-default btn-xs"><span class="fa fa-plus"></span> Add Child</a>
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
            <ul class="list-group valuation_items">
            @foreach(App\Model\ValuationTree::byNode($entry->id)->get() as $valuation)
                    <li class="list-group-item">
                        {{$valuation->scenario_name}}
                        <div class="pull-right">
                            <a href="/admin/valuation/{{$valuation->id}}/edit?stock_id={{$entry->stock_id}}&node_id={{$entry->id}}" class="btn btn-default btn-xs"><span class="fa fa-pencil"></span></a>
                            <form action="/admin/valuation/{{$valuation->id}}/delete?stock_id={{$entry->stock_id}}" method="POST" style="display:inline-block;">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-danger btn-xs btn-delete" data-toggle="tooltip" title="" data-original-title="Delete">
                                    <i class="fa fa-times"></i>
                                </button>
                            </form>
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