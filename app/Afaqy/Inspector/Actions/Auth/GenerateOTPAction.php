<?php

namespace Afaqy\Inspector\Actions\Auth;

use Carbon\Carbon;
use Afaqy\Core\Actions\Action;
use Afaqy\Contact\Models\Contact;
use Afaqy\Inspector\Models\SupervisorOTP;

class GenerateOTPAction extends Action
{
    /** @var string */
    private $phone;

    /**
     * @param string $phone
     * @return void
     */
    public function __construct(string $phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $contact = $this->getContact($this->phone);

        $this->deleteUnusedOTPs($contact->id);

        return SupervisorOTP::create([
            'contact_id'    => $contact->id,
            'otp_code'      => rand(10000, 99999),
            'expires_at'    => Carbon::now()->addMinutes(5)->toDateTimeString(),
        ]);
    }

    /**
     * @param  string $phone
     * @return int
     */
    private function getContact(string $phone)
    {
        return Contact::select([
            'contacts.id',
            'contacts.name',
            'contacts.email',
        ])
            ->onlyContractsPhones()
            ->where('phones.phone', $this->phone)
            ->first();
    }

    /**
     * Delete old unused OTPs before create a new one.
     *
     * @param  int    $contact_id
     * @return int
     */
    private function deleteUnusedOTPs(int $contact_id)
    {
        return SupervisorOTP::where('contact_id', $contact_id)->delete();
    }
}
