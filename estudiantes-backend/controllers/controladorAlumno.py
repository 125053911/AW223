from flask import Blueprint

controladorAlumnoBP= Blueprint('controladorAlumno', __name__)

# Ruta para que arranque el servidor
@controladorAlumnoBP.route('/')
def inicio():
    return "Hola, soy el bakcend de Alumno."

# Ruta para insertar un nuevo alumno
@controladorAlumnoBP.route('/guardarAlumno', methods=['POST'])
def guardar():
    return 'Se guardó el alumno.'

# Ruta para consulta todo
@controladorAlumnoBP.route('/consultaTodo')
def consultatodo():
    return 'Se consultó todo.'

# Ruta para actualizar
@controladorAlumnoBP.route('/actualizarAlumno', methods=['PUT'])
def actualizar():
    return 'Se actualizó el alumno.'

# Ruta para eliminar 
@controladorAlumnoBP.route('/eliminarAlumno', methods=['DELETE'])
def eliminar():
    return 'Se eliminó el alumno.'