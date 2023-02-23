#  Laravel  with Docker Compose

## Docker's command helpers
- Create images `docker-compose build`
- Up all containers `docker-compose up -d`
- Stop all containers `docker-compose down`
- Logs `docker-compose logs ***`
- Container console `docker-compose exec *** bash`

## Docker's command linux
- All images `docker image ls`
- Delete images `docker image rm ***`
- All running containers `docker ps / docker container ls`
- Stop container `docker stop ***`
- Run container `docker start ***`
- Restart container `docker restart ***`
- Stop All Containers `docker kill $(docker ps -q)`
- Restart all container `docker restart $(docker ps -q)`
- Container console `docker exec -ti *** bash` 

## Docker without sudo on linux
To create the docker group and add your user:
- Create the docker group (`sudo groupadd docker`)
- Add your user to the docker group. (`sudo usermod -aG docker $USER`)
- Log out and log back in so that your group membership is re-evaluated.

## Begin to develop
- Download zip docker and extract to work directory and rename for project name
- create /src
- git clone project to src folder

## Add all access to db user
-  go to sql
- `mysql -uroot -p`
- `GRANT ALL PRIVILEGES ON * . * TO 'dev'@'%';`
- `FLUSH PRIVILEGES;`

## Other
- Supervisor status `sudo supervisorctl status`
- Ports status `netstat -ltupan`
- Laravel echo server example settings `https://qiita.com/hiro_nr825/items/49cf9784298754bbc0a1`
