import Estudiante from "./components/estudiante";
import "./App.css";

export default function App() {

 const estudiantes = [
  {id: 1, nombre: "Mel", carrera: "Repostería"},
  {id: 2, nombre: "Aglae", carrera: "Psicología"},
  {id: 3, nombre: "Amairani", carrera: "Sistemas"}
 ];

  return (
    <main className="contenedor">
      <h1> Listado de estudiantes </h1>
      <form>
        <input type="text" placeholder= "Escribe Nombre" />
        <input type="text" placeholder= "Escribe Carrera" />
        <button type="button"> Agregar </button>
      </form>

      <h2> Estudiantes Registrados </h2>
      <ul>
        {estudiantes.map((estudiante)=>(
            <Estudiante
            key={estudiante.id}
            estudiante={estudiante}
            />
          ))
        }
      </ul>

      <p> Total de estudiantes: {estudiantes.length} </p>
    </main>
  );
}