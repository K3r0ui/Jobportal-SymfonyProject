# Jobportal-SymfonyProject
# 1- Composer Install to install necessary dependencies 
# 2- "env.local" : copy evreything inside and paste inside ".env"
# 3- Run Powershell as Administrator : Paste this command "Set-ExecutionPolicy RemoteSigned" Then press A and Enter
# 4- To install webpack encore inside the project we can use NPM or Yarn :
#   yarn add @symfony/webpack-encore --dev
#   yarn add sass-loader node-sass --dev
# 5- .$ /node_modules/.bin/encore dev
# 6- Now lets install the fixtures for superadmin : 
#   php bin/console fixtures:load
# 7- symfony proxy:start to start un proxy
#   symfony proxy:domain:attach scoutsearch -> Http://scoutsearch.wip
#   we need to add onther configuration : Modify the proxy under Windows  & add the proxy address 127.0.0.1:7080/proxy.pac
#   & Enjoy
