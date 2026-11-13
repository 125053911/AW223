
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen 2do P</title>
</head>
<body>
     <header>
        <h1> Control de Gastos Personales </h1>
    </header>
    <main>
        <section>
            <div> 
                <h2> Total Gastado </h2>
                <p id="total-gastado">0</p>
            </div>
        </section>

          <section>
            <div> 
                <h2> Gastos Pendientes </h2>
                <p id="gastos-pendientes">0</p>
            </div>
        </section>

         <section>
            <div> 
                <h2> Registrar Nuevo Gasto </h2>
                <form id="form-registrar-gasto">
                    <div>
                        <label for="concepto-gasto">Concepto:</label>
                        <input type="text" id="concepto-gasto" name="concepto-gasto" required>
                    </div>
                    <div>
                        <label for="monto-gasto">Monto:</label>
                        <input type="number" id="monto-gasto" name="monto-gasto" required>
                    </div>
                    <div>
                        <label for="categoria-gasto">Categoría:</label>
                        <input type="text" id="categoria-gasto" name="categoria-gasto" required>
                    </div>
                    <div>
                        <button href="./JS/AlertInsert.js" type="submit">Registrar Gasto</button>
                    </div>
                </form>
            </div>
        </section>

          <section>
            <div> 
                <h2> Listado de Gastos </h2>
            </div>
        </section>

      </main>

    <script src= "./JS/AlertInsert.js"> </script>
</body>
</html>
