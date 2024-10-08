<?php
// Conexión a la base de datos SQLite
$db = new PDO('sqlite:base_datos.sqlite');

// Crear la tabla si no existe
$db->exec("CREATE TABLE IF NOT EXISTS frases (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    texto TEXT NOT NULL
)");

// Procesar el formulario de agregar nueva frase
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nuevaFrase'])) {
        $nuevaFrase = trim($_POST['nuevaFrase']);
        if ($nuevaFrase != '') {
            // Insertar nueva frase
            $stmt = $db->prepare("INSERT INTO frases (texto) VALUES (:texto)");
            $stmt->bindParam(':texto', $nuevaFrase, PDO::PARAM_STR);
            $stmt->execute();
        }
    } elseif (isset($_POST['editarFrase'])) {
        // Editar frase existente
        $id = $_POST['id'];
        $textoActualizado = trim($_POST['textoActualizado']);
        if ($textoActualizado != '') {
            $stmt = $db->prepare("UPDATE frases SET texto = :texto WHERE id = :id");
            $stmt->bindParam(':texto', $textoActualizado, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
    } elseif (isset($_POST['eliminarFrase'])) {
        // Eliminar frase existente
        $id = $_POST['id'];
        $stmt = $db->prepare("DELETE FROM frases WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

// Obtener todas las frases
$resultado = $db->query("SELECT * FROM frases");
$frases = $resultado ? $resultado->fetchAll(PDO::FETCH_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Frases</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f8fa;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #333;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 90%;
            max-width: 400px;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-right: 10px;
        }
        button:last-child {
            margin-right: 0;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        td button {
            background-color: #28a745;
        }
        td button:last-child {
            background-color: #dc3545;
        }
        td .acciones {
            display: flex;
            justify-content: space-around;
        }
        a {
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 20px;
        }
        @media only screen and (max-width: 600px) {
            table, input[type="text"] {
                width: 100%;
            }
            td .acciones {
                flex-direction: column;
            }
            td .acciones button {
                margin-bottom: 10px;
            }
            td .acciones button:last-child {
                margin-bottom: 0;
            }
        }
    </style>
</head>
<body>

    <h1>Administrar Frases</h1>

    <!-- Formulario para añadir nuevas frases -->
    <form action="admin.php" method="post">
        <input type="text" name="nuevaFrase" placeholder="Escribe una nueva frase" required>
        <button type="submit">Añadir Frase</button>
    </form>

    <h2>Frases Registradas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Frase</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($frases as $frase): ?>
                <tr>
                    <td><?php echo $frase['id']; ?></td>
                    <td>
                        <!-- Formulario para editar frase -->
                        <form action="admin.php" method="post">
                            <input type="text" name="textoActualizado" value="<?php echo htmlspecialchars($frase['texto']); ?>" required>
                            <input type="hidden" name="id" value="<?php echo $frase['id']; ?>">
                    </td>
                    <td>
                        <div class="acciones">
                            <button type="submit" name="editarFrase">Editar</button>
                        </form>
                            <!-- Formulario para eliminar frase -->
                            <form action="admin.php" method="post" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta frase?');">
                                <input type="hidden" name="id" value="<?php echo $frase['id']; ?>">
                                <button type="submit" name="eliminarFrase">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php">
        <button>Volver a Frase Aleatoria</button>
    </a>

</body>
</html>
