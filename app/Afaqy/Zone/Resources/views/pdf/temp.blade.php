@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            <th>المناطق</th>
            <th>الاتجاه</th>
            <th>الأجهزة</th>
            <th>الميزان</th>
        </tr>
    </thead>
    <tbody>
        @php $num = 1; @endphp
        @foreach($zones as $zone)
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    <td>{{ $zone->name }}</td>
                    <td>@php echo ($zone->direction == 'in') ? 'دخول' : 'خروج'; @endphp</td>
                    <td>{{ $zone->devices_names }}</td>
                    <td>{{ $zone->scale_name }}</td>
                </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="3" style="background: @if($zones->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="3" style="background: @if($zones->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
