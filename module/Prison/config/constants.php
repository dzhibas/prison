<?php

$PLATFORM_LIST = array(
    'csharp',
    'connect',
    'django',
    'express',
    'flask',
    'ios',
    'java',
    'java_log4j',
    'java_log4j2',
    'java_logback',
    'java_logging',
    'javascript',
    'node.js',
    'php',
    'python',
    'r',
    'ruby',
    'rails3',
    'rails4',
    'sidekiq',
    'sinatra',
    'tornado',
);

$PLATFORM_ROOTS = array(
    'rails3' => 'ruby',
    'rails4' => 'ruby',
    'sinatra' => 'ruby',
    'sidekiq' => 'ruby',
    'django' => 'python',
    'flask' => 'python',
    'tornado' => 'python',
    'express' => 'node.js',
    'connect' => 'node.js',
    'java_log4j' => 'java',
    'java_log4j2' => 'java',
    'java_logback' => 'java',
    'java_logging' => 'java',
);

$PLATFORM_TITLES = array(
    'rails3' => 'Rails 3 (Ruby)',
    'rails4' => 'Rails 4 (Ruby)',
    'php' => 'PHP',
    'ios' => 'iOS',
    'express' => 'Express (Node.js)',
    'connect' => 'Connect (Node.js)',
    'django' => 'Django (Python)',
    'flask' => 'Flask (Python)',
    'csharp' => 'C#',
    'java_log4j' => 'Log4j (Java)',
    'java_log4j2' => 'Log4j 2.x (Java)',
    'java_logback' => 'Logback (Java)',
    'java_logging' => 'java.util.logging',
);

$RESERVED_TEAM_SLUGS = array(
    'admin', 'manage', 'login', 'account', 'register', 'api',
);

define("MEMBER_OWNER", 0);
define("MEMBER_USER", 50);
define("MEMBER_SYSTEM", 100);

$MEMBER_TYPES = array(
    MEMBER_OWNER => 'Admin',
    MEMBER_USER => 'User',
    MEMBER_SYSTEM => 'System Agent',
);