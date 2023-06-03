@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            <th>رقم اللوحة</th>
            <th>رمز المركبة</th>
            <th>المقاول</th>
            <th>رقم العقد</th>
            <th>رقم التصريح</th>
            <th>نوع التصريح</th>
            <th>نوع المركبة</th>
            <th>نوع النفاية</th>
            <th>الوزن الصافي</th>
            <th>أقصي وزن</th>
            <th>وزن الدخول</th>
            <th>وزن الخروج</th>
            <th>وزن النفاية</th>
            <th>وقت الدخول</th>
            <th>وقت الخروج</th>
            <th>مدة الرحلة</th>
        </tr>
    </thead>
    <tbody>
        @php
            $num    = 1;
            $lookup = \Afaqy\Permission\Lookups\PermissionTypeLookup::toArray();
        @endphp

        @foreach($units->chunk(100) as $units_chunk)
            @foreach($units_chunk as $unit)
                @php
                    $start = \Carbon\Carbon::fromTimestamp($unit->start_time)->toDateTimeString();
                    $end   = \Carbon\Carbon::fromTimestamp($unit->end_time)->toDateTimeString();
                @endphp
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    <td>{{ $unit->plate_number }}</td>
                    <td>@if($unit->unit_code) {{ $unit->unit_code }} @else N/A @endif</td>
                    <td>@if($unit->contractor_name) {{ $unit->contractor_name }} @else N/A @endif</td>
                    <td> @if($unit->contract_number) عقد {{ $unit->contract_number }} @else N/A @endif</td>
                    <td>@if($unit->permission_id) {{ $unit->permission_id }} @else N/A @endif</td>
                    <td>@if($unit->permission_type) {{ $lookup[$unit->permission_type]  }} @else N/A @endif</td>
                    <td>@if($unit->unit_type) {{ $unit->unit_type }} @else N/A @endif</td>
                    <td>{{ $unit->waste_type }}</td>
                    <td>@if($unit->net_weight) {{ $unit->net_weight / 1000 }} @else N/A @endif</td>
                    <td>@if($unit->max_weight) {{ $unit->max_weight / 1000 }} @else N/A @endif</td>
                    <td>{{ $unit->enterance_weight / 1000 }}</td>
                    <td>{{ $unit->exit_weight / 1000 }}</td>
                    <td>{{ $unit->waste_weight / 1000 }}</td>
                    <td>{{ $start }}</td>
                    <td>{{ $end }}</td>
                    <td>{{ \Carbon\Carbon::parse($start)->diff($end)->format('%H:%I:%S') }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="14" style="background: @if($units->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="3" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="14" style="background: @if($units->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
