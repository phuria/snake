FROM php:5.6-cli

RUN apt update && apt install -y git libncursesw5-dev
RUN pecl install ncurses

RUN touch /usr/local/etc/php/conf.d/ncurses.ini
RUN echo "extension=ncurses.so" > /usr/local/etc/php/conf.d/ncurses.ini

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --quiet
RUN rm composer-setup.php
RUN mv composer.phar /usr/bin/composer
