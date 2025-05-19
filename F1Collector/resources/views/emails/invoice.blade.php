<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de compra</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            background-color: #f6f6f6;
            color: #333;
            margin: 0;
            padding: 40px 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            overflow: hidden;
            padding: 30px;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #c9082a; /* Rojo F1 */
            font-size: 22px;
            margin-bottom: 5px;
        }

        .section-title {
            margin-top: 30px;
            font-size: 16px;
            font-weight: bold;
            color: #222;
        }

        .details ul,
        .products ul {
            list-style: none;
            padding: 0;
        }

        .details li,
        .products li {
            margin-bottom: 8px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: #888;
        }

        .total {
            font-weight: bold;
            color: #c9082a;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Gracias por tu compra en F1 Collector</h1>
            <p>Tu pedido ha sido procesado correctamente. Aquí tienes el resumen:</p>
        </div>

        <div class="details">
            <p class="section-title">Detalles del pedido</p>
            <ul>
                <li><strong>Número de pedido:</strong> #{{ $order->id }}</li>
                <li><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</li>
                <li><strong>Total:</strong> <span class="total">€{{ number_format($order->total, 2) }}</span></li>
            </ul>
        </div>

        <div class="products">
            <p class="section-title">Productos</p>
            <ul>
                @foreach($order->items as $item)
                    <li>
                        {{ $item->product->name }} x {{ $item->quantity }} – 
                        €{{ number_format($item->price * $item->quantity, 2) }}
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="footer">
            <p>Atentamente,</p>
            <p>El equipo de F1 Collector</p>
        </div>
    </div>
</body>
</html>
