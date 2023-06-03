<?php

namespace Afaqy\Contractor\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\Contractor\Models\Contractor;

class UpdateContractorAction extends Action
{
    /** @var \Afaqy\Contractor\DTO\ContractorData */
    private $data = [];

    /**
     * @param mixed $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $contractor = Contractor::findOrFail($this->data->id);

        $contractor->update([
            'name_ar'           => $this->data->name_ar,
            'name_en'           => $this->data->name_en,
            'commercial_number' => $this->data->commercial_number,
            'address'           => $this->data->address,
            'employees'         => $this->data->employees,
            'avl_company'       => $this->data->avl_company,
        ]);

        return $contractor;
    }
}
