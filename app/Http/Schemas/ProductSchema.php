<?php

namespace App\Http\Schemas;

use Neomerx\JsonApi\Schema\BaseSchema;
use Neomerx\JsonApi\Contracts\Schema\ContextInterface;

class ProductSchema extends BaseSchema
{

    public function getType(): string
    {
        return 'product';
    }

    public function getId($product): ?string
    {
        return $product->id;
    }

    public function getAttributes($product, ContextInterface $context): iterable
    {
        return [
            'name' => $product->name,
            'price'  => $product->price
        ];
    }

    public function getRelationships($product, ContextInterface $context): iterable
    {
        return [];
    }
}
