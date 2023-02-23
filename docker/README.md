#  Laravel  with Docker Compose

## Docker's command helpers
- Створення імеджів `docker-compose build` (Робиться один раз для проекта. Якщо добавився або змінився контейнер - треба робили ребілд)
- Запуск контейнерів `docker-compose up -d`
- Зупинка контейнерів `docker-compose down`
- Перегляд логів `docker-compose logs ***`
- Консоль контейнера `docker-compose exec *** bash`

## Docker's command linux
- Всі образи `docker image ls`
- Видалити образ `docker image rm ***`
- Всі запущені контейнери `docker ps / docker container ls`
- Зупинити контейнер `docker stop ***`
- Запустити контейнер `docker start ***`
- Перезапустити контейнер `docker restart ***`
- Stop All Containers `docker kill $(docker ps -q)`
- Перезапустити  всі контейнери `docker restart $(docker ps -q)`
- Консоль контейнера `docker exec -ti pawomarket_php bash` 

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
-  Зайти в консоль sql
- `mysql -uroot -p`
- `GRANT ALL PRIVILEGES ON * . * TO 'dev'@'%';`
- `FLUSH PRIVILEGES;`

## Other
- Supervisor status `sudo supervisorctl status`
- Ports status `netstat -ltupan`
- Laravel echo server example settings `https://qiita.com/hiro_nr825/items/49cf9784298754bbc0a1`
