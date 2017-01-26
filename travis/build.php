<?php

if (PHP_VERSION_ID < 70000) {
    echo 'You must use PHP 7 (or higher) to run this script.';
    exit(7);
}

function info(string $message, int $prefix = 0)
{
    $tag = ['Info', 'Warning', 'Error'];
    if (!isset($tag[$prefix])) {
        $prefix = 0;
    }
    echo "\n[".$tag[$prefix].'] '.$message;
}

function do_command($command): bool
{
    if (!is_array($command)) {
        $command = [$command];
    }
    foreach ($command as $cmd) {
        exec($cmd, $output, $code);
        if ($code > 0) {
            return false;
        }
    }

    return true;
}

function get_base(string $string, bool $last = true): string
{
    $parts = explode('/', $string);

    return $last ? $parts[count($parts) - 1] : $parts[0];
}

function validEnv(string $var)
{
    if (!getenv($var) || getenv($var) === null || strlen(getenv($var)) < 1) {
        return;
    }

    return getenv($var);
}

if (getenv('TRAVIS_PULL_REQUEST') !== 'false') {
    info('Pull Request detected! Quitting...');
    exit(0);
}

// Mess with Build tags
$pluginInfo = yaml_parse_file('plugin.yml');
$name_tags = [
    'api'     => $pluginInfo['api'],
    'commit'  => validEnv('TRAVIS_COMMIT'),
    'number'  => validEnv('TRAVIS_BUILD_NUMBER'),
    'version' => $pluginInfo['version'],
];
$build_name = get_base(validEnv('BUILD_NAME') ?? validEnv('DEPLOY_REPO'));
foreach ($name_tags as $k => $v) {
    str_replace('%'.$k.'%', $v, $build_name);
}
if (substr($build_name, -5, 5) !== '.phar') {
    $build_name .= '.phar';
}

// Get back to workflow...
info('Preparing Build environment...');
if (!is_dir('build')) {
    mkdir('build');
}
// Move files to build
$files = ['resources', 'src', 'LICENSE', 'plugin.yml', 'README.md'];
foreach ($files as $k => $f) {
    if (is_dir($f) or file_exists($f)) {
        do_command("mv $f build/$f");
    } else {
        unset($files[$k]);
    }
}
// Download DevTools to build the PHAR
info('Downloading DevTools...');
if (!do_command('curl -sL https://github.com/PocketMine/DevTools/releases/download/v1.11.0/DevTools_v1.11.0.phar -o DevTools.phar')) {
    info("Couldn't download DevTools. Sorry...", 2);
    exit(1);
}
// Build...
info('Building PHAR...');
if (!do_command('php -dphar.readonly=0 DevTools.phar --make build --out '.$build_name) && !file_exists($build_name)) {
    info('Something went wrong while Building. Sorry! :(', 2);
    exit(1);
}
info('PHAR successfully built!');
