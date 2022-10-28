FROM python:3.11
ADD . /code
WORKDIR /code
RUN python -m pip install -r requirements.txt
EXPOSE 5000
CMD python app.py