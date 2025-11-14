<?php

// Bootstrap file for PHPUnit tests
// This file sets up the test environment

// Define constants that would normally be defined by MyBB
if (!defined('TIME_NOW')) {
    define('TIME_NOW', time());
}

if (!defined('IN_MYBB')) {
    define('IN_MYBB', 1);
}

if (!defined('MYBB_ROOT')) {
    define('MYBB_ROOT', __DIR__ . '/../');
}

// Initialize global variables that MyBB would normally provide
global $mybb, $lang, $db, $session, $templates, $cache;

// Mock MyBB object
if (!isset($mybb)) {
    $mybb = new stdClass();
    $mybb->settings = [
        'bburl' => 'https://example.com/forum',
        'bbname' => 'Test Forum',
        'dateformat' => 'Y-m-d',
    ];
    $mybb->user = [
        'uid' => 1,
        'username' => 'testuser',
        'email' => 'test@example.com',
        'has_my2fa' => 0,
    ];
    $mybb->cookies = [];
    $mybb->input = [];
}

// Mock language object
if (!isset($lang)) {
    $lang = new stdClass();
}

// Mock session object
if (!isset($session)) {
    $session = new stdClass();
    $session->sid = 'test_session_id';
    $session->uid = 1;
}

// Mock templates object
if (!isset($templates)) {
    $templates = new class {
        public function get($name) {
            return "Mock template: {$name}";
        }
    };
}

// Mock cache object
if (!isset($cache)) {
    $cache = new class {
        public function read($name) {
            return [];
        }
        public function update_default_theme() {
            return true;
        }
    };
}

// Mock database object (minimal implementation)
if (!isset($db)) {
    $db = new class {
        public function escape_string($string) {
            return addslashes($string);
        }
        
        public function simple_select($table, $fields, $where = '', $options = []) {
            return new class {
                public function fetch_field($name) {
                    return null;
                }
                public function fetch_array() {
                    return false;
                }
            };
        }
        
        public function fetch_field($query, $field) {
            return null;
        }
        
        public function insert_query($table, $data) {
            return true;
        }
        
        public function update_query($table, $data, $where) {
            return true;
        }
        
        public function delete_query($table, $where) {
            return true;
        }
    };
}

// Helper functions that MyBB would provide
if (!function_exists('my_mail')) {
    function my_mail($to, $subject, $message) {
        return true;
    }
}

if (!function_exists('my_rand')) {
    function my_rand($min, $max) {
        return rand($min, $max);
    }
}

if (!function_exists('htmlspecialchars_uni')) {
    function htmlspecialchars_uni($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('my_date')) {
    function my_date($format, $timestamp) {
        return date($format, $timestamp);
    }
}

if (!function_exists('inline_error')) {
    function inline_error($errors) {
        return '<div class="error">' . implode('<br>', (array)$errors) . '</div>';
    }
}

if (!function_exists('redirect')) {
    function redirect($url, $message = '') {
        // Mock redirect - don't actually redirect in tests
        return;
    }
}

if (!function_exists('verify_post_check')) {
    function verify_post_check($key) {
        return true;
    }
}

if (!function_exists('is_member')) {
    function is_member($groups, $userId = 0) {
        return false;
    }
}

if (!function_exists('random_str')) {
    function random_str($length = 32) {
        return bin2hex(random_bytes($length / 2));
    }
}
