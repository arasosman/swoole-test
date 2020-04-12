FROM zaherg/php-swoole:7.2

LABEL Maintainer="Zaher Ghaibeh <z@zah.me>"

ENV APP_ENV ${APP_ENV:-production}
ENV APP_DEBUG ${APP_DEBUG:-false}
ENV APP_TIMEZONE ${APP_TIMEZONE:-UTC}
ENV SWOOLE_HTTP_PORT ${SWOOLE_HTTP_PORT:-80}
ENV SWOOLE_HTTP_HOST ${SWOOLE_HTTP_HOST:-"0.0.0.0"}

USER root

ADD ./ /var/www

CMD ["php", "artisan","swoole:http","start"]
