{{ HTML::style('packages/treant-js/Treant.css') }}
<style type="text/css">
    .chart { height: 700px; margin: 5px; width: 100%; }
    .Treant > .node { padding: 3px; border: 1px solid #484848; border-radius: 3px; }
    .Treant > .node img { width: 100%; height: 100%; }
    .Treant .collapse-switch { width: 100%; height: 100%; border: none; }
    .Treant .node.collapsed { background-color: #DEF82D; }
    .Treant .node.collapsed .collapse-switch { background: none; }
</style>
<!-- Info boxes -->
{{--<div class="col-xs-12"><hr></div>--}}
<!-- /.row -->
<!-- Main row -->
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
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        {{--<div class="pad">--}}
                            <div class="chart" id="collapsable"></div>

                            <!-- Buttons will be created here -->

                        {{--</div>--}}
                    </div>
                    <!-- /.col -->

                    <!-- /.col -->
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
{{ HTML::script('packages/treant-js/vendor/raphael.js') }}
{{ HTML::script('packages/treant-js/vendor/jquery.easing.js') }}
{{ HTML::script('packages/treant-js/Treant.js') }}
{{ HTML::script('packages/treant-js/collapsable.js') }}
<script>
    $(function() {
        tree = new Treant( chart_config );
    });
</script>