<?php

namespace Afaqy\Contact\Actions;

use Afaqy\Core\Actions\Action;

class UpdateContactAction extends Action
{
    /** @var \Afaqy\Contractor\DTO\ContractorUpdateData */
    private $data = [];

    /** @var object */
    private $contactable;

    /**
     * @param mixed $data
     * @return void
     */
    public function __construct($data, $contactable)
    {
        $this->data         = $data;
        $this->contactable  = $contactable;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        if (is_array($this->data)) {
            return $this->updateMany($this->data, $this->contactable);
        }

        return $this->updateItem($this->data, $this->contactable);
    }

    /**
     * @param  mixed $data
     * @return boolean
     */
    private function updateMany($data, $contactable): bool
    {
        $this->deleteOldContact($contactable);

        foreach ($this->data as $key => $contact) {
            $newContact = $contactable->contacts()->create([
                'name'            => $contact->name,
                'title'           => $contact->title,
                'email'           => $contact->email,
                'default_contact' => $contact->default_contact,
            ]);

            $newContact->phones()->insert(array_map(function ($phone) use ($newContact) {
                return [
                    'contact_id' => $newContact->id,
                    'phone'      => $phone,
                ];
            }, $contact->phones));
        }

        return true;
    }

    /**
     * @param  mixed $data
     * @return boolean
     */
    private function updateItem($data, $contactable): bool
    {
        $this->deleteOldContact($contactable);

        $contact = $contactable->contacts()->create([
            'name'            => $data->name,
            'title'           => $data->title,
            'email'           => $data->email,
        ]);

        $contact->phones()->create([
            'phone' => $data->phone,
        ]);

        return true;
    }

    /**
     * @param  mixed $contactable
     * @return void
     */
    private function deleteOldContact($contactable)
    {
        foreach ($contactable->contacts()->get() as $key => $contact) {
            $contact->phones()->delete();
            $contact->delete();
        }
    }
}
