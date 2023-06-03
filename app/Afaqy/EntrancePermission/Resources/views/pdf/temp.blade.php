@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            <th>رقم التصريح</th>
            <th>نوع التصريح</th>
            <th>الاسم</th>
            <th>رقم اللوحه</th>
            <th>تاريخ البدء</th>
            <th>تاريخ الانتهاء</th>
        </tr>
    </thead>
    <tbody>
        @php $num = 1; @endphp
        @foreach($permissions->chunk(100) as $permissions_chunk)
            @foreach($permissions_chunk as $permission)
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    <td>{{ $permission->id }}</td>
                    <td>@php echo ($permission->type == 'visitor') ? 'زائر' : 'موظف'; @endphp</td>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->plate_number }}</td>
                    <td>{{ $permission->start_date }}</td>
                    <td>{{ $permission->end_date }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="5" style="background: @if($permissions->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="5" style="background: @if($permissions->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
