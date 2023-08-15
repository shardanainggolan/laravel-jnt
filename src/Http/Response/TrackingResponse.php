<?php

namespace Nextlogique\Jnt\Http\Response;

use Illuminate\Support\Collection;
use Nextlogique\Jnt\Http\Response\Tracking\Cnote;
use Nextlogique\Jnt\Http\Response\Tracking\Detail;
use Nextlogique\Jnt\Http\Response\Tracking\History;
use Nextlogique\Jnt\Http\Response\Factory as ResponseFactory;

/**
 * @property \Nextlogique\Jnt\Http\Response\Tracking\Cnote|null $cnote
 * @property \Nextlogique\Jnt\Http\Response\Tracking\Detail|null $detail
 * @property \Illuminate\Support\Collection<\Nextlogique\Jnt\Http\Response\Tracking\Detail> $details
 * @property \Illuminate\Support\Collection<\Nextlogique\Jnt\Http\Response\Tracking\Detail> $details
 * @property \Illuminate\Support\Collection<\Nextlogique\Jnt\Http\Response\Tracking\History> $history
 * @property \Illuminate\Support\Collection<\Nextlogique\Jnt\Http\Response\Tracking\History> $histories
 */
class TrackingResponse extends ResponseFactory
{
    public function cnote($value): Cnote
    {
        return new Cnote($value);
    }

    public function detail($value): Detail
    {
        return new Detail($value[0] ?? $value);
    }

    public function details(): Collection
    {
        $details = $this->attributes['detail'] ?? [];

        return (new Collection($details))->map(fn ($detail) => $this->detail($detail));
    }

    public function history($value): Collection
    {
        return (new Collection($value))->map(fn ($history) => new History($history));
    }

    public function histories(): Collection
    {
        return $this->history($this->attributes['history'] ?? []);
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
