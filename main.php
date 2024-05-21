<?php

// GitHub username and personal access token
$username = 'your-username';
$token = 'your-github-token';

// Repository details
$repoName = 'chrome-extension-bg-color';
$repoDescription = 'A Chrome extension to change the background color of any webpage.';

// Project files to upload
$files = [
    'manifest.json' => file_get_contents('path/to/manifest.json'),
    'background.js' => file_get_contents('path/to/background.js'),
    'popup.html' => file_get_contents('path/to/popup.html'),
    'popup.js' => file_get_contents('path/to/popup.js'),
    'icon.png' => base64_encode(file_get_contents('path/to/icon.png'))
];

// Function to call GitHub API
function callGitHubApi($url, $method = 'GET', $data = null) {
    global $username, $token;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$token");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/vnd.github.v3+json',
        'User-Agent: PHP Script'
    ]);

    if ($method == 'POST') {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    } elseif ($method == 'PUT') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    return json_decode($result, true);
}

// Step 1: Create a new repository
$createRepoUrl = 'https://api.github.com/user/repos';
$repoData = [
    'name' => $repoName,
    'description' => $repoDescription,
    'private' => false
];

$response = callGitHubApi($createRepoUrl, 'POST', $repoData);
if (isset($response['id'])) {
    echo "Repository created successfully.\n";
} else {
    echo "Failed to create repository: " . $response['message'] . "\n";
    exit;
}

// Step 2: Upload files to the repository
$uploadUrl = "https://api.github.com/repos/$username/$repoName/contents/";

foreach ($files as $filePath => $content) {
    $fileData = [
        'message' => "Adding $filePath",
        'content' => base64_encode($content)
    ];

    $response = callGitHubApi($uploadUrl . $filePath, 'PUT', $fileData);
    if (isset($response['content'])) {
        echo "$filePath uploaded successfully.\n";
    } else {
        echo "Failed to upload $filePath: " . $response['message'] . "\n";
    }
}

?>
