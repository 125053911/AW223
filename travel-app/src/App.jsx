import { useState } from "react";
import Viaje from "./components/Viaje";
import Favoritos from "./components/Favoritos";
import "./App.css";

const viajes = [
  {
    id: 1,
    nombre: "Cancún",
    pais: "México",
    precio: "$5,500 MXN",
    categoria: "Playa",
    imagen:
      "https://a.storyblok.com/f/285826016720786/1920x1080/dbb646fb1f/discover-cancun-villa-del-palmar-cancun.webp/m/1920x/filters:quality(90):format(webp)",
    descripcion:
      "Playas de arena blanca y mar turquesa en el Caribe mexicano, con zona hotelera, vida nocturna y cenotes cercanos.",
  },
  {
    id: 2,
    nombre: "París",
    pais: "Francia",
    precio: "$18,000 MXN",
    categoria: "Cultura",
    imagen:
      "https://cdn.sanity.io/images/mkg24y51/production/ee7855a8742aaa095c2fe5898324625b0dc989ed-1200x800.webp/viaje-paris.webp?w=1536&auto=format",
    descripcion:
      "La ciudad de la luz: Torre Eiffel, museos como el Louvre, cafés a orillas del Sena y una gastronomía inigualable.",
  },
];

function limpiar(texto) {
  return texto.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "");
}

export default function App() {
  const [busqueda, setBusqueda] = useState("");
  const [favoritos, setFavoritos] = useState([]);
  const [soloFavoritos, setSoloFavoritos] = useState(false);

  const cambiarFavorito = (id) => {
    setFavoritos((actuales) =>
      actuales.includes(id)
        ? actuales.filter((favId) => favId !== id)
        : [...actuales, id]
    );
  };

  const viajesVisibles = viajes.filter((viaje) => {
    const texto = limpiar(`${viaje.nombre} ${viaje.pais} ${viaje.categoria}`);
    const coincide = texto.includes(limpiar(busqueda.trim()));
    return coincide && (!soloFavoritos || favoritos.includes(viaje.id));
  });

  const mensajeVacio =
    soloFavoritos && favoritos.length === 0
      ? "Aún no tienes destinos favoritos."
      : "No se encontraron destinos con esa búsqueda.";

  return (
    <>
      <header className="navbar">
        <div className="navbar-interior">
          <h5>✈ TravelApp</h5>
          <nav>
            <a href="#inicio" onClick={() => setSoloFavoritos(false)}>
              Inicio
            </a>
            <a href="#destinos" onClick={() => setSoloFavoritos(false)}>
              Destinos
            </a>
            <a href="#destinos" onClick={() => setSoloFavoritos(true)}>
              Favoritos
            </a>
          </nav>
        </div>
      </header>

      <main className="contenedor" id="inicio">
        <section className="hero">
          <h1>Descubre tu próximo destino</h1>
          <p>Explora lugares increíbles y planea tus próximas vacaciones.</p>
        </section>

        <Favoritos total={favoritos.length} />

        <h2 id="destinos">Explora destinos turísticos</h2>

        <form onSubmit={(e) => e.preventDefault()}>
          <input
            type="text"
            placeholder="Buscar destino turístico..."
            value={busqueda}
            onChange={(e) => setBusqueda(e.target.value)}
          />
          <button type="button" onClick={() => setSoloFavoritos(!soloFavoritos)}>
            {soloFavoritos ? "Mostrar todos" : "Mostrar favoritos"}
          </button>
        </form>

        {viajesVisibles.length > 0 ? (
          <ul className="lista">
            {viajesVisibles.map((viaje) => (
              <Viaje
                key={viaje.id}
                viaje={viaje}
                esFavorito={favoritos.includes(viaje.id)}
                cambiarFavorito={cambiarFavorito}
              />
            ))}
          </ul>
        ) : (
          <p className="vacio">{mensajeVacio}</p>
        )}
      </main>
    </>
  );
}