<?php

namespace Afaqy\Activity\Http\Transformers;

use League\Fractal\TransformerAbstract;

class ActivitiesTransformer extends TransformerAbstract
{
    /**
     * @param mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'          => $data['id'],
            'record_id'   => $this->getRecordIdentifier($data),
            'username'    => $data['causer']['username'] ?? '',
            'module_name' => $this->getModuleName($data),
            'action_name' => $this->getActionName($data),
            'created_at'  => $data['created_at'],
        ];
    }

    /**
     * @param $data
     * @return mixed
     */
    public function getRecordIdentifier($data): string
    {
        return $data['properties']['attributes']['name']
            ?? $data['subject_id']
            ?? '';
    }

    /**
     * @param $data
     * @return false|string[]
     */
    public function getModuleName($data)
    {
        $subject    = explode("\\", $data['subject_type']);
        $subjectMap =[
            'User'                                     => 'المستخدمين',
            'Role'                                     => 'الوظائف',
            'UnitType'                                 => 'انواع المركبات',
            'Contractor'                               => 'المقاولون',
            'WasteType'                                => 'انواع النفايات',
            'District'                                 => 'البلديات',
            'Contract'                                 => 'عقود',
            'Unit'                                     => 'مركبات',
            'Scale'                                    => 'موازين',
            'Zone'                                     => 'مناطق',
            'TransitionalStation'                      => 'المحطة الانتقالية',
            'EntrancePermission'                       => 'تصريح دخول',
            'Permission'                               => 'تصاريح',
            'Geofence'                                 => 'الموقع الجغرافي',
            'Device'                                   => 'اجهزه',
        ];

        return $subjectMap [end($subject)];
    }

    /**
     * @param $data
     * @return mixed
     */
    public function getActionName($data): string
    {
        $actionName = [
            'created' => 'اضافه',
            'updated' => 'تعديل',
            'deleted' => 'حذف',
        ];

        return $actionName[$data['description']];
    }
}
