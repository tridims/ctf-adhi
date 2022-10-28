from flask import Blueprint, make_response, render_template, request, flash, redirect, url_for
from .models import User
import pickle
import base64
from markupsafe import escape

app = Blueprint('auth', __name__)


@app.route('/', methods=['GET', 'POST'])
def main_page():
    if request.method == "POST":
        email = escape(request.form.get('email'))
        password = escape(request.form.get('password'))

        flash('Sucessfully logged in!', category='success')

        user = User(email, password, 0)
        deserialized = base64.urlsafe_b64encode(pickle.dumps(user))

        resp = make_response(render_template('main.html', user=deserialized))
        resp.set_cookie('user', deserialized)
        return resp

    else:
        user = request.cookies.get('user')
        if (user):
            try:
                user = pickle.loads(base64.urlsafe_b64decode(user))
            except Exception as e:
                return render_template('main.html', user=None, error=e)
            flag = None
            if user.role != 0:
                from .theflag import flag as theflag
                flag = theflag

            return render_template('main.html', user=user, flag=flag)
        else:
            return redirect("/")


@app.route('/logout')
def logout():
    resp = make_response(render_template('index.html'))
    resp.set_cookie('user', '')
    return resp
