@foreach ($children as $entry)
    <li class="dd-item dd3-item {{ $reorderable ? '' : 'dd3-not-reorderable' }}" data-id="{{{ $entry->id }}}">
        @if ($reorderable)
            <div class="dd-handle dd3-handle"></div>
        @endif
        <div class="dd3-content">

            {{{ $entry->$value }}}

            <div class="pull-right">
                @if(is_a($entry, 'App\Model\RosettaTree'))
                <a class="btn btn-default btn-xs"><span class="fa fa-search-plus"></span></a>
                @endif

                @foreach ($controls as $control)

                    @if($control instanceof \SleepingOwl\Admin\Contracts\ColumnInterface)
                        <?php $control->setModel($entry); ?>
                    @endif
                    {!! $control->render() !!}
                @endforeach
            </div>
        </div>
        @if ($entry->children->count() > 0)
            <ol class="dd-list">
                @include(AdminTemplate::getViewPath('display.tree_children'), ['children' => $entry->children])
            </ol>
        @endif
    </li>
@endforeach