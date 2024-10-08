<?php
// Conexión a la base de datos SQLite
$db = new PDO('sqlite:base_datos.sqlite');

// Obtener una frase aleatoria
$fraseAleatoria = '';
$resultado = $db->query("SELECT texto FROM frases ORDER BY RANDOM() LIMIT 1");
if ($resultado) {
    $fila = $resultado->fetch(PDO::FETCH_ASSOC);
    if ($fila) {
        $fraseAleatoria = $fila['texto'];
    } else {
        $fraseAleatoria = "No hay frases registradas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frase Aleatoria</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            text-align: center;
            padding: 20px;
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        #fraseAleatoria {
            font-size: 1.5em;
            margin: 20px 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        #fraseAleatoria p {
            margin: 0;
            font-style: italic;
        }

        button {
            padding: 10px 20px;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        button:hover {
            background-color: #218838;
        }

        @media only screen and (max-width: 600px) {
            h1 {
                font-size: 2em;
            }

            #fraseAleatoria {
                font-size: 1.2em;
            }

            button {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>

    <h1>Frase Aleatoria</h1>
    <div id="fraseAleatoria">
        <p>"<?php echo htmlspecialchars($fraseAleatoria); ?>"</p>
    </div>
    <a href="admin.php">
        <button>New</button>
    </a>

</body>
</html>
