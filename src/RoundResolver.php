<?php

declare(strict_types = 1);

namespace BraveRats;

use BraveRats\RoundResolvers\CapacityResolver;
use BraveRats\RoundResolvers\ValueResolver;
use BraveRats\RoundResults\NoResult;
use BraveRats\RoundResults\Player1Win;
use BraveRats\RoundResults\Player2Win;
use BraveRats\RoundResults\RoundOnHold;

class RoundResolver
{
    private
        $valueResolver,
        $capacityResolver;

    public function __construct(ValueResolver $valueResolver, CapacityResolver $capacityResolver)
    {
        $this->valueResolver = $valueResolver;
        $this->capacityResolver = $capacityResolver;
    }

    public function resolve(Round $round, RoundHistory $roundHistory): RoundResult
    {
        $capacityResolverResult = $this->capacityResolver->resolve($round, $roundHistory);

        if($capacityResolverResult instanceof NoResult)
        {
            return $this->valueResolver->resolve($round, $roundHistory);
        }

        return $capacityResolverResult;
    }
}