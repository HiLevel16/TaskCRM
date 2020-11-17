<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Pending()
 * @method static static Declined()
 * @method static static Completed()
 */
final class TaskStatus extends Enum
{
    const Pending = 'Pending';
    const Declined = 'Declined';
    const Completed = 'Completed';
}
