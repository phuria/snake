# phuria/snake
Snake game written in PHP. Example of using an 
[ncurses extension](https://pecl.php.net/package/ncurses).

![Phuria snake game screen](https://github.com/phuria/snake/blob/master/doc/screen.png?raw=true)

# Installation 

1. Clone current repository

```bash
git clone git@github.com:phuria/snake.git
cd snake
```

2. Run docker compose in detached mode and get container's bash access

```bash
sudo docker-compose up -d
sudo docker exec -it phuria-snake bash 
```

3. Install composer dependencies and run snake!

```
cd snake
composer update
./run
```
