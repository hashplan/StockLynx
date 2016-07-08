<style type="text/css">
    .bigdrop{
        width: 600px !important;
    }
    .stockMenuItem {
        white-space: normal;
    }
</style>
<script>
    $(function(){
        $('#stock_id').select2(
            {
                dropdownCssClass:'bigdrop',
                placeholder: 'Add stock',
                nullable: true
            }
        );
        $('#stock_id').on('change', function(){
            var select = this;
            $.get({
                url: '/admin/add_user_stock/'+$(select).val(),
                success: function () {
                    $(select).closest('.sidebar-menu').append('<li class="stockMenuItem">' +
                    '<a href="/admin/trees?stock_id='+$(select).val()+'">' +
                    '<i class="fa fa-money"></i>'+$(select).find("option:selected").text() +
                    '<i class="fa fa-angle-left pull-right"></i>'+
                    '</a>' +
                    '</li>');
                    $(select).find("option:selected").remove();
                    $(select).val(null);
                    $(select).trigger('change.select2');
                },
                dataType:'json'
            });

        });
    })
</script>
<section class="sidebar">
	@yield('sidebar.top')

	<ul class="sidebar-menu">
		@yield('sidebar.ul.top')
        <li><div style="margin: 10px">
        {!!
            AdminFormElement::select('stock_id', '', App\Model\Stocks::rest()->lists('securityName', 'id')->all())
        !!}
            </div>
        </li>
        @foreach (Auth::user()->stocks()->get() as $stock)
            <li class="stockMenuItem {{(\Request::get('stock_id') == $stock->id)?'treeview active':''}}">
                <a href="/admin/trees?stock_id={{$stock->id}}">
                    <i class="fa fa-money"></i>
                    {{$stock->securityName}}
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                @if(\Request::get('stock_id') == $stock->id)
                <ul class="treeview-menu">
                    <li><a href="/admin/remove_user_stock/{{$stock->id}}"><i class="pull-right fa fa-trash"></i>remove</a></li>
                </ul>
                @endif
            </li>
        @endforeach
		{!! app('sleeping_owl.navigation')->render() !!}
		@yield('sidebar.ul.bottom')
	</ul>

	@yield('sidebar.bottom')
</section>