<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #4A3728;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            font-size: 13px;
        }

        .container {
            width: 100%;
            /* max-width: 700px; */
            margin: 0 auto;
            /* padding: 30px 40px; */
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 1px solid #D4AF37;
            padding-bottom: 10px;
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
            color: #8B5E3C;
        }

        .logo span {
            color: #D4AF37;
        }

        .invoice-title {
            text-align: right;
            font-size: 20px;
            text-transform: uppercase;
            color: #8B5E3C;
            letter-spacing: 1px;
        }

        .info-section {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .info-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .label {
            font-size: 9px;
            text-transform: uppercase;
            color: #8B5E3C;
            font-weight: bold;
            margin-bottom: 2px;
            display: block;
        }

        .value {
            font-size: 12px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        table.items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.items-table th {
            background: #F8F4ED;
            text-align: left;
            padding: 8px;
            font-size: 10px;
            text-transform: uppercase;
            border-bottom: 1px solid #eee;
        }

        table.items-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
            font-size: 12px;
        }

        .total-row td {
            border-top: 2px solid #8B5E3C;
            font-weight: bold;
            font-size: 15px;
            color: #8B5E3C;
            text-align: right;
        }

        .footer-section {
            display: table;
            width: 100%;
            margin-top: 10px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .payment-info {
            display: table-cell;
            width: 60%;
            vertical-align: top;
            padding-right: 20px;
            background: #F8F4ED;
            padding: 15px;
            border-radius: 8px;
        }

        .qr-section {
            display: table-cell;
            width: 35%;
            vertical-align: top;
            text-align: center;
            padding-left: 20px;
        }

        .qr-code img {
            width: 90px;
            height: 90px;
        }

        .thanks {
            font-size: 14px;
            font-weight: bold;
            color: #D4AF37;
            margin-top: 15px;
        }

        .footer-note {
            font-size: 9px;
            color: #8B5E3C;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div style="display: table-cell; width: 50px; vertical-align: middle;">
                <img src="{{ public_path('logo_maryam.png') }}" width="40" height="40">
            </div>
            <div style="display: table-cell; vertical-align: middle; padding-left: 10px;">
                <div class="logo">Maryam <span>Cake</span></div>
                <div style="font-size: 10px; color: #6B4F3A; margin-top: 2px;">{{ __('Premium Handmade Treats') }}</div>
            </div>
            <div style="display: table-cell; width: 40%; text-align: right; vertical-align: middle;">
                <div class="invoice-title">{{ __('Invoice') }}</div>
                <div style="font-size: 10px; color: #8B5E3C;">{{ $order->order_number }}</div>
            </div>
        </div>

        <!-- Info Section -->
        <div class="info-section">
            <div class="info-col">
                <span class="label">{{ __('Billed To') }}</span>
                <div class="value">
                    {{ $order->customer_name }} <span
                        style="font-weight:normal; font-size:11px;">({{ $order->customer_phone }})</span><br>
                    <span style="font-weight: normal; font-size: 11px;">{{ $order->address }}</span>
                </div>
            </div>
            <div class="info-col" style="text-align: right;">
                <span class="label">{{ __('Date') }}</span>
                <div class="value">{{ $order->created_at->format('d M Y, H:i') }}</div>
                <span class="label">{{ __('Status') }}</span>
                <div class="value" style="text-transform: uppercase; font-size: 11px; color: #D4AF37;">
                    {{ __(ucfirst($order->status)) }}
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th width="50%">{{ __('Item') }}</th>
                    <th width="10%" style="text-align: center;">{{ __('Qty') }}</th>
                    <th width="20%" style="text-align: right;">{{ __('Price') }}</th>
                    <th width="20%" style="text-align: right;">{{ __('Total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            @php
                $subtotal = $order->items->sum(function ($item) {
                    return $item->price * $item->quantity;
                });
            @endphp
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right; border: none; padding-top: 10px; font-size: 11px;">
                        {{ __('Subtotal') }}</td>
                    <td style="text-align: right; border: none; padding-top: 10px; font-weight:bold;">Rp
                        {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                @if ($order->discount_amount > 0)
                    <tr>
                        <td colspan="3" style="text-align: right; border: none; color: #16a34a; font-size: 11px;">
                            {{ __('Voucher') }} ({{ $order->voucher_code }})
                        </td>
                        <td style="text-align: right; border: none; color: #16a34a;">
                            - Rp {{ number_format($order->discount_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                @endif
                @if ($order->admin_fee > 0)
                    <tr>
                        <td colspan="3" style="text-align: right; border: none; color: #8B5E3C; font-size: 11px;">
                            {{ __('Admin Fee') }} ({{ $order->payment_method_name }})
                        </td>
                        <td style="text-align: right; border: none; color: #8B5E3C;">
                            + Rp {{ number_format($order->admin_fee, 0, ',', '.') }}
                        </td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td colspan="3" style="border-top: 1px solid #8B5E3C; text-align: right; padding-top: 8px;">
                        {{ __('Total') }}</td>
                    <td style="border-top: 1px solid #8B5E3C; padding-top: 8px;">Rp
                        {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Footer Section (Side-by-Side) -->
        <div class="footer-section">
            <!-- Left: Payment Info -->
            <div class="payment-info">
                @if ($paymentMethod)
                    <span class="label" style="font-size: 8px; margin-bottom: 5px;">{{ __('Payment Method') }}</span>
                    <div style="font-size: 13px; font-weight: bold; color: #4A3728; margin-bottom: 5px;">
                        {{ $paymentMethod->name }}
                    </div>

                    @if ($paymentMethod->account_number)
                        <div style="font-size: 11px; margin-bottom: 2px;">
                            {{ $paymentMethod->account_name }}
                        </div>
                        <div style="font-size: 14px; font-weight: bold; color: #D4AF37; letter-spacing: 1px;">
                            {{ $paymentMethod->account_number }}
                        </div>
                    @endif

                    @if ($paymentMethod->instructions)
                        <div
                            style="font-size: 9px; margin-top: 8px; color: #6B4F3A; line-height: 1.3; border-top: 1px dashed #ccc; padding-top: 8px;">
                            {!! nl2br(e($paymentMethod->instructions)) !!}
                        </div>
                    @endif
                @else
                    <div style="font-size: 12px; font-style: italic; color: #999;">No payment info available</div>
                @endif
            </div>

            <!-- Right: QR and Thank You -->
            <div class="qr-section">
                <div class="qr-code">
                    <img src="data:image/png;base64, {!! base64_encode(
                        QrCode::format('png')->size(100)->margin(0)->generate(route('tracking.direct', $order->order_number)),
                    ) !!} ">
                </div>
                <div style="font-size: 8px; text-transform:uppercase; margin-top:5px; color:#8B5E3C;">
                    {{ __('Scan to Track') }}</div>

                <div class="thanks">{{ __('Thank You!') }}</div>
                <div class="footer-note">&copy; {{ date('Y') }} Maryam Cake</div>
            </div>
        </div>
    </div>
</body>

</html>
