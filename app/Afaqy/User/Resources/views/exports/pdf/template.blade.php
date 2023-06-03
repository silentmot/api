@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            <th>إسم المستخدم</th>
            <th>إسم الدخول</th>
            <th>الوظيفة</th>
            <th>البريد الالكترونى</th>
            <th>رقم الهاتف</th>
            <th>الحالة</th>
        </tr>
    </thead>
    <tbody>
        @php $num = 1; @endphp
        @foreach($users->chunk(100) as $users_chunk)
            @foreach($users_chunk as $user)
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    <td>{{ $user->full_name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td> @if($user->status) نشط @else غير نشط @endif</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="5" style="background: @if($users->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="2" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="5" style="background: @if($users->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
