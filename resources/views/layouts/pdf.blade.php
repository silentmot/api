<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
    body {
        font-family: "DejaVuSansCondensed", sans-serif;
    }

    .titles {
        width: 50%;
        float: right;
        color: blue;
        text-align: right;
    }


    .titles .title {
        color: gray;
    }

    .logo {
        float: left;
        width: 50%;
    }

    .logo p {
        float: left;
        text-align: left;
    }

    .logo .date {
        direction: rtl;
    }

    .clear {
        clear: both;
    }

    .table table {
        width: 100%;
        direction: rtl;
    }

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    .table .table-title {
        text-align: center;
        background: blue;
        color: white;
        padding: 10px;
        font-weight: bold;
    }

    td,
    th {
        border: 1px solid #707070;
        text-align: left;
        padding: 8px;
        direction: rtl;
        text-align: right;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    @media print {
        .table .table-title {
            background: blue !important;
            -webkit-print-color-adjust: exact;

        }
    }

    @page {
        header: page-header;
        footer: page-footer;
    }

    </style>
</head>

<body>
    <!-- start header section -->
    <div class="header">
        <!-- start logo [left] -->
        <div class="logo">
            <img src="{{ public_path('Jeddah.png') }}" style="width: 40%; height: auto;" alt="logo">
            <p class="date"> تاريخ الاصدار : <span> {{ \Carbon\Carbon::now()->toDateString() }}</span> </p>
        </div>
        <!-- end logo  -->
        <!-- start titles section [right] -->
        <div class="titles">
            <p>المملكة العربية السعودية</p>
            <p>وزارة الشؤون البلدية والقروية</p>
            <p>أمانة محافظة جدة</p>
        </div>
        <!-- end titles section [right] -->
        <div class="clear"></div>
    </div>
    <!-- end header section -->

    <!-- start table section  -->
    <div class="table">
        <div class="table-title">{{ $title }}</div>
        @yield('table')
    </div>
    <!-- end table section -->

    <htmlpagefooter name="page-footer">
        <div style="text-align: center;">{PAGENO}</div>
    </htmlpagefooter>
</body>

</html>
