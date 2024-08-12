<?php

declare(strict_types=1);

// Define the path to the XML file
$filePath = pages_path . DS . 'tests' . DS . 'results.xml'; // تأكد من تحديث المسار إلى موقع ملف XML الخاص بك

// Check if the file exists
if (file_exists($filePath)) {
    // Read the XML file
    $xmlContent = file_get_contents($filePath);

    // Load the XML content
    $xml = simplexml_load_string($xmlContent);

    if ($xml === false) {
        return '<div class="container"><div class="alert alert-danger">Failed to parse XML.</div></div>';
    } else {
        // Start HTML output
        $html = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Test Results</title>
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
            <link rel="shortcut icon" href="/settings/icon" type="image/x-icon">
            <style>
                .card-no-errors { border-color: #28a745; }
                .card-errors { border-color: #dc3545; }
                .card-header { font-weight: bold; }
                .btn-custom { margin-left: 15px; }
            </style>
        </head>
        <body>
            <div class="container mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Test Results</h1>
                    <a href="http://api.hwai.com/run-tests" class="btn btn-primary btn-custom">Run Tests</a>
                </div>
                <div class="mt-4">';

        // Test Suites
        $html .= '<div class="mt-4">';
        foreach ($xml->testsuite as $suite) {
            // Determine the card class based on errors
            $cardClass = ((int)$suite['errors'] > 0 || (int)$suite['failures'] > 0) ? 'card-errors' : 'card-no-errors';

            $html .= '<div class="card mb-3 ' . $cardClass . '">
                <div class="card-header">
                    Test Suite: ' . htmlspecialchars((string) $suite['name']) . '
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Attribute</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>File</td><td>' . htmlspecialchars((string) $suite['file']) . '</td></tr>
                            <tr><td>Tests</td><td>' . htmlspecialchars((string) $suite['tests']) . '</td></tr>
                            <tr><td>Assertions</td><td>' . htmlspecialchars((string) $suite['assertions']) . '</td></tr>
                            <tr><td>Errors</td><td>' . htmlspecialchars((string) $suite['errors']) . '</td></tr>
                            <tr><td>Failures</td><td>' . htmlspecialchars((string) $suite['failures']) . '</td></tr>
                            <tr><td>Skipped</td><td>' . htmlspecialchars((string) $suite['skipped']) . '</td></tr>
                            <tr><td>Time</td><td>' . htmlspecialchars((string) $suite['time']) . ' seconds</td></tr>
                        </tbody>
                    </table>';

            // Test Cases
            $html .= '<h5>Test Cases:</h5>';
            foreach ($suite->testsuite as $subSuite) {
                foreach ($subSuite->testcase as $case) {
                    // Determine the card class based on errors
                    $caseCardClass = isset($case->failure) || isset($case->error) ? 'card-errors' : 'card-no-errors';

                    $html .= '<div class="card mb-2 ' . $caseCardClass . '">
                        <div class="card-header">
                            Test Case: ' . htmlspecialchars((string) $case['name']) . '
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Attribute</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>File</td><td>' . htmlspecialchars((string) $case['file']) . '</td></tr>
                                    <tr><td>Line</td><td>' . htmlspecialchars((string) $case['line']) . '</td></tr>
                                    <tr><td>Class</td><td>' . htmlspecialchars((string) $case['class']) . '</td></tr>
                                    <tr><td>Assertions</td><td>' . htmlspecialchars((string) $case['assertions']) . '</td></tr>
                                    <tr><td>Time</td><td>' . htmlspecialchars((string) $case['time']) . ' seconds</td></tr>';

                    // Check for failure
                    if (isset($case->failure)) {
                        $html .= '<tr><td>Failure</td><td>' . nl2br(htmlspecialchars((string) $case->failure)) . '</td></tr>';
                    }

                    // Check for error
                    if (isset($case->error)) {
                        $html .= '<tr><td>Error</td><td>' . nl2br(htmlspecialchars((string) $case->error)) . '</td></tr>';
                    }

                    $html .= '</tbody>
                            </table>
                        </div>
                    </div>';
                }
            }

            $html .= '</div>
            </div>';
        }

        $html .= '</div></div></body></html>';

        return $html;
    }
}
