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
                            <div class="card card-inverse card-warning text-sm-center col-sm-6 input-group col-xs-offset-3 form-group">
                                <div class="card-block">
                                    <blockquote class="card-blockquote">
                                        <p>[NEW scenario]</p>
                                        <footer>Name<cite title="Source Title"> Title</cite></footer>
                                    </blockquote>
                                </div>
                            </div>
                            <form method="get" action="/admin/valuation/create">
                                <input type="hidden" name="stock_id" value="{{\Request::get('stock_id')}}"/>
                                <input type="hidden" name="node_id" value="{{\Request::get('node_id')}}"/>

                                <div class="col-sm-6 input-group col-xs-offset-3 form-group">
                                    <span class="input-group-addon" id="node-name">@</span>
                                    <input type="text" class="form-control" placeholder="Enter name for node / scenario (e.g., Upside Case)" aria-describedby="node-name" name="node-name" required="required">
                                </div>
                                <div class="col-sm-6 input-group col-xs-offset-3 form-group">
                                    <span class="input-group-addon" id="scenario-description">@</span>
                                    <input type="text" class="form-control" placeholder="Add brief description / commentary of scenario..." aria-describedby="scenario-description" name="scenario-description" required="required">
                                </div>

                                <div class="col-sm-3 text-right col-xs-offset-3 form-group">
                                    <button type="submit" name="valuation-type" class="btn btn-primary btn-lg btn-block" value="pe">
                                        Price to Earnings
                                    </button>
                                </div>
                                <div class="col-sm-3 form-group">
                                    <button type="submit" name="valuation-type" class="btn btn-primary btn-lg btn-block" value="fcfy">
                                        Free Cash Flow Yield
                                    </button>
                                </div>

                                <div class="col-sm-3 text-right col-xs-offset-3 form-group">
                                    <button type="submit" name="valuation-type" class="btn btn-primary btn-lg btn-block" value="evebitda">
                                        EV to EBITDA
                                    </button>
                                </div>
                                <div class="col-sm-3 form-group">
                                    <button type="submit" name="valuation-type" class="btn btn-primary btn-lg btn-block" value="dy">
                                        Dividend Yield
                                    </button>
                                </div>

                                <div class="col-sm-3 text-right col-xs-offset-3 form-group">
                                    <button type="submit" name="valuation-type" class="btn btn-primary btn-lg btn-block" value="evsales">
                                        EV to Sales
                                    </button>
                                </div>
                                <div class="col-sm-3 form-group">
                                    <button type="submit" name="valuation-type" class="btn btn-primary btn-lg btn-block" value="sumparts">
                                        Sum of the Parts
                                    </button>
                                </div>

                                <div class="col-sm-6 text-center col-xs-offset-3 form-group">
                                    <button type="submit" name="valuation-type" class="btn btn-primary btn-lg btn-block" value="other">
                                        Other
                                    </button>
                                </div>
                            </form>
                        </div>
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
