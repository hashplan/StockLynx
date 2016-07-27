{{ HTML::style('treant-js/Treant.css') }}
<style type="text/css">
    .chart { height: 700px; margin: 5px; width: 100%; }
    .Treant > .node { background-color: #f4e8c3; padding-left: 7px; padding-right: 7px; border: 1px solid #484848; border-radius: 3px; text-align: left; vertical-align: middle; }
    .Treant > .node img { width: 100%; height: 100%; }
    .Treant .collapse-switch { width: 100%; height: 100%; border: none; }
    .Treant .node.collapsed { background-color: #eac785; box-shadow: 1px 1px 1px rgba(0,0,0,.5); }
    .Treant .node:hover { text-shadow: 1px 1px rgba(0,0,0,.25); }
    .Treant .node.collapsed .collapse-switch { background: none; }
    /*.root-nodes { background-color: #eac785; }*/
</style>
<!-- Info boxes -->
{{--<div class="col-xs-12"><hr></div>--}}
<!-- /.row -->
<!-- Main row -->
<ul class="nav nav-tabs">
    <li role="tree_view" class="active"><a href="/admin/tree?stock_id={{\Request::get('stock_id')}}">View</a></li>
    <li role="tree_edit"><a href="/admin/trees?stock_id={{\Request::get('stock_id')}}">Edit</a></li>
</ul>
<div class="row">
    <!-- Left col -->
    <div class="col-md-12">
        <!-- MAP & BOX PANE -->
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Valuation tree</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-1 col-sm-1 root-nodes">
                            <ul class="list-group">
                            @foreach (App\Model\RosettaTree::own()->stock()->get() as $rootNode)
                                @if(0 == $rootNode->getLevel())
                                    <li class="list-group-item"><span class="badge">{{  $rootNode->descendants()->count() }}</span><a href="/admin/tree?stock_id={{$rootNode->stock_id}}&node_id={{$rootNode->id}}">{{ $rootNode->name }}</a></li>
                                @endif
                            @endforeach
                            </ul>
                        </div>
                        <div class="col-md-11 col-sm-11">
                            {{--<div class="pad">--}}
                                <div class="chart Treant Treant-loaded" id="collapsable"></div>

                                <!-- Buttons will be created here -->

                            {{--</div>--}}
                        </div>
                        <!-- /.col -->

                        <!-- /.col -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <!-- /.col -->

</div>
<!-- /.row -->

<!-- /.info-box -->
</div>
{{--{{ $chart_config }}--}}
{{ HTML::script('treant-js/vendor/raphael.js') }}
{{ HTML::script('treant-js/vendor/jquery.easing.js') }}
{{ HTML::script('treant-js/Treant.js') }}
{{--{{ HTML::script('treant-js/collapsable.js') }}--}}
{{--{{ HTML::script('treant-js/no-parent.js') }}--}}
{{--{!! dd($chart_config) !!}--}}
<script>
    $(function() {
        {!! $chart_config !!}
        tree = new Treant( chart_config );
    });
</script>