{{--{{ HTML::style('treant-js/Treant.css') }}--}}
<style type="text/css">
    .bullet { font: 10px sans-serif; }
    .bullet .marker { stroke: #000; stroke-width: 2px; }
    .bullet .tick line { stroke: #666; stroke-width: .5px; }
    .bullet .range.s0 { fill: #eee; }
    .bullet .range.s1 { fill: #ddd; }
    .bullet .range.s2 { fill: #ccc; }
    .bullet .measure.s0 { fill: lightsteelblue; }
    .bullet .measure.s1 { fill: steelblue; }
    .bullet .title { font-size: 14px; font-weight: bold; }
    .bullet .subtitle { fill: #999; }
    .bulletBox {}
</style>
<!-- Info boxes -->
{{--<div class="col-xs-12"><hr></div>--}}
<!-- /.row -->
<!-- Main row -->
<ul class="nav nav-tabs">
    <li role="tree_view"><a href="/admin/tree?stock_id={{\Request::get('stock_id')}}">View</a></li>
    <li role="tree_edit"><a href="/admin/trees?stock_id={{\Request::get('stock_id')}}">Edit</a></li>
    <li role="tree_chart" class="active"><a href="/admin/chart?stock_id={{\Request::get('stock_id')}}">Charts</a></li>
</ul>
<div class="row">
    <!-- Left col -->
    <div class="col-md-12">
        <!-- MAP & BOX PANE -->
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Valuation Charts</h3>

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
                            {{--@foreach (App\Model\RosettaTree::own()->stock()->get() as $rootNode)--}}
                                {{--@if(0 == $rootNode->getLevel())--}}
                                    {{--<li class="list-group-item"><span class="badge">{{  $rootNode->descendants()->count() }}</span><a href="/admin/tree?stock_id={{$rootNode->stock_id}}&node_id={{$rootNode->id}}">{{ $rootNode->name }}</a></li>--}}
                                {{--@endif--}}
                            {{--@endforeach--}}
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
{{ HTML::script('//d3js.org/d3.v3.min.js') }}
{{ HTML::script('charts/bullet.js') }}
<script>
    var margin = {top: 5, right: 40, bottom: 20, left: 120},
            width = 960 - margin.left - margin.right,
            height = 50 - margin.top - margin.bottom;

    var chart = d3.bullet()
            .width(width)
            .height(height);

    d3.json("/charts/bullets.json", function(error, data) {
        if (error) throw error;

        var svg = d3.select("#collapsable").selectAll("svg")
                .data(data)
                .enter().append("svg")
                .attr("class", "bullet")
                .attr("width", width + margin.left + margin.right)
                .attr("height", height + margin.top + margin.bottom)
                .append("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
                .call(chart);

        var title = svg.append("g")
                .style("text-anchor", "end")
                .attr("transform", "translate(-6," + height / 2 + ")");

        title.append("text")
                .attr("class", "title")
                .text(function(d) { return d.title; });

        title.append("text")
                .attr("class", "subtitle")
                .attr("dy", "1em")
                .text(function(d) { return d.subtitle; });

        d3.selectAll("button").on("click", function() {
            svg.datum(randomize).call(chart.duration(1000)); // TODO automatic transition
        });
    });

    function randomize(d) {
        if (!d.randomizer) d.randomizer = randomizer(d);
        d.ranges = d.ranges.map(d.randomizer);
        d.markers = d.markers.map(d.randomizer);
        d.measures = d.measures.map(d.randomizer);
        return d;
    }

    function randomizer(d) {
        var k = d3.max(d.ranges) * .2;
        return function(d) {
            return Math.max(0, d + k * (Math.random() - .5));
        };
    }
</script>