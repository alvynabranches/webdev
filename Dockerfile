FROM python:3.13

# RUN apk install ffmpeg -y
COPY requirements.txt requirements.txt
RUN pip3 install -r requirements.txt
COPY app.py app.py
EXPOSE 8000

CMD [ "uvicorn", "app:app", "--host", "0.0.0.0", "--port", "8000"]