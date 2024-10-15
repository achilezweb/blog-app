#!/bin/sh

# app-zip-move.sh filename.zip

# this will zip filename and move to parent folder
# Recommended to run outside shell/ssh.


# create a zip from the main/laravel-app.zip
# clean the directory
# extract the folder/project.zip

filename=laravel-app.zip
allfolders=
allfiles=

if [ $1 ]
then
	filename=$1
fi

#list of all folders: exclude scripts/ settings/
allfolders="
app/
bootstrap/
config/
database/
docker/
node_modules/
public/
resources/
routes/
storage/
tests/
vendor/
.git/"

#list of all files: exclude docker-compose.yml app-zip-move.sh
allfiles="
README.md
artisan
composer.*
package*.*
phpunit.xml
postcss.config.js
tailwind.config.js
vite.config.js"

dotfiles="
.editorconfig
.env
.env.example
.gitattributes
.gitignore
"

echo "Note: Be sure to stop all the running containers"

echo "Removing existing zip file if exist: $filename"
rm $filename

echo "Zipping $filename: $allfolders $allfiles $dotfiles app-zip-move.sh"
zip -r $filename $allfolders $allfiles $dotfiles app-zip-move.sh

echo "Remove and clean the root directories..."
rm -rf $allfolders $allfiles $dotfiles

echo "Move the $filename to the parent directory"
mv $filename ..

echo "Remove app-zip-move.sh"
rm app-zip-move.sh

echo "Unzip the new app"
echo 'If site returns 500, you need to Restart the laravel.test-1 container by'
echo 'running ../scripts/app-container-restart.sh <laravel-app> file outside shell container to run docker'


#move project files to the oldfolder
# echo "Moving Directories: $allfolders $oldfolder"
# mv $allfolders $oldfolder

# echo "Moving Files: $allfiles $oldfolder"
# mv $allfiles $oldfolder

# echo "Moving Dot Files: $dotfiles $oldfolder"
# mv $dotfiles $oldfolder

echo "App $filename moved to parent directory"
