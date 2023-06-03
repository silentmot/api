@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            <th>التاريخ</th>
            <th>المحطة الانتقالية</th>
            <th>رقم العقد</th>
            <th>وزن النفايات بالطن</th>
        </tr>
    </thead>
    <tbody>
        @php $num = 1; @endphp

        @foreach($stations->chunk(100) as $stations_chunk)
            @foreach($stations_chunk as $station)
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    <td>{{ $station->date }} :00</td>
                    <td>{{ $station->station_name }}</td>
                    <td>عقد {{ $station->contract_number }}</td>
                    <td>{{ $station->total_weight / 1000 }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="3" style="background: @if($stations->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="3" style="background: @if($stations->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
