<?php

namespace Nextlogique\Jnt\Http\Response;

use Nextlogique\Jnt\Http\Response\AWB\Awb;
use Nextlogique\Jnt\Http\Response\Factory as ResponseFactory;
use Illuminate\Support\Collection;

/**
 * @property \Illuminate\Support\Collection<\Nextlogique\Jnt\Http\Response\AWB\Awb> $awb
 */
class StockAwbResponse extends ResponseFactory
{
    public function awb($value): Collection
    {
        return (new Collection($value))->map(fn ($awb) => new Awb($awb));
    }

    public function isError(): bool
    {
        return (bool) $this->error || $this->status == 'Error';
    }

   public function getErrorMessage(): ?string
   {
       return $this->reason ?? $this->error;
   }
}
