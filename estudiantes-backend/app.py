from flask import Flask
from config import config
from flask_mysqldb import MySQL

mysql= MySQL()

def create_app():
    from controllers.controladorAlumno import controladorAlumnoBP
    app= Flask(__name__)
    app.config.from_object(config)
    mysql.init_app(app)
    app.register_blueprint(controladorAlumnoBP)
    return app

if __name__ == '__main__' :
    app= create_app()
    app.run(port=5000,debug=True)