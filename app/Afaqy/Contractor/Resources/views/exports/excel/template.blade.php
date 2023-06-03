<table>
    @include('layouts.excel-sheet-header')

    {{-- table title --}}
    <tr><th colspan="7" rowspan="2" style="font-size: 16px; text-align: center; background:#3f2986; color:#ffffff; vertical-align: center;">‫‫قائمة‬ مقاولين ‫مردم‬ جدة‬</th></tr>
    <tr></tr>

    {{-- table --}}
    <tr>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>م</strong></th>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>أسم المقاول</strong></th>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>المركبات</strong></th>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>العمالة</strong></th>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>المسئول</strong></th>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>الهاتف</strong></th>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>البريد الالكترونى</strong></th>
    </tr>
    @php $num = 1; @endphp
    @foreach($contractors->chunk(100) as $contractors_chunk)
            @foreach($contractors_chunk as $key => $contractor)
            <tr>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">@php echo $num++; @endphp</td>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">{{ $contractor->name_en }} - {{ $contractor->name_ar }}</td>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">{{ $contractor->units_count }}</td>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">{{ $contractor->employees }}</td>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">{{ $contractor->name }}</td>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">{{ $contractor->phone }}</td>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">{{ $contractor->email }}</td>
            </tr>
        @endforeach
    @endforeach

    {{-- footer --}}
    <tr>
        <td colspan="2" rowspan="2" style="border: 0.5px solid #8e8c8c; font-size: 12px; background:#3f2986; color:#ffffff; vertical-align: center;" >الإســـــــم</td>
        <td colspan="5" rowspan="2" style="border: 0.5px solid #8e8c8c; background: @if($contractors->count() % 2) #dfe2e5 @endif;" ></td>
    </tr>
    <tr></tr>
    <tr>
        <td colspan="2" rowspan="2" style="border: 0.5px solid #8e8c8c; font-size: 12px; background:#3f2986; color:#ffffff; vertical-align: center;">الــــتاريخ</td>
        <td colspan="5" rowspan="2" style="border: 0.5px solid #8e8c8c; background: @if($contractors->count() % 2) #dfe2e5 @endif;"></td>
    </tr>
    <tr></tr>
</table>
