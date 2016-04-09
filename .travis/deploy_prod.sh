eval "$(ssh-agent -s)" # start the ssh agent
openssl aes-256-cbc -K $encrypted_0ef3f9b81201_key -iv $encrypted_0ef3f9b81201_iv -in .travis/piggypennies.pem.enc -out .travis/piggypennies.pem -d
chmod 600 .travis/piggypennies.pem # this key should have push access
ssh-add .travis/piggypennies.pem
git remote add deploy dokku@aws-cloud.oweb.co:piggy
git push --force deploy master:master
