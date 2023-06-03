<?php

namespace Afaqy\Permission\Lookups;

use Afaqy\Core\Helpers\Lookup;

class PermissionTypeLookup extends Lookup
{
    public const INDIVIDUAL   = 'دمارات أفراد';

    public const PROJECT      = 'دمارات مشاريع';

    public const COMMERCIAL   = 'امر اتلاف تجارى';

    public const GOVERNMENTAL = 'امر اتلاف حكومى';

    public const SORTING      = 'مصنع الفرز';
}
