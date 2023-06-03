@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            <th>التاريخ</th>
            <th>رقم اللوحة</th>
            <th>رمز المركبة</th>
            <th>نوع المخالفة</th>
            <th>المقاول</th>
            <th>رقم العقد</th>
            <th>رقم التصريح</th>
            <th>نوع التصريح</th>
            <th>وزن الدخول</th>
            <th>وزن الخروج</th>
            <th>وزن النفاية</th>
        </tr>
    </thead>
    <tbody>
        @php
            $num    = 1;
            $lookup = \Afaqy\Permission\Lookups\PermissionTypeLookup::toArray();
        @endphp

        @foreach($violations->chunk(100) as $violations_chunk)
            @foreach($violations_chunk as $violation)
                @php
                    $waste_weight = ($violation->permission_type == 'sorting')
                        ? $violation->exit_weight - $violation->enterance_weight
                        : $violation->enterance_weight - $violation->exit_weight;
                @endphp
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    <td>{{ \Carbon\Carbon::fromTimestamp($violation->date)->toDateTimeString() }}</td>
                    <td>{{ $violation->plate_number }}</td>
                    <td>{{ $violation->unit_code }}</td>
                    <td>{{ $violation->ar_violation_type }}</td>
                    <td>@if($violation->contractor_name) {{ $violation->contractor_name }} @else N/A @endif</td>
                    <td>@if($violation->contract_number) عقد {{ $violation->contract_number }} @else N/A @endif</td>
                    <td>@if($violation->permission_id) {{ $violation->permission_id }} @else N/A @endif</td>
                    <td>@if($violation->permission_type) {{ $lookup[$violation->permission_type] }} @else N/A @endif</td>
                    <td>@if($violation->enterance_weight) {{ $violation->enterance_weight / 1000  }} @else N/A @endif</td>
                    <td>@if($violation->exit_weight) {{ $violation->exit_weight / 1000  }} @else N/A @endif</td>
                    <td>{{ $waste_weight / 1000 }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="10" style="background: @if($violations->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="10" style="background: @if($violations->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
