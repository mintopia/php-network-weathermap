FROM php:5-cli
MAINTAINER Jessica Smith <jess@mintopia.net>

WORKDIR /tmp

RUN \
  wget https://github.com/howardjones/network-weathermap/archive/version-0.98.tar.gz && \
  tar zxvf version-0.98.tar.gz && \
  rm -f version-0.98.tar.gz && \
  mkdir -p /opt/network-weathermap && \
  cp -r network-weathermap-version-0.98 /opt/bin/network-weathermap && /
  chmod +x /opt/network-weathermap/weathermap
  mkdir /config
  mkdir /output
  
COPY run.php /opt/weathermap.php
VOLUME /config /output
RUN /usr/bin/php /opt/weathermap.php
