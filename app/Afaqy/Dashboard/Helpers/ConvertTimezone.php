<?php

namespace Afaqy\Dashboard\Helpers;

use Carbon\CarbonTimeZone;

class ConvertTimezone
{
    /**
     * @var string|null
     */
    private $column;

    /**
     * @var string|null
     */
    private $format;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @param  string $column
     * @return self
     */
    public function column(string $column): self
    {
        $this->column = $column;

        return $this;
    }

    /**
     * @param  string $format
     * @return self
     */
    public function format(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @param  string $name
     * @return self
     */
    public function as(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return self
     */
    public function reset()
    {
        $this->column = null;
        $this->name   = null;
        $this->format = null;

        return $this;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        $tz = CarbonTimeZone::create(config('app.timezone'))->toOffsetName();

        $string = "DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(`{$this->column}`), 'SYSTEM', '${tz}'), '{$this->format}')";

        if ($this->name) {
            $string .= " AS `{$this->name}`";
        }

        $this->reset();

        return $string;
    }
}
