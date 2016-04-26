<?php

return [

    /*
     * Permission for role
     */
    'admin'       => [
        'create-user',
        'add-content',
        'manage-all-content',
        'manage-own-content'
    ],
    'editor'      => [
        'add-content',
        'manage-all-content',
        'manage-own-content'
    ],
    'contributor' => [
        'add-content',
        'manage-own-content'
    ],

    /*
     * Roles
     */
    'roles'       => [
        [
            'name'         => 'admin',
            'display_name' => 'Administrator',
            'description'  => 'User can do anything'
        ],
        [
            'name'         => 'editor',
            'display_name' => 'Editor',
            'description'  => 'User can manage the content'
        ],
        [
            'name'         => 'contributor',
            'display_name' => 'Contributor',
            'description'  => 'can add content and manage their own content'
        ]
    ],


    /*
     * Permissions
     */
    'permissions' => [
        [
            'name'         => 'create-user',
            'display_name' => 'Create Users',
            'description'  => 'Create a user'
        ],
        [
            'name'         => 'add-content',
            'display_name' => 'Add Content',
            'description'  => 'Add a content'
        ],
        [
            'name'         => 'manage-all-content',
            'display_name' => 'Manage All Content',
            'description'  => 'Manage all content'
        ],
        [
            'name'         => 'manage-own-content',
            'display_name' => 'Manage Own Content',
            'description'  => 'Manage content created by self'
        ]
    ],


];
