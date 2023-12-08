<?php

namespace App\GraphQL\Types;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\CustomScalarType;
use Crypt;

class TeamType extends GraphQLType
{

    protected $attributes = [
        'name' =>  'team record ',
        'description' => 'A response team response'
    ];

    public function fields(): array
    {
        return [

            'team_id' => [
                'type' => new CustomScalarType([
                    'name' => 'team_category_encrypted_id',
                    'serialize' => function ($value) {
                        $result = Crypt::encryptString($value);
                        return $result;
                    }
                ]),
                'alias' => 'fldTeamID',
            ],
            'original_team_id' => [
                'type' => Type::string(),
                'alias' => 'fldTeamID',
            ],
            'name' => [
                'type' => Type::string(),
                'alias' => 'fldTeamName',
            ],
            'position' => [
                'type' => Type::string(),
                'alias' => 'fldTeamPosition',
            ],
            'type' => [
                'type' => Type::string(),
                'alias' => 'fldTeamType',
            ],
            'image' => [
                'type' => Type::string(),
                'alias' => 'fldTeamImage',
            ],
            'image_webp' => [
                'type' => new CustomScalarType([
                    'name' => 'team_image_webp',
                    'serialize' => function ($value) {
                        $image_arr = explode(".", $value);
                        return $image_arr[0] . '.webp';
                    }
                ]),
                'alias' => 'fldTeamImage',
            ],

        ];
    }
}
