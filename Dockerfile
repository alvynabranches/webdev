# FROM python:3.13

# # RUN apk install ffmpeg -y
# COPY requirements.txt requirements.txt
# RUN pip3 install -r requirements.txt
# COPY app.py app.py
# EXPOSE 8000

# CMD [ "uvicorn", "app:app", "--host", "0.0.0.0", "--port", "8000"]

FROM php:8.4.4-apache
WORKDIR /var/www/html
RUN apt-get update && apt-get install -y libmariadb-dev
RUN docker-php-ext-install mysqli
