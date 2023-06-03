@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            <th>رمز المركبة</th>
            <th>موديل المركبة</th>
            <th>رقم اللوحة</th>
            <th>رقم الشاسيه</th>
            <th>نوع المركبة</th>
            <th>نوع النفايات</th>
            <th>إسم المقاول</th>
            <th>الوزن الصافي</th>
            <th>الحد الأقصي للوزن</th>
            <th>RFID</th>
            <th>حالة المركبة</th>
        </tr>
    </thead>
    <tbody>
        @php $num = 1; @endphp
        @foreach($units->chunk(100) as $units_chunk)
            @foreach($units_chunk as $unit)
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    <td>{{ $unit->code }}</td>
                    <td>{{ $unit->model }}</td>
                    <td>{{ $unit->plate_number }}</td>
                    <td>{{ $unit->vin_number }}</td>
                    <td>{{ $unit->unit_type }}</td>
                    <td>{{ $unit->waste_type }}</td>
                    <td>{{ $unit->contractor_name }}</td>
                    <td>{{ $unit->net_weight }}</td>
                    <td>{{ $unit->max_weight }}</td>
                    <td>{{ $unit->rfid }}</td>
                    <td>@if($unit->active) نشطة @else غير نشطة @endif</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="10" style="background: @if($units->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="10" style="background: @if($units->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
