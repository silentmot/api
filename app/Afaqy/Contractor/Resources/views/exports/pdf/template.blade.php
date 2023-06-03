@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            <th>أسم المقاول</th>
            <th>المركبات</th>
            <th>العمالة</th>
            <th>المسئول</th>
            <th>الهاتف</th>
            <th>البريد الالكترونى</th>
        </tr>
    </thead>
    <tbody>
        @php $num = 1; @endphp
        @foreach($contractors->chunk(100) as $contractors_chunk)
            @foreach($contractors_chunk as $contractor)
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    <td>{{ $contractor->name_ar }} <br> {{ $contractor->name_en }}</td>
                    <td>{{ $contractor->units_count }}</td>
                    <td>{{ $contractor->employees }}</td>
                    <td>{{ $contractor->name }}</td>
                    <td>{{ $contractor->phone }}</td>
                    <td>{{ $contractor->email }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="5" style="background: @if($contractors->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="5" style="background: @if($contractors->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
