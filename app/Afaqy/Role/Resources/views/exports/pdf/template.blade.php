@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            <th>إسم الوظيفة</th>
            <th>عدد المستخدمين</th>
        </tr>
    </thead>
    <tbody>
        @php $num = 1; @endphp
        @foreach($roles->chunk(100) as $roles_chunk)
            @foreach($roles_chunk as $role)
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    <td>{{ $role->display_name }}</td>
                    <td>{{ $role->users_count }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="1" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="2" style="background: @if($roles->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="1" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="2" style="background: @if($roles->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
