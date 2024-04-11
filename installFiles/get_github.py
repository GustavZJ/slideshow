from github import Github
import requests
import json
import os

# Access GitHub API using your personal access token
git = Github('')

# Dictionary containing GitHub repository information and corresponding local directories
repositories = {
    'slideshow': {'owner': 'GustavZJ', 'downloadDir': '/var/www/slideshow/'}
}

# Path for installed version tag file
tagPath = ''

# Load downloaded version tags
if tagPath != '':
    try:
        with open(tagPath, 'r') as tagFile:
            tagData = json.load(tagFile)
        tagFile.close()
    # Create tag file if it dosen't exist
    except FileNotFoundError as err:
        with open(tagPath, 'w') as tagFile:
            json.dump({}, tagFile)
            tagData = json.load(tagFile)
        tagFile.close()

def saveLatestTag(repoName, latestTag):
    # Save the latest downloaded tag to a JSON file
    with open(tagPath, 'w') as tagFile:
        tagData.update({repoName: latestTag})
        json.dump(tagData, tagFile)
    tagFile.close()

def check_for_new_release(repoName, owner, downloadDir):
    # Get repository
    repoPath = f'{owner}/{repoName}'
    repo = git.get_repo(repoPath)

    try:
        # Get latest release
        latestRelease = repo.get_latestRelease()

        # Get latest release tag name
        latestTag = latestRelease.tag_name

        # Check if the latest release is newer than the last downloaded tag
        if not repoName in tagData or latestTag != tagData[repoName]:
            # Download latest release
            downloadURL = latestRelease.zipball_url
            downloadPath = f'{downloadDir}/{latestTag}.zip'
            response = requests.get(downloadURL)
            with open(downloadPath, 'wb') as file:
                file.write(response.content)
            print(f'New release {latestTag} of {repoName} downloaded.')
            # Save the latest downloaded tag
            saveLatestTag(repoName, latestTag)
        else:
            print(f'Already have the latest release of {repoName} ({latestTag}).')
    except Exception:
        print(f'Error occurred while checking or downloading {repoName} (Most likely, no release exists).')

if __name__ == "__main__":
    for repoName, info in repositories.items():
        print(repoName, info)
        check_for_new_release(repoName, info['owner'], info['downloadDir'])