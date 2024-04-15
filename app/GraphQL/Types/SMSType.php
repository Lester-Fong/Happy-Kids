<?php

namespace App\GraphQL\Types;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\CustomScalarType;
use Crypt;
use GraphQL\GraphQL as GraphQLGraphQL;

class SMSType extends GraphQLType
{

    protected $attributes = [
        'name' =>  'sms record ',
        'description' => 'A response sms response'
    ];

    public function fields(): array
    {
        return [

            'sms_id' => [
                'type' => new CustomScalarType([
                    'name' => 'sms_category_encrypted_id',
                    'serialize' => function ($value) {
                        $result = Crypt::encryptString($value);
                        return $result;
                    }
                ]),
                'alias' => 'fldSMSTransactionID',
            ],
            'original_sms_id' => [
                'type' => Type::string(),
                'alias' => 'fldSMSTransactionID',
            ],
            'message' => [
                'type' => Type::string(),
                'alias' => 'fldSMSTransactionMessage',
            ],
            'date_sent' => [
                'type' => Type::string(),
                'alias' => 'fldSMSTransactionDateSent',
            ],
            'status' => [
                'type' => Type::string(),
                'alias' => 'fldSMSTransactionStatus',
            ],
            'sender' => [
                'type' => GraphQL::type('admin_type'),
            ],
            'contact_ids' => [
                'type' => new CustomScalarType([
                    'name' => 'sms_decoded_contact_numbers',
                    'serialize' => function ($value) {
                        $decoded_value = json_decode($value);
                        return $decoded_value;
                    }
                ]),
                'alias' => 'fldSMSTransactionContactIDs',
            ],
            'metadata' => [
                'type' => new CustomScalarType([
                    'name' => 'sms_unserialize_api_response',
                    'serialize' => function ($value) {
                        $decoded_value = unserialize($value);
                        return $decoded_value;
                    }
                ]),
                'alias' => 'fldSMSTransactionMeta',
            ],

        ];
    }
}
