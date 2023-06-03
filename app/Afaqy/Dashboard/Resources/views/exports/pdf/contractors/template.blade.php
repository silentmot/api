@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            @foreach($headers as $header)
                <th>{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @php $num = 1; @endphp

        @foreach($contractors as $contractor)
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    @foreach($contractor as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="@php echo count($headers) - 2; @endphp" style="background: @if(count($contractors) % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="3" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="@php echo count($headers) - 2; @endphp" style="background: @if(count($contractors) % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
