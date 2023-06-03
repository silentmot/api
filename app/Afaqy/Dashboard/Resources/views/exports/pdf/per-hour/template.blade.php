@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            <th>الساعة</th>
            <th>التاريخ</th>
            <th>عدد المركبات</th>
            <th>وزن النفايات بالطن</th>
        </tr>
    </thead>
    <tbody>
        @php $num    = 1; @endphp

        @foreach($perHour->chunk(100) as $perHour_chunk)
            @foreach($perHour_chunk as $per_hour)
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    <td>{{ $per_hour->hour }} :00</td>
                    <td>{{ $per_hour->date }}</td>
                    <td>{{ $per_hour->units_count }}</td>
                    <td>{{ $per_hour->total_weight / 1000 }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="3" style="background: @if($perHour->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="3" style="background: @if($perHour->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
