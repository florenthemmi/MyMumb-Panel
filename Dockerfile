FROM tutum/apache-php
MAINTAINER Florent Hemmi

RUN DEBIAN_FRONTEND=noninteractive apt-get update && \
	apt-get install -yq ice-translators php-zeroc-ice unzip wget && \
	rm -rf /var/lib/apt/lists/*

ADD https://github.com/florenthemmi/MyMumb-Panel/archive/master.zip /tmp/
ADD https://raw.githubusercontent.com/mumble-voip/mumble/master/src/murmur/Murmur.ice /tmp/

RUN rm -rf /app && \
	unzip -q /tmp/master.zip -d /tmp/ && \
	mv /tmp/MyMumb-Panel-master /app/ && \
	cd /app/inc/ && \
	slice2php -I/usr/share/Ice/slice /tmp/Murmur.ice && \
	rm -rf /tmp/master.zip /tmp/Murmur.ice

COPY mymumb-setup /opt/
RUN chmod +x /opt/mymumb-setup
RUN php5enmod IcePHP

CMD /opt/mymumb-setup
