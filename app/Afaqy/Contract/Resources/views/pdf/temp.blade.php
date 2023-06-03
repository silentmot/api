@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            <th>رقم العقد</th>
            <th>تاريخ البدء</th>
            <th>تاريخ الانتهاء</th>
            <th>نوع العقد</th>
            <th>المنطقة</th>
            <th>الحي</th>
            <th>المقاول</th>
            <th>مسئول الاتصال</th>
            <th>صفة مسئول الاتصال</th>
            <th>البريد الإلكتروني لمسئول الاتصال</th>
            <th>هاتف مسئول الاتصال</th>
        </tr>
    </thead>
    <tbody>
        @php $num = 1; @endphp
        @foreach($contracts->chunk(100) as $contracts_chunk)
            @foreach($contracts_chunk as $contract)
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    <td>@php echo $contract->contract_number ? "عقد " . $contract->contract_number : 'N/A'; @endphp</td>
                    <td>{{ $contract->start_at }}</td>
                    <td>{{ $contract->end_at }}</td>
                    <td>@php echo $contract->status ? 'صالح' : 'ماغي'; @endphp</td>
                    <td>{{ $contract->district_name }}</td>
                    <td>{{ $contract->neighborhood_name }}</td>
                    <td>{{ $contract->contractor_name_ar }}</td>
                    <td>{{ $contract->contact_name }}</td>
                    <td>{{ $contract->contact_title }}</td>
                    <td>{{ $contract->contact_email }}</td>
                    <td>{{ $contract->contact_phone }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="9" style="background: @if($contracts->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="3" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="9" style="background: @if($contracts->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
