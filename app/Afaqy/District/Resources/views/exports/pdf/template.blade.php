@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            <th>البلديات</th>
            <th>الاحياء</th>
            <th>الكثافة السكانية</th>
            <th>الاحياء الفرعية</th>
        </tr>
    </thead>
    <tbody>
        @php $num = 1; @endphp
        @foreach($districts->chunk(100) as $districts_chunk)
            @foreach($districts_chunk as $district)
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    <td>{{ $district->districtName }}</td>
                    <td>{{ $district->neighborhoodName }}</td>
                    <td>{{ $district->neighborhoodPopulation }}</td>
                    <td>{{ $district->subNeighborhoodName }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="3" style="background: @if($districts->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="3" style="background: @if($districts->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
