@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            <th>إسم الجهاز</th>
            <th>النوع</th>
            <th>IP</th>
            <th>إسم البوابة</th>
        </tr>
    </thead>
    <tbody>
        @php $num = 1; @endphp
        @foreach($devices as $device)
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    <td>{{ $device->name }}</td>
                    <td>{{ Str::upper($device->type) }}</td>
                    <td>{{ $device->ip }}</td>
                    <td>{{ $device->door_name }}</td>
                </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="3" style="background: @if($devices->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="3" style="background: @if($devices->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
