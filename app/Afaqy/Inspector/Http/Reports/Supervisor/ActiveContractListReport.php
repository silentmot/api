<?php

namespace Afaqy\Inspector\Http\Reports\Supervisor;

use Carbon\Carbon;
use Afaqy\Contract\Models\Contract;
use Afaqy\Core\Http\Reports\Report;
use Illuminate\Support\Facades\Auth;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Inspector\Http\Transformers\Supervisor\ActiveContractListTransformer;

class ActiveContractListReport extends Report
{
    use Generator;

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateSelectList(
            $this->query(),
            new ActiveContractListTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $date  = Carbon::now()->toDateString();
        $phone = Auth::user()->phones()->first()->phone;

        return Contract::withContactsInformation()
            ->select([
                'contracts.id',
                'contracts.contract_number',
            ])
            ->where('contracts.start_at', '<=', $date)
            ->where('contracts.end_at', '>=', $date)
            ->where('contracts.status', 1)
            ->where('phones.phone', $phone);
    }
}
