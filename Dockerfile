# Sets the foundation for the new container by specifying the base image that will be used as its starting point
FROM centos:centos7
# Installs two packages, httpd and php, using the yum package manager in a CentOS 7-based container
RUN yum -y install httpd && yum -y install php
# Copies the source files to the docker package from the "src" folder
COPY src /var/www/html
# Run this command to allow us to change the file
RUN chmod -R 777 /var/www/html
# Tells docker that our container will be connected on port 80 (http port)
EXPOSE 80
# Start HTTP server and tells it to run
ENTRYPOINT  [ "/usr/sbin/httpd", "-D", "FOREGROUND"] 