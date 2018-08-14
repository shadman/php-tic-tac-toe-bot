
# Tic Tac Toe Game


## Clone from Repository

> cd /var/www/html/

> git clone https://github.com/shadman/php-tic-tac-toe-bot.git



## Setup Project 

### Option 1 with Docker (Recommanded)

#### Update required environment variables (if needed - optional)

> vim .env


#### Build your application

> sudo docker-compose up -d --build

Note: Give 5-10 minutes to setup your environment


#### Verify all containers (optional to verify)

> sudo docker ps

#### Verify Game

- Now you may verify web from browsers by using http://127.0.0.1:81/public/index.php link.
- APIs will be deployed here http://127.0.0.1:81/v1/
- If you wants to deploy API separetely, you just need to update the API URL inside src/public/assets/boardgame.js (Line 6)



### Option 2 Simple (without containers)

#### Prerequisites

- PHP >= 7.1
- Nginx / Apache


#### Steps to Setup

- Copy complete project directory in your apache directory. ex: /var/www/html/php-tic-tac-toe-bot
- Your API URL will become like: http://localhost/php-tic-tac-toe-bot/src/v1
> You may test by using simple GET API call http://localhost/php-tic-tac-toe-bot/src/v1/matrix
- Update API URL inside web js file. ex: src/public/assets/boardgame.js (Line 6)
- Now you are ready to test your web by opening http://localhost/php-tic-tac-toe-bot/src/public/index.php



## API Documentation

### To get matrix size for game

Request URL: http://127.0.0.1:81/v1/matrix [GET]

Response: 
```
3
```

### To take move and get bot move

Request URL: http://127.0.0.1:81/v1/move [POST]

Request Body:
```
{
  "boardState":[["O","","X"],["","","O"],["","X",""]],
  "playerUnit": "X"
}
```

Response:
```
[1,1,"O"]
```



## Other Required Stuff For Docker:


### List of containers and access

In this example, we are going to view a list of all containers then access workspace to see php

> sudo docker ps


#### Workspace Container
> sudo docker exec -i -t tic_tac_toe_workspace_1 /bin/bash


### Remove any specific container

#### Stopping all containers:
> sudo docker kill $(sudo docker ps -q)
or
> sudo docker kill tic_tac_toe_workspace_1

#### Removing containers:
> sudo docker rm -f tic_tac_toe_workspace_1
or 
> sudo docker rm $(sudo docker ps -a -q) #all

#### Removing all docker images
> sudo docker rmi $(sudo docker images -q)
or
> sudo docker rmi -f $(sudo docker images -q)


### Install Docker Composer (if not exists)

> sudo curl -L https://github.com/docker/compose/releases/download/1.21.2/docker-compose-$(uname -s)-$(uname -m) -o /usr/local/bin/docker-compose

> sudo chmod +x /usr/bin/docker-compose

> systemctl start docker

> systemctl status docker


Cheers !

