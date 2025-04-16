<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #E10600;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
        .data-row {
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nuevo Mensaje de Contacto</h1>
        </div>
        <div class="content">
            <p>Has recibido un nuevo mensaje desde el formulario de contacto de F1Collector:</p>
            
            <div class="data-row">
                <span class="label">Nombre:</span> {{ $datos['nombre'] }}
            </div>
            <div class="data-row">
                <span class="label">Email:</span> {{ $datos['email'] }}
            </div>
            <div class="data-row">
                <span class="label">Asunto:</span> {{ $datos['asunto'] }}
            </div>
            <div class="data-row">
                <span class="label">Mensaje:</span> 
                <p>{{ $datos['mensaje'] }}</p>
            </div>
        </div>
        <div class="footer">
            <p>Este mensaje fue enviado desde el formulario de contacto de F1Collector.</p>
        </div>
    </div>
</body>
</html>