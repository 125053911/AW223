from flask import Blueprint,request, jsonify
from Models.modelEstudiante import *

controladorAlumnoBP= Blueprint('controladorAlumno',__name__)

# ruta para arranque del servidor
@controladorAlumnoBP.route('/')
def inicio():
    return "Hola, soy el backend de Alumno."

# ruta para insert
@controladorAlumnoBP.route('/guardarAlumno' ,methods=['POST'])
def guardar():
    nombreReq=request.form.get('txtNombre','').strip()
    carreraReq=request.form.get('txtCarrera','').strip()

    try:
        insertEstudiante(nombreReq,carreraReq)
        return jsonify({"Completado":"estudiante guardado"}),200

    except Exception as e:
        return jsonify({"Error": str(e)}),500


# Ruta para consultar alumnos
@controladorAlumnoBP.route('/consultarAlumnos', methods=['GET'])
def consultaAll():
    try:
        alumnos = selectAll()
        return  jsonify(alumnos) ,200;

    except Exception as e:
        print(f"Error: {e}")
        return jsonify({"Error": str(e)}),500

# Ruta para consultar un alumno por id
@controladorAlumnoBP.route('/consultarAlumno/<int:id>', methods=['GET'])
def consultaById(id):
    try:
        alumno = selectById(id)
        if alumno is None:
            return jsonify({"Error":"Alumno no encontrado"}),404
        return jsonify(alumno),200

    except Exception as e:
        return jsonify({"Error": str(e)}),500

# Ruta para actualizar un alumno
@controladorAlumnoBP.route('/actualizarAlumno', methods=['PUT'])
def actualizar():
    id = request.form.get('id', '').strip()
    nombreReq=request.form.get('txtNombre','').strip()
    carreraReq=request.form.get('txtCarrera','').strip()

    try:
        updateEstudiante(id,nombreReq,carreraReq)
        return jsonify({"Completado":"Alumno actualizado"}),200

    except Exception as e:
        return jsonify({"Error": str(e)}),500

 # Ruta para eliminar un alumno
@controladorAlumnoBP.route('/eliminarAlumno', methods=['PUT'])
def borrar():
    id = request.form.get('id', '').strip()

    try:
        softDeleteEstudiante(id)
        return jsonify({"Completado":"Alumno Borrado"}),200

    except Exception as e:
        return jsonify({"Error": str(e)}),500