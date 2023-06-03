<?php

namespace Afaqy\Inspector\Http\Transformers;

use Afaqy\User\Models\User;
use Afaqy\Contact\Models\Contact;
use League\Fractal\Resource\Primitive;
use League\Fractal\TransformerAbstract;

class ShowTicketTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'created_by',
        'media',
        'response',
        'penalty',
    ];

    /**
     * @param mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'                => $data[0]['id'],
            'contractor_name'   => $data[0]['contractor_name'],
            'supervisor_name'   => $data[0]['supervisor_name'],
            'details'           => $data[0]['details'],
            'address'           => $data[0]['neighborhood_name'] . ", " . $data[0]['district_name'],
            'district_name'     => $data[0]['district_name'],
            'neighborhood_name' => $data[0]['neighborhood_name'],
            'created_at'        => $data[0]['created_at'],
            'updated_at'        => $data[0]['updated_at'],
        ];
    }

    /**
     * Transform districts count.
     *
     * @param mixed $data
     */
    public function includeCreatedBy($data)
    {
        $createdBy = [
            'name'  => $data[0]['username'],
            'image' => $data[0]['avatar'] ? route('image.show', explode('/', $data[0]['avatar'])) : null,
        ];

        return $this->primitive($createdBy);
    }

    /**
     * Transform media ticket.
     *
     * @param mixed $data
     * @return Primitive
     */
    public function includeMedia($data)
    {
        $images = $data->where('imageable_type', User::class)->pluck('url')->unique()->all();

        $media = [];

        foreach ($images as $image) {
            $media[] = route('image.show', explode('/', $image));
        }

        return $this->primitive($media);
    }

    /**
     * Transform ticket's response.
     *
     * @param mixed $data /
     * @return Primitive
     */
    public function includeResponse($data)
    {
        // @TODO: check optional helper performance
        $details = optional($data->where('responseable_type', Contact::class)->first())->response;
        $images  = $data->where('imageable_type', Contact::class)->pluck('url')->unique()->all();

        if (!$details && !$images) {
            return $this->primitive((object) []);
        }

        $response['details'] = $details;

        $media = [];

        foreach ($images as $image) {
            $media[] = route('image.show', explode('/', $image));
        }

        $response['images'] = $media;

        return $this->primitive($response);
    }

    /**
     * Transform ticket's violation.
     *
     * @param mixed $data
     * @return Primitive
     */
    public function includePenalty($data)
    {
        // @TODO: check optional helper performance
        $violation['details'] = optional($data->where('responseable_type', User::class)->first())->response;

        if (!$violation['details']) {
            return $this->primitive((object) []);
        }

        return $this->primitive($violation);
    }
}
