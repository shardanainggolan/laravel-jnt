<?php

namespace Nextlogique\Knt\Http\Response;

use Nextlogique\Jnt\Http\Response\Tariff\Price;
use Nextlogique\Jnt\Http\Response\Factory as ResponseFactory;
use Illuminate\Support\Collection;

/**
 * @property \Illuminate\Support\Collection<\Nextlogique\Jnt\Http\Response\Tariff\Price> $price
 * @property \Illuminate\Support\Collection<\Nextlogique\Jnt\Http\Response\Tariff\Price> $prices
 */
class TariffResponse extends ResponseFactory
{
    public function price($value): Collection
    {
        return (new Collection($value))->map(fn ($price) => new Price($price));
    }

    public function prices(): Collection
    {
        return $this->price($this->attributes['price'] ?? []);
    }

    public function isError(): bool
    {
        return (bool) $this->error;
    }

   public function getErrorMessage(): ?string
   {
       return $this->error;
   }
}
