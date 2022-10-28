from flask import Flask
from os import path


def create_app():
    app = Flask(__name__)
    app.config['SECRET_KEY'] = 'secret'

    from .auth import app as auth
    app.register_blueprint(auth, url_prefix='/')

    return app
