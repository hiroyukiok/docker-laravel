FROM php:8.2-fpm
EXPOSE 5173

# PHP設定のコピー
COPY php.ini /usr/local/etc/php/

# 必要なパッケージのインストール
RUN apt update \
    && apt install -y zlib1g-dev mariadb-client vim libzip-dev \
    && docker-php-ext-install zip pdo_mysql \
    && apt install -y git \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apt install -y npm \
    && npm install n -g \
    && n stable \
    && apt install -y chromium \
    && apt-get install -y libgbm-dev libnss3 libatk-bridge2.0-0 \
    libxcomposite1 libxdamage1 libxrandr2 libxss1 libasound2 libpangocairo-1.0-0 \
    libpangoft2-1.0-0 libcups2 libxkbcommon0 fonts-ipafont-gothic --no-install-recommends \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install sockets
    
# Redisのインストール
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリと権限設定
WORKDIR /src
ADD . /src/storage
RUN chown -R www-data:www-data /src/storage