# GitHub Repository Creator Script

This PHP script automates the process of creating a new repository on GitHub and uploading your project files to it.

## How It Works

1. **Authentication**: The script uses your GitHub username and personal access token for authentication.

2. **Repository Creation**: It creates a new public repository on GitHub with the specified name and description.

3. **File Upload**: It uploads the specified project files to the newly created repository. Binary files like images are base64 encoded.

## Usage

1. **Clone the repository** or create a new directory for the script.

2. **Configure the script**:
   - Replace `'your-username'` and `'your-github-token'` with your GitHub username and personal access token.
   - Adjust the file paths in the `$files` array to point to your project files.

3. **Run the script**:
   ```sh
   php upload_to_github.php
