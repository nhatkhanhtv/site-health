<?php

namespace App;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum UptimeStatus: string implements HasColor, HasLabel
{
    case OK = 'OK';
    case FAIL = 'FAIL';

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::OK     => 'success',
            self::FAIL => 'danger'
            
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::OK => 'Success',
            self::FAIL => 'Failed',
        };
    }
}
