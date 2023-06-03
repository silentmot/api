<table>
    @include('layouts.excel-sheet-header')

    {{-- table title --}}
    <tr><th colspan="3" rowspan="2" style="font-size: 16px; text-align: center; background:#3f2986; color:#ffffff; vertical-align: center;">‫‫قائمة‬ انواع مركبات ‫مردم‬ جدة‬</th></tr>
    <tr></tr>

    {{-- table --}}
    <tr>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>م</strong></th>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>نوع المركبة</strong></th>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>المركبات</strong></th>
    </tr>
    @php $num = 1; @endphp
    @foreach($types->chunk(100) as $types_chunk)
            @foreach($types_chunk as $key => $type)
            <tr>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">@php echo $num++; @endphp</td>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">{{ $type->name }}</td>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">{{ $type->units_count }}</td>
            </tr>
        @endforeach
    @endforeach

    {{-- footer --}}
    <tr>
        <td colspan="1" rowspan="2" style="border: 0.5px solid #8e8c8c; font-size: 12px; background:#3f2986; color:#ffffff; vertical-align: center;" >الإســـــــم</td>
        <td colspan="2" rowspan="2" style="border: 0.5px solid #8e8c8c; background: @if($types->count() % 2) #dfe2e5 @endif;" ></td>
    </tr>
    <tr></tr>
    <tr>
        <td colspan="1" rowspan="2" style="border: 0.5px solid #8e8c8c; font-size: 12px; background:#3f2986; color:#ffffff; vertical-align: center;">الــــتاريخ</td>
        <td colspan="2" rowspan="2" style="border: 0.5px solid #8e8c8c; background: @if($types->count() % 2) #dfe2e5 @endif;"></td>
    </tr>
    <tr></tr>
</table>
