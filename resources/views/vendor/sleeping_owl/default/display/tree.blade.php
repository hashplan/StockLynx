<script type="text/javascript">
    $(function () {
        $('.nestable').nestable({
            maxDepth: 20
        }).on('change', function (e) {
            var url = $(this).data('url');
            var list = e.length ? e : $(e.target);
            var data = list.nestable('serialize');
            $.post(url, {data: data});
        });
    })
</script>
<ul class="nav nav-tabs">
    <li role="tree_view"><a href="/admin/tree?stock_id={{\Request::get('stock_id')}}">View</a></li>
    <li role="tree_edit" class="active"><a href="/admin/trees?stock_id={{\Request::get('stock_id')}}">Edit</a></li>
    <li role="tree_chart"><a href="/admin/chart?stock_id={{\Request::get('stock_id')}}">Charts</a></li>
</ul>
<div class="panel panel-default">
    <div class="panel-heading">
        @if ($creatable)
            <a class="btn btn-primary" href="{{ $createUrl }}">
                <i class="fa fa-plus"></i> {{ trans('sleeping_owl::lang.table.new-entry') }}
            </a>
        @endif
    </div>
    <div class="panel-body">
        <div class="dd nestable" data-url="{{ $url }}/reorder">
            <ol class="dd-list">
                @include(AdminTemplate::getViewPath('display.tree_children'), ['children' => $items])
            </ol>
        </div>
    </div>
</div>

