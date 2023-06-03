@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            <th>نوع المركبة</th>
            <th>المركبات</th>
        </tr>
    </thead>
    <tbody>
        @php $num = 1; @endphp
        @foreach($types->chunk(100) as $types_chunk)
            @foreach($types_chunk as $type)
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    <td>{{ $type->name }}</td>
                    <td>{{ $type->units_count }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="1" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="2" style="background: @if($types->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="1" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="2" style="background: @if($types->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
