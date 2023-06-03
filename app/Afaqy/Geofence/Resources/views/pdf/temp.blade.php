@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            <th>الموقع الجغرافى</th>
            <th>النوع</th>
            <th>ID</th>
        </tr>
    </thead>
    <tbody>
        @php $num = 1; @endphp
        @foreach($geofences->chunk(100) as $geofences_chunk)
            @foreach($geofences_chunk as $geofence)
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    <td>{{ $geofence->name }}</td>
                    <td>@php echo ($geofence->type == 'zone') ? 'منطقة' : 'حفرة'; @endphp</td>
                    <td>{{ $geofence->geofence_id }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="1" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="3" style="background: @if($geofences->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="1" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="3" style="background: @if($geofences->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
