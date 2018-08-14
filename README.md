
# Tic Tac Toe Game

## Setup Project 

### Option 1 with Docker (Recommanded)

#### Update required environment variables (if needed - optional)

> $ vim .env


#### Build your application

> $ sudo docker-compose up -d --build

Note: Give 5-10 minutes to setup your environment


#### Verify all containers (optional to verify)

> $ sudo docker ps


You also may verify from browsers via http://127.0.0.1:81/public/

APIs will be deployed here http://127.0.0.1:81/v2/

If you wants to change the location of API, you just need to update the API url inside src/public/assets/boardgame.js (Line 6)




## Other Required Things:


### List of containers and access

In this example, we are going to view a list of all containers then access workspace to see php

> $ sudo docker ps


#### Workspace Container
> $ sudo docker exec -i -t tic_tac_toe_workspace_1 /bin/bash


### Remove any specific container

#### Stopping all containers:
> $ sudo docker kill $(sudo docker ps -q)
or
> $ sudo docker kill tic_tac_toe_workspace_1

#### Removing containers:
> $ sudo docker rm -f tic_tac_toe_workspace_1
or 
> $ sudo docker rm $(sudo docker ps -a -q) #all

#### Removing all docker images
> $ sudo docker rmi $(sudo docker images -q)
or
> $ sudo docker rmi -f $(sudo docker images -q)


### Install Docker Composer (if not exists)

> $ sudo curl -L https://github.com/docker/compose/releases/download/1.21.2/docker-compose-$(uname -s)-$(uname -m) -o /usr/local/bin/docker-compose

> $ sudo chmod +x /usr/bin/docker-compose

> $ systemctl start docker

> $ systemctl status docker


Cheers !

