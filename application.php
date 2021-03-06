<?php

/**
 * Make sure dependencies have been installed, and load the autoloader.
 */
if (!file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    throw new \Exception('Uh oh, it looks like dependencies have not yet been installed with Composer. Please follow Please follow the installation instructions at https://github.com/modmore/Gitify/wiki/1.-Installation');
}
require dirname(__FILE__) . '/vendor/autoload.php';

/**
 * Ensure the timezone is set; otherwise you'll get a shit ton (that's a technical term) of errors.
 */
if (version_compare(phpversion(),'5.3.0') >= 0) {
    $tz = @ini_get('date.timezone');
    if (empty($tz)) {
        date_default_timezone_set(@date_default_timezone_get());
    }
}

/**
 * Specify the working directory, if it hasn't been set yet.
 */
if (!defined('GITIFY_WORKING_DIR')) {
    define ('GITIFY_WORKING_DIR', $cwd = getcwd() . DIRECTORY_SEPARATOR);
}

/**
 * Load all the commands and create the Gitify instance
 */
use modmore\Gitify\Gitify;
use modmore\Gitify\Command\BackupCommand;
use modmore\Gitify\Command\BuildCommand;
use modmore\Gitify\Command\ExtractCommand;
use modmore\Gitify\Command\InitCommand;
use modmore\Gitify\Command\InstallModxCommand;
use modmore\Gitify\Command\InstallPackageCommand;
use modmore\Gitify\Command\RestoreCommand;

$application = new Gitify('Gitify', '0.9.0');
$application->add(new InitCommand);
$application->add(new BuildCommand);
$application->add(new ExtractCommand);
$application->add(new InstallModxCommand);
$application->add(new InstallPackageCommand);
$application->add(new BackupCommand);
$application->add(new RestoreCommand);
/**
 * We return it so the CLI controller in /Gitify can run it, or for other integrations to
 * work with the Gitify api directly.
 */
return $application;
