<?php

namespace Afaqy\Contact\Actions;

use Afaqy\Core\Actions\Action;

class StoreContactAction extends Action
{
    /** @var mixed */
    private $data;

    /** @var object */
    private $contactable;

    /**
     * @param mixed $data
     * @return void
     */
    public function __construct($data, $contactable)
    {
        $this->data        = $data;
        $this->contactable = $contactable;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        if (is_array($this->data)) {
            return $this->storeMany($this->data, $this->contactable);
        }

        return $this->storeItem($this->data, $this->contactable);
    }

    /**
     * @param  mixed $data
     * @return boolean
     */
    private function storeMany($data, $contactable): bool
    {
        foreach ($data as $contact) {
            $contactNew = $contactable->contacts()->create([
                'name'            => $contact->name,
                'title'           => $contact->title,
                'email'           => $contact->email,
                'default_contact' => $contact->default_contact,
            ]);

            foreach ($contact->phones as $phone) { // need to refactor
                $phone = $contactNew->phones()->create([
                    'phone' => $phone,
                ]);
            }
        }

        return true;
    }

    /**
     * @param  mixed $data
     * @return boolean
     */
    private function storeItem($data, $contactable): bool
    {
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
}
