[![Maintainability](https://api.codeclimate.com/v1/badges/8a8b4d505c1f7ecba52c/maintainability)](https://codeclimate.com/github/MaksymSemenykhin/linkShortener/maintainability)
# docker installation REQUIREMENTS
------------
  - Git
  - Docker 
  - Docker-compose
  - console or terminal
  - 512 Memory 
  
INSTALLATION
------------
1. Install [git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
2. Install docker [ubuntu](https://docs.docker.com/engine/install/ubuntu/) or [windows](https://docs.docker.com/engine/install/ubuntu/)
3. Install docker-compose [ubuntu](https://docs.docker.com/compose/install/#linux) or [windows](https://docs.docker.com/compose/install/#windows)
4. Copy .env-exmple as .env
5. Update .env config if its required
6. Start docker-compose
    * On Windows with wsl enabled ./start.sh or ./start-daemon.sh
    * On Ubuntu bash ./start.sh or bash ./start-daemon.sh
    * On Windows without wsl ./start.bat or ./start-daemon.bat
7. Composer install
8. yii init
9 yii migrate


```sh
$ git clone https://github.com/MaksymSemenykhin/linkShortener.git ./linkShortener
$ cd ./linkShortener
$ cp .env-exmple .env
$ bash ./start.sh or start-daemon.sh
docker exec -t php composer install
docker exec -t php init --env=Development --overwrite=All
docker exec -t php yii migrate --interactive=0
```
