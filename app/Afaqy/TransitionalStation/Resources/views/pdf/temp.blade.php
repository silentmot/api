@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            <th>المحطة الانتقالية</th>
            <th>البلديات</th>
            <th>الحالة</th>
        </tr>
    </thead>
    <tbody>
        @php $num = 1; @endphp
        @foreach($stations->chunk(100) as $stations_chunk)
            @foreach($stations_chunk as $station)
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    <td>{{ $station->name }}</td>
                    <td>{{ $station->district_name }}</td>
                    <td>@php echo ($station->status) ? 'مفعل' : 'غير مفعل'; @endphp</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="1" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="3" style="background: @if($stations->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="1" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="3" style="background: @if($stations->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
