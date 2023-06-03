@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            <th>رقم التصريح</th>
            <th>النوع</th>
            <th>الوزن المصرح بيه</th>
            <th>الوزن الفعلى</th>
        </tr>
    </thead>
    <tbody>
        @php $num = 1; @endphp
        @foreach($permissions->chunk(100) as $permissions_chunk)
            @foreach($permissions_chunk as $permission)
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    <td>{{ $permission->permission_number }}</td>
                    <td>{{ $permission->type }}</td>
                    <td>{{ $permission->allowed_weight }}</td>
                    <td>{{ $permission->actual_weight }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="3" style="background: @if($permissions->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="3" style="background: @if($permissions->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
