<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public array $pagination_rule = [
        "limit" => "required|integer|min_length[1]|max_length[3]|greater_than[0]",  // limit bir tamsayı olmalı ve 1 ile 999 arasında bir değer olmalı
        "page"  => "required|integer|min_length[1]|max_length[3]|greater_than[0]"  // page de tamsayı olmalı ve 0'dan büyük olmalı
    ];
    public array $user_login = [
        "email" => "required|valid_email|min_length[5]|max_length[50]",
        "password" => "required|min_length[5]|max_length[20]",
    ];
    public array $user_register = [
        "username" => "required|is_unique[users.username]",
        "email" => "required|valid_email|is_unique[auth_identities.secret]|min_length[5]|max_length[50]",
        "password" => "required"
    ];
    public array $task_create_rules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'description' => 'required|min_length[3]',
        'status' => 'required|in_list[pending,in_progress,completed]'
    ];
    public array $task_delete_rules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'description' => 'required|min_length[3]',
        'status' => 'required|in_list[pending,in_progress,completed]'
    ];
    public array $friendship_request = [
      'friendship_id' => 'required|integer|min_length[1]|max_length[20]',
    ];
    public array $task_assign_rules = [
      'friend_id' => 'required|integer|min_length[1]|max_length[5]',
      'task_id' => 'required|integer|min_length[1]|max_length[5]',
    ];
    public array $queue_add_rules = [
        'email' => 'required|string|valid_email|min_length[5]|max_length[50]',
        'subject' => 'required|string|min_length[1]|max_length[40]',
        'message' => 'required|string|min_length[1]|max_length[255]',
    ];
}
