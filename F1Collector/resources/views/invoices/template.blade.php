<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura #{{ $order->id }}</title>
    <style>
        /* Configuración general y reinicio */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            background-color: #f5f5f5;
            padding: 10px;
        }
        
        /* Contenedor principal, más compacto */
        .container {
            max-width: 700px;
            margin: 0 auto;
            background-color: #fff;
            position: relative;
            border: 1px solid #ddd;
        }
        
        /* Esquinas decorativas con bordes rojos */
        .corner {
            position: absolute;
            width: 15px;
            height: 15px;
        }
        
        .corner-top-left {
            top: 0;
            left: 0;
            border-top: 2px solid #e10600;
            border-left: 2px solid #e10600;
        }
        
        .corner-top-right {
            top: 0;
            right: 0;
            border-top: 2px solid #e10600;
            border-right: 2px solid #e10600;
        }
        
        .corner-bottom-left {
            bottom: 0;
            left: 0;
            border-bottom: 2px solid #e10600;
            border-left: 2px solid #e10600;
        }
        
        .corner-bottom-right {
            bottom: 0;
            right: 0;
            border-bottom: 2px solid #e10600;
            border-right: 2px solid #e10600;
        }
        
        /* Encabezado y contenido principal */
        .content {
            padding: 20px;
        }
        
        /* Sección de logotipo y título */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        
        /* Logotipo */
        .logo {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        
        .logo-f1 {
            color: #e10600;
        }
        
        .tagline {
            font-size: 11px;
            color: #666;
            margin-top: 3px;
        }
        
        /* Línea roja debajo del logotipo */
        .red-line {
            width: 40px;
            height: 2px;
            background-color: #e10600;
            margin: 6px 0 8px 0;
        }
        
        /* Información de factura */
        .invoice-info {
            text-align: right;
        }
        
        .invoice-title {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            color: #222;
            margin-bottom: 5px;
        }
        
        .invoice-number {
            color: #e10600;
            font-weight: bold;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .invoice-date {
            font-size: 12px;
            color: #666;
            margin-top: 3px;
        }
        
        /* Sección de información */
        .info-box {
            margin-bottom: 20px;
            background-color: #f9f9f9;
            border: 1px solid #eee;
        }
        
        .info-row {
            padding: 15px;
        }
        
        .info-row:not(:last-child) {
            border-bottom: 1px solid #eee;
        }
        
        .section-title {
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            font-size: 13px;
            margin-bottom: 8px;
        }
        
        .info-content p {
            margin-bottom: 4px;
        }
        
        /* Estado de pago */
        .payment-status {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-paid {
            background-color: #e6f9ec;
            color: #00a651;
        }
        
        .status-pending {
            background-color: #fff8e6;
            color: #f39c12;
        }
        
        /* Detalles de método y estado */
        .payment-detail {
            margin-bottom: 6px;
        }
        
        .detail-label {
            display: inline-block;
            width: 80px;
            font-weight: bold;
        }
        
        /* Productos */
        .products-section {
            margin-bottom: 20px;
        }
        
        .products-title {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
            color: #333;
        }
        
        /* Tabla de productos */
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }
        
        .products-table th {
            background-color: #333;
            color: #fff;
            text-align: left;
            padding: 8px 10px;
            font-weight: normal;
        }
        
        .products-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
        }
        
        .products-table tr:last-child td {
            border-bottom: none;
        }
        
        .products-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .products-table tfoot {
            font-weight: bold;
        }
        
        .products-table tfoot td {
            padding-top: 10px;
            border-top: 2px solid #eee;
            border-bottom: none;
        }
        
        .text-right {
            text-align: right;
        }
        
        .grand-total {
            color: #e10600;
            font-size: 14px;
        }
        
        /* Pie de página */
        .footer {
            text-align: center;
            padding: 15px;
            border-top: 1px solid #eee;
            font-size: 10px;
            color: #777;
        }
        
        .footer-logo {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 12px;
        }
        
        .footer p {
            margin: 3px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Esquinas decorativas -->
        <div class="corner corner-top-left"></div>
        <div class="corner corner-top-right"></div>
        <div class="corner corner-bottom-left"></div>
        <div class="corner corner-bottom-right"></div>
        
        <div class="content">
            <!-- Encabezado con logo y título de factura -->
            <div class="header">
                <div class="logo-section">
                    <div class="logo">
                        <span class="logo-f1">F1</span>COLLECTOR
                    </div>
                    <div class="red-line"></div>
                    <div class="tagline">Tu fuente de coleccionables premium de Fórmula 1</div>
                </div>
                
                <div class="invoice-info">
                    <div class="invoice-title">FACTURA</div>
                    <div class="red-line" style="margin-left: auto;"></div>
                    <div class="invoice-number">#{{ $order->id }}</div>
                    <div class="invoice-date">Fecha: {{ $order->created_at->format('d/m/Y') }}</div>
                </div>
            </div>
            
            <!-- Información del cliente y pago -->
            <div class="info-box">
                <div class="info-row">
                    <div class="section-title">DATOS DE FACTURACIÓN</div>
                    <div class="red-line"></div>
                    <div class="info-content">
                        <p>{{ strtolower($order->full_name) }}</p>
                        <p>{{ strtolower($order->shipping_address) }}</p>
                        <p>{{ strtolower($order->shipping_city) }}, {{ strtolower($order->shipping_province) }} {{ $order->shipping_zip }}</p>
                        <p>Teléfono: {{ $order->shipping_phone }}</p>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="section-title">DETALLES DE PAGO</div>
                    <div class="red-line"></div>
                    <div class="info-content">
                        <div class="payment-detail">
                            <span class="detail-label">Método:</span> 
                            {{ ucfirst($order->payment_method) }}
                        </div>
                        <div class="payment-detail">
                            <span class="detail-label">Estado:</span> 
                            <span class="payment-status {{ $order->status == 'paid' ? 'status-paid' : 'status-pending' }}">
                                {{ strtoupper($order->status) }}
                            </span>
                        </div>
                        <div class="payment-detail">
                            <span class="detail-label">Fecha de pago:</span>
                            @php
                            use Carbon\Carbon;
                            @endphp
                            {{ $order->payment_date ? Carbon::parse($order->payment_date)->format('d/m/Y') : 'Pendiente' }}
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sección de productos -->
            <div class="products-section">
                <div class="products-title">PRODUCTOS ADQUIRIDOS</div>
                <div class="red-line"></div>
                
                <table class="products-table">
                    <thead>
                        <tr>
                            <th width="50%">Producto</th>
                            <th width="15%">Precio</th>
                            <th width="15%">Cantidad</th>
                            <th width="20%" class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td><strong>{{ $item->product->name }}</strong></td>
                            <td>€{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-right">€{{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right">Subtotal:</td>
                            <td class="text-right">€{{ number_format($order->total, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right">TOTAL:</td>
                            <td class="text-right grand-total">€{{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <!-- Pie de página -->
            <div class="footer">
                <div class="footer-logo">F1COLLECTOR</div>
                <div class="red-line" style="margin: 5px auto;"></div>
                <p>Gracias por tu compra. ¡Acelera tu pasión por la F1 con nuestros coleccionables!</p>
                <p>Para cualquier consulta, contáctanos en <strong>f1.collector12@gmail.com</strong></p>
                <p>© {{ date('Y') }} F1 Collector. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</body>
</html>