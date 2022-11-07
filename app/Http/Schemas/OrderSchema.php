<?php

namespace App\Http\Schemas;

use Neomerx\JsonApi\Schema\BaseSchema;
use Neomerx\JsonApi\Contracts\Schema\ContextInterface;

class OrderSchema extends BaseSchema
{

    public function getType(): string
    {
        return 'order';
    }

    public function getId($order): ?string
    {
        return $order->id;
    }

    public function getAttributes($order, ContextInterface $context): iterable
    {
        return [
            'orderedOn' => $order->ordered_on->diffForHumans(),
            'status'  => $order->status,
            'discount' => $order->discount
        ];
    }

    public function getRelationships($author, ContextInterface $context): iterable
    {
        return [];
    }
}
