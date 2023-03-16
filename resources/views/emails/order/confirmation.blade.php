<div style="background-color:#f8f8f8;margin:0;padding:0">
    <table cellpadding="0" cellspacing="0" height="100%" width="100%">
      <tbody>
        <tr>
          <td align="center" style="padding-top:2px;padding-left:0;padding-right:0;min-width:600px" valign="top">
          <center>
          <table cellpadding="0" cellspacing="0" width="600">
            <tbody>
              <tr>
                <td style="padding-top:20px;padding-bottom:22px;float:left" valign="top"><img src="{{ $message->embed('images/asd-removebg-preview.png') }}" alt="" style="margin:0;display:block;height:30px;"></td>
                <td><h1 style="font-size: 20px;color: #333;margin-bottom: 5px;">LapXuongStore</h1></td>
              </tr>
            </tbody>
          </table>
  
          <hr align="center" color="#E7E7E7" size="1px" width="600">
          <table cellpadding="0" cellspacing="0" width="100%">
            <tbody>
              <tr>
                <td align="center" style="padding-left:10px;padding-right:10px" valign="top">
                <table cellpadding="0" cellspacing="0" width="600">
                  <tbody>
                    <tr>
                      <td>
                      <table cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                          <tr>
                            <td align="left" style="padding:30px 0;padding-top:25px;padding-bottom:15px;font-size:16px;line-height:25px;color:#565a5c;font-weight:normal;font-family:Helvetica Neue,Helvetica,Arial,sans-serif" valign="top">
                            <p style="margin-top:5px;margin-bottom:12px;font-weight:bold;font-size:20px">Hi {{ $order->name }},</p>
  
                            <p style="margin-bottom:12px">Thank you so much for your business. We will get started on your order right away. When we shipped, we will send you another email to make sure you can track your order easier.
                            <br>In the meantime, if you have any questions or asking about your order, you can email us through <i>LapXuongShop@support.com</i></p>
  
                            <h4 style="font-size: 20px;color: #333;border-bottom: 1px solid #ADABAB;margin-bottom: 5px;">YOUR ORDER CONFIRMATION</h4>
                            <p style="margin-top: 2px; margin-bottom: 2px;">Order Number: <b>#LXS-{{ $order->id }}</b></p>
                            <p style="margin-top: 2px; margin-bottom: 2px;">Order Date: <b>{{ $order->created_at->format('jS F Y h:i:s A') }}</b></p>
                            <p style="margin-top: 2px; margin-bottom: 2px;">Order Note: <b>"{{ $order->notes ?? "No note" }}"</b></p>
                            <p style="margin-top: 2px; margin-bottom: 2px;">Order Promotion: <b>{{ $order->usedPromotion->promotion->code ?? "Not promoted" }}</b></p>
                            <p style="margin-top: 2px; margin-bottom: 2px;">Order Status: <b>Confirmed</b></p>
                            <h4 style="font-size: 20px;color: #333;border-bottom: 1px solid #ADABAB;margin-top: 20px;margin-bottom: 5px;">SHIPPING INFO</h4>
                            <p style="margin-top: 2px; margin-bottom: 2px;">{{ $order->name }}</p>
                            <p style="margin-top: 2px; margin-bottom: 2px;">{{ $order->email}}</p>
                            <p style="margin-top: 2px; margin-bottom: 2px;">{{ $order->phone}}</p>
                            <p style="margin-top: 2px; margin-bottom: 2px;">{{ $order->address}}, {{ $order->ward}}, {{ $order->district}}, {{ $order->city}}</p>
                            <h4 style="font-size: 20px;color: #333;border-bottom: 1px solid #ADABAB;margin-top: 20px;margin-bottom: 5px;">ORDER SUMMARY</h4>
                            <table style="width: 100%;max-width: 100%;margin-bottom: 20px;border-spacing: 0;border-collapse: collapse;background-color: transparent;">
                                <thead>
                                    <tr>
                                        <th style="border-top: 0;vertical-align: bottom;border-bottom: 2px solid #ddd;padding: 8px;line-height: 1.4;text-align: left;"></th>
                                        <th style="border-top: 0;vertical-align: bottom;border-bottom: 2px solid #ddd;padding: 8px;line-height: 1.4;text-align: left;">Name</th>
                                        <th  style="border-top: 0;vertical-align: bottom;border-bottom: 2px solid #ddd;padding: 8px;line-height: 1.4;text-align: left;">Price</th>
                                        <th  style="border-top: 0;vertical-align: bottom;border-bottom: 2px solid #ddd;padding: 8px;line-height: 1.4;text-align: left;">Qty</th>
                                        <th  style="border-top: 0;vertical-align: bottom;border-bottom: 2px solid #ddd;padding: 8px;line-height: 1.4;text-align: left;">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->details as $item)
                                    <tr>
                                        <td style="padding: 8px;line-height: 1.4;vertical-align: top;border-top: 1px solid #ddd; border-radius: 3px;">
                                            <img src="{{ $message->embed('images/' . $item->product->oldestImage->url) }}"
                                            alt="{{ $item->product->subName() }}" class="rounded-circle" width="30" height="30">
                                        </td>
                                        <td style="padding: 8px;line-height: 1.4;vertical-align: top;border-top: 1px solid #ddd;">{{ $item->product->name }}</td>
                                        <td style="padding: 8px;line-height: 1.4;vertical-align: top;border-top: 1px solid #ddd;">{{ number_format($item->stock->price->sale, 0, ',', '.') . ' VND' }}</td>
                                        <td style="padding: 8px;line-height: 1.4;vertical-align: top;border-top: 1px solid #ddd;">{{ $item->quantity }}</td>
                                        <td style="padding: 8px;line-height: 1.4;vertical-align: top;border-top: 1px solid #ddd;">{{ number_format($item->quantity * $item->stock->price->sale, 0, ',', '.') . ' VND' }}</td>
                                      </tr>
                                    @endforeach
                                    <tr>
                                      <td style="padding: 8px;line-height: 1.4;vertical-align: top;border-top: 1px solid #ddd;" colspan="2">Discount</td>
                                      <td style="padding: 8px;line-height: 1.4;vertical-align: top;border-top: 1px solid #ddd;" colspan="3">{{ number_format($order->discountAmount(), 0, ',', '.') . ' VND' }}</td>
                                    </tr>
                                    <tr>
                                      <td style="padding: 8px;line-height: 1.4;vertical-align: top;border-top: 1px solid #ddd;" colspan="2">Total</td>
                                      <td style="padding: 8px;line-height: 1.4;vertical-align: top;border-top: 1px solid #ddd;" colspan="3">{{ number_format($order->total(), 0, ',', '.') . ' VND' }}</td>
                                    </tr>
                                    <tr>
                                      <td style="padding: 8px;line-height: 1.4;vertical-align: top;border-top: 1px solid #ddd;" colspan="2">Total Final</td>
                                      <td style="padding: 8px;line-height: 1.4;vertical-align: top;border-top: 1px solid #ddd;" colspan="3">{{ number_format($order->totalAfterDiscount(), 0, ',', '.') . ' VND' }}</td>
                                    </tr>
                                </tbody>
                            </table>
  
                            <p style="margin-bottom:25px">Thank you for shopping with us, have a nice day, wish you all the bests!</p>
  
                            <p style="margin-bottom:12px">Best Regards,<br><strong>LapXuongStore</strong></p>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
                </td>
              </tr>
            </tbody>
          </table>
          </center>
          </td>
        </tr>
      </tbody>
    </table>
  </div>