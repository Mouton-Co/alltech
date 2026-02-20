<?php

return [
    'select' => [
        'a' => [
            'User' => ['users.id as id', 'users.name as column_1'],
            'Contact' => ['contacts.id as id', 'contacts.name as column_1'],
            'Company' => ['companies.id as id', 'companies.name as column_1'],
            'Region' => ['companies.region as column_1'],
            'Company Type' => ['company_types.id as id', 'company_types.name as column_1'],
        ],
        'b' => [
            'User' => ['users.id as id', 'users.name as column_2'],
            'Contact' => ['contacts.id as id', 'contacts.name as column_2'],
            'Company' => ['companies.id as id', 'companies.name as column_2'],
            'Region' => ['companies.region as column_2'],
            'Company Type' => ['company_types.id as id', 'company_types.name as column_2'],
        ],
        'count' => [
            'Number of meetings' => 'COUNT(meetings.id) as metric',
            'Number of unique contacts' => 'COUNT(DISTINCT meetings.contact_id) as metric',
            'Number of unique companies' => 'COUNT(DISTINCT companies.id) as metric',
        ],
    ],
    'group_by' => [
        'User' => ['users.id', 'users.name'],
        'Contact' => ['contacts.id', 'contacts.name'],
        'Company' => ['companies.id', 'companies.name'],
        'Region' => ['companies.region'],
        'Company Type' => ['company_types.id', 'company_types.name'],
    ],
];
