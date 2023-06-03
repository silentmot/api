@extends('layouts.pdf')

@section('table')
<table>
    <thead>
        <tr>
            <th>م</th>
            <th>أسم الميزان</th>
            <th>IP</th>
            <th>Port</th>
        </tr>
    </thead>
    <tbody>
        @php $num = 1; @endphp
        @foreach($scales as $scale)
                <tr>
                    <td>@php echo $num++; @endphp</td>
                    <td>{{ $scale->name }}</td>
                    <td>{{ $scale->ip }}</td>
                    <td>{{ $scale->com_port }}</td>
                </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="1" style="direction: rtl; text-align: center; background: blue; color: white;">الاسم</td>
            <td colspan="3" style="background: @if($scales->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
        <tr>
            <td colspan="1" style="direction: rtl; text-align: center; background: blue; color: white;">التوقيع</td>
            <td colspan="3" style="background: @if($scales->count() % 2 == 0) #fff @else #dddddd @endif"></td>
        </tr>
    </tfoot>
</table>
@endsection
