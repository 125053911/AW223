import { useState } from "react";

export default function Viaje({ viaje, esFavorito, cambiarFavorito }) {
  const [verDetalles, setVerDetalles] = useState(false);

  return (
    <li className="tarjeta">
      <div className="foto">
        <img src={viaje.imagen} alt={viaje.nombre} />
      </div>

      <div className="info">
        <span className="etiqueta">{viaje.categoria}</span>
        <h3>{viaje.nombre}</h3>
        <p className="pais">📍 {viaje.pais}</p>
        <p className="precio">Desde {viaje.precio}</p>

        {verDetalles && <p className="descripcion">{viaje.descripcion}</p>}

        <div className="botones">
          <button
            type="button"
            className={esFavorito ? "boton-claro activo" : "boton-claro"}
            onClick={() => cambiarFavorito(viaje.id)}
          >
            {esFavorito ? "♥ Quitar favorito" : "♡ Agregar favorito"}
          </button>
          <button type="button" onClick={() => setVerDetalles(!verDetalles)}>
            {verDetalles ? "Ocultar detalles" : "Ver detalles"}
          </button>
        </div>
      </div>
    </li>
  );
}