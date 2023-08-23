<?php

namespace Nextlogique\Jnt\Http\Response;

use Nextlogique\Jnt\Http\Response\AWB\Awb;
use Nextlogique\Jnt\Http\Response\Factory as ResponseFactory;

/**
 * @property \Nextlogique\Jnt\Http\Response\AWB\Awb $detail
 * @property \Nextlogique\Jnt\Http\Response\AWB\Awb $awb
 */
class CreateOrderResponse extends ResponseFactory
{
    public function detail($value)
    {
        return new Awb($value[0] ?? []);
    }

    public function awb()
    {
        return $this->detail($this->attributes['detail']);
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
