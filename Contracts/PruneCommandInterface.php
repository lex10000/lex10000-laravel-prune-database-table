<?php


namespace Lex10000\LaravelPruneDatabaseTable\Contracts;
use DateTimeInterface;

interface PruneCommandInterface
{
    /**
     * Prune all of the entries older than the given date.
     *
     * @param  \DateTimeInterface  $before
     * @return int
     */
    public function prune(DateTimeInterface $before);
}
