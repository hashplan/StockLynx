<!-- Authentication Links -->
@if (Auth::user()->isSuperAdmin() || Auth::user()->isManager())

@elseif(Auth::user())
    {{--<div class="row" style="margin:7px; margin-left: -10px;">--}}
        {{--<div class="col-md-12">--}}
            {{--<!--Warning buttons with dropdown menu-->--}}
            {{--<div class="btn-group">--}}
                {{--<button type="button" data-toggle="dropdown" class="btn btn-warning dropdown-toggle">Action with&nbsp;&nbsp;&nbsp;<span class="caret"></span></button>--}}
                {{--<ul class="dropdown-menu">--}}
                    {{--<li class="dropdown-header">Tree</li>--}}
                    {{--<li><a href="/admin/trees">Tree</a></li>--}}
                    {{--<li><a href="/admin/branch">Create NEW Branch</a></li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li class="dropdown-header">Scenario</li>--}}
                    {{--<li class="disabled"><a href="/admin/valuation">Scenario | Node</a></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
@endif
