<?php

namespace Afaqy\Inspector\Http\Reports\Supervisor;

use Afaqy\Contact\Models\Contact;
use Afaqy\Contract\Models\Contract;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Inspector\Http\Transformers\Supervisor\ShowProfileTransformer;

class SupervisorShowProfileReport extends Report
{
    use Generator;

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateViewShow(
            $this->query(),
            new ShowProfileTransformer()
        );
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Contact::withphones()
            ->select([
                'contacts.id',
                'contacts.name',
                'contacts.email',
                'phones.phone',
            ])
            ->where('contacts.contactable_id', request()->header('contract-id'))
            ->where('contacts.contactable_type', Contract::class);
    }
}
