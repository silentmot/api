<?php

namespace Afaqy\Contractor\Database\Seeders;

use Afaqy\Contact\Models\Phone;
use Illuminate\Database\Seeder;
use Afaqy\Contact\Models\Contact;
use Afaqy\Contractor\Models\Contractor;

class ContractorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        if (! Contractor::count()) {
            factory(Contractor::class, 50)
                ->create()
                ->each(function ($contractor) {
                    for ($i=0; $i < 2; $i++) {
                        if ($i == 0) {
                            $data = [
                                'contactable_id'  => $contractor->id,
                                'default_contact' => 1,
                            ];
                        } else {
                            $data = [
                                'contactable_id'  => $contractor->id,
                                'default_contact' => 0,
                            ];
                        }

                        $contact = $contractor->contacts()->save(factory(Contact::class)->make($data));

                        $contact->phones()->insert(factory(Phone::class, 2)->make([
                            'contact_id' => $contact->id,
                        ])->toArray());
                    }
                });
        }
    }
}
