<?php

Route::prefix('v1/dashboard')->middleware(['auth:api', 'ability:owner,read-dashboard'])->group(function () {
    Route::get('/total-yesterday-info', 'DashboardChartsController@totalYesterdayInformation');
    Route::get('/total-system-info', 'DashboardChartsController@totalSystemInformation');
    Route::get('/today-contractors-info', 'DashboardChartsController@todayContractorsInformation');
    Route::get('/today-waste-types-info', 'DashboardChartsController@todayWasteTypesInformation');
    Route::get('/today-weights-count-per-hour', 'DashboardChartsController@todayWeightsCountPerHour');
    Route::get('/last-week-total-weights', 'DashboardChartsController@lastWeekTotalWeights');
});

Route::prefix('v1/reports')->middleware(['auth:api', 'ability:owner,read-dashboard'])->group(function () {
    Route::prefix('units')->group(function () {
        Route::get('/export/excel', 'UnitsRerportController@unitsExcelExport');
        Route::get('/export/pdf', 'UnitsRerportController@unitsPdfExport');
        Route::get('/header', 'UnitsRerportController@unitsHeader');
        Route::get('/total-weight', 'UnitsRerportController@totalWeight');
        Route::get('/', 'UnitsRerportController@unitsReport');
    });

    Route::prefix('districts')->group(function () {
        Route::get('/export/excel', 'DistrictsRerportController@districtsExcelExport');
        Route::get('/export/pdf', 'DistrictsRerportController@districtsPdfExport');
        Route::get('/header', 'DistrictsRerportController@districtsHeader');
        Route::get('/chart', 'DistrictsRerportController@chart');
        Route::get('/total-weight', 'DistrictsRerportController@totalWeight');
        Route::get('/map', 'DistrictsRerportController@mapRerport');
        Route::get('/', 'DistrictsRerportController@districtsRerport');
    });

    Route::prefix('contractors')->group(function () {
        Route::get('/export/excel', 'ContractorsRerportController@contractorsExcelExport');
        Route::get('/export/pdf', 'ContractorsRerportController@contractorsPdfExport');
        Route::get('/header', 'ContractorsRerportController@contractorsHeader');
        Route::get('/chart', 'ContractorsRerportController@chart');
        Route::get('/total-weight', 'ContractorsRerportController@totalWeight');
        Route::get('/', 'ContractorsRerportController@contractorsRerport');
    });

    Route::prefix('waste-types')->group(function () {
        Route::get('/export/excel', 'WasteTypesRerportController@wasteTypesExcelExport');
        Route::get('/export/pdf', 'WasteTypesRerportController@wasteTypesPdfExport');
        Route::get('/header', 'WasteTypesRerportController@wasteTypesHeader');
        Route::get('/chart', 'WasteTypesRerportController@chart');
        Route::get('/total-weight', 'WasteTypesRerportController@totalWeight');
        Route::get('/', 'WasteTypesRerportController@wasteTypesRerport');
    });

    Route::prefix('per-hour')->group(function () {
        Route::get('/export/excel', 'PerHourRerportController@perHourExcelExport');
        Route::get('/export/pdf', 'PerHourRerportController@perHourPdfExport');
        Route::get('/header', 'PerHourRerportController@perHourHeader');
        Route::get('/chart', 'PerHourRerportController@chart');
        Route::get('/total-weight', 'PerHourRerportController@totalWeight');
        Route::get('/', 'PerHourRerportController@perHourRerport');
    });

    Route::prefix('stations')->group(function () {
        Route::get('/export/excel', 'StationsRerportController@stationsExcelExport');
        Route::get('/export/pdf', 'StationsRerportController@stationsPdfExport');
        Route::get('/header', 'StationsRerportController@header');
        Route::get('/chart', 'StationsRerportController@chart');
        Route::get('/total-weight', 'StationsRerportController@totalWeight');
        Route::get('/', 'StationsRerportController@report');
    });

    Route::prefix('violations')->group(function () {
        Route::get('/export/excel', 'ViolationsRerportController@exportExcel');
        Route::get('/export/pdf', 'ViolationsRerportController@exportPdf');
        Route::get('/header', 'ViolationsRerportController@header');
        Route::get('/', 'ViolationsRerportController@report');
    });

    Route::prefix('tires')->group(function () {
        Route::get('/export/excel', 'TiresRerportController@excelExport');
        Route::get('/export/pdf', 'TiresRerportController@pdfExport');
        Route::get('/header', 'TiresRerportController@header');
        Route::get('/chart', 'TiresRerportController@chart');
        Route::get('/total-weight', 'TiresRerportController@totalWeight');
        Route::get('/', 'TiresRerportController@report');
    });

    Route::prefix('water-purification')->group(function () {
        Route::get('/export/excel', 'WaterPurificationRerportController@excelExport');
        Route::get('/export/pdf', 'WaterPurificationRerportController@pdfExport');
        Route::get('/header', 'WaterPurificationRerportController@header');
        Route::get('/chart', 'WaterPurificationRerportController@chart');
        Route::get('/total-weight', 'WaterPurificationRerportController@totalWeight');
        Route::get('/', 'WaterPurificationRerportController@report');
    });

    Route::prefix('incinerator')->group(function () {
        Route::get('/export/excel', 'IncineratorReportController@excelExport');
        Route::get('/export/pdf', 'IncineratorReportController@pdfExport');
        Route::get('/header', 'IncineratorReportController@header');
        Route::get('/chart', 'IncineratorReportController@chart');
        Route::get('/total-weight', 'IncineratorReportController@totalWeight');
        Route::get('/', 'IncineratorReportController@report');
    });

    Route::prefix('sorting-area')->group(function () {
        Route::get('/export/excel', 'SortingAreaRerportController@excelExport');
        Route::get('/export/pdf', 'SortingAreaRerportController@pdfExport');
        Route::get('/header', 'SortingAreaRerportController@header');
        Route::get('/chart', 'SortingAreaRerportController@chart');
        Route::get('/total-weight', 'SortingAreaRerportController@totalWeight');
        Route::get('/', 'SortingAreaRerportController@report');
    });

    Route::prefix('washing-station')->group(function () {
        Route::get('/export/excel', 'WashingStationRerportController@excelExport');
        Route::get('/export/pdf', 'WashingStationRerportController@pdfExport');
        Route::get('/header', 'WashingStationRerportController@header');
        Route::get('/chart', 'WashingStationRerportController@chart');
        Route::get('/total-weight', 'WashingStationRerportController@totalWeight');
        Route::get('/', 'WashingStationRerportController@report');
    });

    Route::prefix('cells')->group(function () {
        Route::get('/export/excel', 'CellsRerportController@excelExport');
        Route::get('/export/pdf', 'CellsRerportController@pdfExport');
        Route::get('/header', 'CellsRerportController@header');
        Route::get('/chart', 'CellsRerportController@chart');
        Route::get('/total-weight', 'CellsRerportController@totalWeight');
        Route::get('/', 'CellsRerportController@report');
    });
});
