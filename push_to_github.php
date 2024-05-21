<?php

// GitHub repository details
$username = 'your-username';
$repository = 'your-repository';
$branch = 'main'; // or 'master' for older repositories

// Path to your project directory
$projectDir = '/path/to/your/project';

// Commit message
$commitMessage = 'Update project files';

// Change directory to the project directory
chdir($projectDir);

// Add all files to the staging area
shell_exec('git add .');

// Commit changes
shell_exec("git commit -m '$commitMessage'");

// Push changes to the remote repository
$output = shell_exec("git push origin $branch 2>&1");

echo $output;

?>
