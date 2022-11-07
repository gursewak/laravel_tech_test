<?php

namespace App\Http\Schemas;

use Neomerx\JsonApi\Schema\BaseSchema;
use Neomerx\JsonApi\Contracts\Schema\ContextInterface;

class UserSchema extends BaseSchema
{

    public function getType(): string
    {
        return 'user';
    }

    public function getId($user): ?string
    {
        return $user->id;
    }

    public function getAttributes($user, ContextInterface $context): iterable
    {
        return [
            'name' => $user->name,
            'email'  => $user->email,
            'wallet' => $user->wallet,
        ];
    }

    public function getRelationships($user, ContextInterface $context): iterable
    {
        return [
            'orders' => [

                // Data include supported as well as other cool features
                'data' => $user->orders,
            ],
        ];
    }
}
