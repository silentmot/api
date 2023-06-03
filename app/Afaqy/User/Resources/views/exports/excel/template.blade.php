<table>
    @include('layouts.excel-sheet-header')

    {{-- table title --}}
    <tr><th colspan="7" rowspan="2" style="font-size: 16px; text-align: center; background:#3f2986; color:#ffffff; vertical-align: center;">قائمة مستخدمي نظام مردم جدة</th></tr>
    <tr></tr>

    {{-- table --}}
    <tr>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>م</strong></th>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>إسم المستخدم</strong></th>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>إسم الدخول</strong></th>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>الوظيفة</strong></th>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>البريد الالكترونى</strong></th>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>رقم الهاتف</strong></th>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>الحالة</strong></th>
    </tr>
    @php $num = 1; @endphp
    @foreach($users->chunk(100) as $users_chunk)
        @foreach($users_chunk as $key => $user)
            <tr>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">@php echo $num++; @endphp</td>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">{{ $user->full_name }}</td>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">{{ $user->username }}</td>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">{{ $user->role }}</td>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">{{ $user->email }}</td>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">{{ $user->phone }}</td>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;"> @if($user->status) نشط @else غير نشط @endif</td>
            </tr>
        @endforeach
    @endforeach

    {{-- footer --}}
    <tr>
        <td colspan="2" rowspan="2" style="border: 0.5px solid #8e8c8c; font-size: 12px; background:#3f2986; color:#ffffff; vertical-align: center;" >الإســـــــم</td>
        <td colspan="5" rowspan="2" style="border: 0.5px solid #8e8c8c; background: @if($users->count() % 2) #dfe2e5 @endif;" ></td>
    </tr>
    <tr></tr>
    <tr>
        <td colspan="2" rowspan="2" style="border: 0.5px solid #8e8c8c; font-size: 12px; background:#3f2986; color:#ffffff; vertical-align: center;">الــــتاريخ</td>
        <td colspan="5" rowspan="2" style="border: 0.5px solid #8e8c8c; background: @if($users->count() % 2) #dfe2e5 @endif;"></td>
    </tr>
    <tr></tr>
</table>
