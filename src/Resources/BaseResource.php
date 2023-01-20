<?php

declare(strict_types=1);

namespace Providus\Providus\Resources;

use Providus\Providus\Providus;

abstract class BaseResource
{
    public array $attributes = [];

    protected ?Providus $providus;

    public function __construct(array $attributes, Providus $providus = null)
    {
        $this->attributes = $attributes;

        $this->providus = $providus;

        $this->fill();
    }

    protected function fill(): void
    {
        foreach ($this->attributes as $key => $value) {
            $key = $this->camelCase($key);

            $this->{$key} = $value;
        }
    }

    protected function camelCase(string $key): string
    {
        $parts = explode('_', $key);

        foreach ($parts as $i => $part) {
            if ($i !== 0) {
                $parts[$i] = ucfirst($part);
            }
        }

        return str_replace(' ', '', implode(' ', $parts));
    }

    public function __sleep()
    {
        $publicProperties = (new ReflectionObject($this))->getProperties(ReflectionProperty::IS_PUBLIC);

        $publicPropertyNames = array_map(function (ReflectionProperty $property) {
            return $property->getName();
        }, $publicProperties);

        return array_diff($publicPropertyNames, ['bloc', 'attributes']);
    }
}
