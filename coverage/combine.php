<?php
// Init the Composer autoloader
require realpath(dirname(__FILE__)) . '/../vendor/autoload.php';

use SebastianBergmann\CodeCoverage\Report\Html\Facade as HtmlReport;

foreach (array_slice($argv, 1) as $filename) {
    // See PHP_CodeCoverage_Report_PHP::process
    /**
     * @var \SebastianBergmann\CodeCoverage\CodeCoverage $cov
     */
    $cov = include $filename;

    if (isset($codeCoverage)) {
        //$codeCoverage->filter()->addFilesToWhitelist($cov->filter()->getWhitelist());
        $codeCoverage->merge($cov);
    } else {
        $codeCoverage = $cov;
    }
}

print "\nGenerating code coverage report in HTML format ...";

// Based on PHPUnit_TextUI_TestRunner::doRun
(new HtmlReport())->process($codeCoverage, 'combined');

print " done\n";
print "See coverage/index.html\n";