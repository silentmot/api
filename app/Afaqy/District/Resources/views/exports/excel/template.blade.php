<table>
    @include('layouts.excel-sheet-header')

    {{-- table title --}}
    <tr><th colspan="5" rowspan="2" style="font-size: 16px; text-align: center; background:#3f2986; color:#ffffff; vertical-align: center;">‫‫قائمة‬ المناطق المسجلة في ‫مردم‬ جدة‬</th></tr>
    <tr></tr>

    {{-- table --}}
    <tr>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>م</strong></th>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>البلديات</strong></th>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>الاحياء</strong></th>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>الكثافة السكانية</strong></th>
        <th style="border: 0.5px solid #8e8c8c; border-top: 0.5px solid #3f2986; width: 15px; text-align: center;"><strong>الاحياء الفرعية</strong></th>
    </tr>
    @php $num = 1; @endphp
    @foreach($districts->chunk(100) as $districts_chunk)
            @foreach($districts_chunk as $key => $district)
            <tr>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">@php echo $num++; @endphp</td>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">{{ $district->districtName }}</td>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">{{ $district->neighborhoodName }}</td>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">{{ $district->neighborhoodPopulation }}</td>
                <td style="border: 0.5px solid #8e8c8c; background: @if($key % 2) #dfe2e5 @endif; text-align: center;">{{ $district->subNeighborhoodName }}</td>
            </tr>
        @endforeach
    @endforeach

    {{-- footer --}}
    <tr>
        <td colspan="2" rowspan="2" style="border: 0.5px solid #8e8c8c; font-size: 12px; background:#3f2986; color:#ffffff; vertical-align: center;" >الإســـــــم</td>
        <td colspan="3" rowspan="2" style="border: 0.5px solid #8e8c8c; background: @if($districts->count() % 2) #dfe2e5 @endif;" ></td>
    </tr>
    <tr></tr>
    <tr>
        <td colspan="2" rowspan="2" style="border: 0.5px solid #8e8c8c; font-size: 12px; background:#3f2986; color:#ffffff; vertical-align: center;">الــــتاريخ</td>
        <td colspan="3" rowspan="2" style="border: 0.5px solid #8e8c8c; background: @if($districts->count() % 2) #dfe2e5 @endif;"></td>
    </tr>
    <tr></tr>
</table>
