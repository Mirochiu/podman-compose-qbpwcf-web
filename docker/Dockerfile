#建立新的image
#podman build -t qbpwcf:20221002 -f docker/Dockerfile .
#建立containrer並跑在8800,44300起來
#podman run -itd -v ./public:/var/www/html -p 8800:80 -p 44300:443 --name=qbpwcf-cnr qbpwcf
#進入container
#podman exec -it qbpwcf-cnr /usr/bin/bash

#強制移除container
#podman rm -f qbpwcf-cnr

#存取網站
#curl http://localhost:8800/
#curl https://localhost:44300/

#存取httpd log
#podman logs qbpwcf-cnr

FROM fedora:36

RUN yum -y update
RUN yum -y install zstd unzip httpd openssh-clients php php-mbstring php-mcrypt php-mysqlnd php-soap php-json php-xml mod_ssl
RUN yum clean all

#QBPWCF的來源檔案名
#須先download
#https://sourceforge.net/projects/qbpwc/
ENV QBPWCF_FILE=qbpwcf-alpha-20221002-2.tar.zst
#QBPWCF解開壓縮後的資料夾名稱
ENV QBPWCF_FOLDER_NAME=20221002
#安裝QBPWCF套件
WORKDIR /usr/lib/
COPY $QBPWCF_FILE ./
RUN tar -I zstd -xvf $QBPWCF_FILE
RUN ln -s $QBPWCF_FOLDER_NAME trunk && ln -s trunk/qbpwcf
RUN ln -s qbpwcf/usr/bin/parse && ln -s qbpwcf/usr/bin/commit && ln -s qbpwcf/usr/bin/diff.php
RUN cp qbpwcf/usr/local/etc/qbpwcf.conf.xml /usr/local/etc/qbpwcf.conf.xml

RUN mkdir -p /usr/share/php
RUN ln -s /usr/lib/qbpwcf /usr/share/php/qbpwcf

#安裝QBPWCF相依套件TCPDF
#須先download
#wget -O TCPDF-main.zip https://github.com/tecnickcom/TCPDF/archive/main.zip
#QBPWCF新版本的來源檔案名
ENV TCPDF_FILE=TCPDF-main.zip
#QBPWCF新版本解開壓縮後的資料夾名稱
ENV TCPDF_FOLDER_NAME=TCPDF-main
COPY $TCPDF_FILE ./
RUN unzip $TCPDF_FILE && mv $TCPDF_FOLDER_NAME /usr/share/php/tcpdf && chmod -R 755 /usr/share/php/tcpdf

#清除暫存
RUN rm -rf /run/httpd/* /tmp/httpd*

#用以解決FPM initialization failed
RUN mkdir -p /var/run/php-fpm/

#拷貝php設定
COPY ./configs/php.ini /etc/php.ini
COPY ./configs/php.conf /etc/httpd/conf.d/php.conf
#podman cp qbpwcf-cnr:/etc/php.ini configs/
#podman cp qbpwcf-cnr:/etc/httpd/conf.d/php.conf configs/

#拷貝SSL憑證
#需先安裝mkcert並進入certs目錄執行gencerts.sh
COPY ./configs/ssl.conf /etc/httpd/conf.d/ssl.conf
COPY ./certs/apache-ssl-key.pem /etc/pki/tls/private/localhost.key
COPY ./certs/apache-ssl.crt /etc/pki/tls/certs/localhost.crt
#podman cp qbpwcf-cnr:/etc/httpd/conf.d/ssl.conf configs/
#localhost.key和localhost.crt原本不存在

#拷貝httpd設定
COPY ./configs/httpd.conf /etc/httpd/conf/httpd.conf
#podman cp qbpwcf-cnr:/etc/httpd/conf/httpd.conf configs/

EXPOSE 80
EXPOSE 443

#啟動php-fpm與httpd
ENTRYPOINT /usr/sbin/php-fpm && /usr/sbin/httpd -D FOREGROUND

#切換預設工作目錄
WORKDIR /var/www/html
