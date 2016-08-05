@if (is_numeric($value))
    {!! number_format($value, 2, '.', ',') !!} {!! $append !!}
@else
    {!! $value !!} {!! $append !!}
@endif
