
# You can copy this Dockerfile.example to Dockerfile to add configuration
# or packages or anything else to your webimage
ARG BASE_IMAGE
FROM $BASE_IMAGE
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | sudo -E bash && \
    sudo apt install symfony-cli && \
    curl -LO https://phpmd.org/static/latest/phpmd.phar && \
    mv phpmd.phar /usr/local/bin/phpmd && \
    chmod +x /usr/local/bin/phpmd
