{{--<script type="text/javascript">--}}
    {{--$(function () {--}}
        {{--$('#valuation_date').datetimepicker();--}}
    {{--});--}}
{{--</script>--}}
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
                <h3 class="box-title">Create NEW scenario</h3>

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
                        <div class="pad">
                            <!-- Buttons will be created here -->
                            <div class="card card-inverse card-warning text-sm-center col-sm-6 input-group col-xs-offset-3">
                                <div class="card-block">
                                    <blockquote class="card-blockquote">
                                        <p>[New Tree Name]  |  [Scenario / Node Name]</p>
                                        <footer>Name<cite title="Source Title"> Title</cite></footer>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 input-group col-xs-offset-3 form-group">
                        {{--<div id="input-date"></div>--}}
                        <em><strong>Valuation Date </strong> When will this valuation become realized?</em>
                        <div class="form-group">
                            <div class="input-group date" id="valuation_date">
                                <input type="text" class="form-control" placeholder="Enter Valuation Date here..." />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 input-group col-xs-offset-3 form-group">
                        <em><strong>Earnings Estimate </strong> What will be the earnings off of which this company is valued?</em>
                        <div class="col-sm-4 input-group form-group">
                            <span class="input-group-addon" id="eps-name">@</span>
                            <input type="text" class="form-control" placeholder="Enter EPS" aria-describedby="eps-name">
                        </div>
                        <div class="col-sm-8 input-group form-group">
                            <span class="input-group-addon" id="eps-description">@</span>
                            <input type="text" class="form-control" placeholder="Add commentary..." aria-describedby="eps-description">
                        </div>
                        <div class="form-group">
                            <div class="input-group date input-date" id="fiscal_year">
                                <input type="text" class="form-control" placeholder="Choose Fiscal Year here..." />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group date input-date" id="calendar_year">
                                <input type="text" class="form-control" placeholder="Choose Calendar Year here..." />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <select class="input-select" style="width: 100%;" placeholder="Change Valuation Methodology">
                            <option></option>
                            <optgroup label="Select Valuation Methodology">
                                <option value="1">Price to Earnings</option>
                                <option value="2">Free Cash Flow Yield</option>
                                <option value="3">EV to EBITDA</option>
                                <option value="4">Dividend Yield</option>
                                <option value="5">EV to Sales</option>
                                <option value="6">Sum of the Parts</option>
                                <option value="7">Other</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="col-sm-6 input-group col-xs-offset-3 form-group">
                        <em><strong>Valuation Multiple </strong> What multiple will the company be valued at in this scenario?</em>
                    </div>
                    <div class="col-sm-2 input-group form-group col-xs-offset-3">
                        <span class="input-group-addon" id="pe-multiple-name">@</span>
                        <input type="text" class="form-control" placeholder="Enter P/E Multiple" aria-describedby="pe-multiple-name">
                    </div>
                    <div class="col-sm-4 input-group form-group col-xs-offset-3">
                        <span class="input-group-addon" id="pe-multiple-description">@</span>
                        <input type="text" class="form-control" placeholder="Add commentary..." aria-describedby="pe-multiple-description">
                    </div>

                    <div class="col-sm-6 input-group col-xs-offset-3 form-group">
                        <em><strong>Net Debt </strong> What is the estimated cash and debt balance as of [Valuation Date]</em>
                    </div>
                    <div class="col-sm-2 text-right form-group col-xs-offset-3">
                        <button type="button" class="btn btn-primary btn-lg btn-block">Use Latest Balance Sheet</button>
                    </div>
                    <div class="col-sm-2 form-group">
                        <button type="button" class="btn btn-primary btn-lg btn-block">Cash</button>
                    </div>
                    <div class="col-sm-2 form-group">
                        <button type="button" class="btn btn-primary btn-lg btn-block">Debt</button>
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
