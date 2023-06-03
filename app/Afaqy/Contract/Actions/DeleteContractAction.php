<?php

namespace Afaqy\Contract\Actions;

use Carbon\Carbon;
use Afaqy\Core\Actions\Action;
use Afaqy\Contract\Models\Contract;

class DeleteContractAction extends Action
{
    /** @var mixed */
    private $id;

    /**
     * @param mixed  $id
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        if (is_array($this->id)) {
            return $this->deleteMany($this->id);
        }

        return $this->delete($this->id);
    }

    /**
     * @param  array  $ids
     * @return int
     */
    private function deleteMany(array $ids): int
    {
        $contracts = Contract::whereIn('id', $ids)
            ->where(function ($query) {
                return $query->where('end_at', '>', Carbon::now()->toDateString())
                    ->orWhere('status', 1);
            });

        if ($contracts->count()) {
            return 0;
        }

        return Contract::destroy($ids);
    }

    /**
     * @param  int  $id
     * @return int
     */
    private function delete(int $id): int
    {
        $contract = Contract::findOrFail($id);

        if (
            $contract->end_at > Carbon::now()->toDateString() &&
            $contract->status == 1
        ) {
            return 0;
        }

        return $contract->delete();
    }
}
