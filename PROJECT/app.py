from flask import Flask, render_template, request
from flask_sqlalchemy import SQLAlchemy

app = Flask(__name__)
app.config["SQLALCHEMY_DATABASE_URI"] = 'mysql+pymysql://root:@localhost/instauser'  # Updated URI
db = SQLAlchemy(app)

class Users(db.Model):
    username = db.Column(db.String(40), primary_key=True, unique=True, nullable=False)
    password = db.Column(db.String(50), nullable=False)

@app.route("/", methods=['GET', 'POST'])
def Home():
    return render_template('index.html')

@app.route("/users", methods=['POST'])
def users():
    if request.method == 'POST':
        # add entry to database
        username = request.form.get('username')
        password = request.form.get('password')
        entry = Users(username=username, password=password)
        db.session.add(entry)
        db.session.commit()
    return render_template('index.html')

if __name__ == "__main__":
    app.run(debug=True)
