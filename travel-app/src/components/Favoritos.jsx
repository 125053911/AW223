export default function Favoritos({ total }) {
  return (
    <section className="favoritos">
      <div>
        <h4>Destinos favoritos</h4>
        <p>Tu próxima aventura comienza aquí.</p>
      </div>
      <span className="contador">{total}</span>
    </section>
  );
}