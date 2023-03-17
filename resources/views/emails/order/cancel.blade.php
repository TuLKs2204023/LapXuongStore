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
  
                            <p style="margin-bottom:12px">We are sending this from LapXuongStore, this is an automatically message.</p>
  
                            <p style="margin-bottom:12px;">We need to announce you that your order <b>LXS-{{ $order->id }}</b> has been canceled successfully at {{ $order->updated_at }}. Thank you for shopping with us, we hope you had the best time with our services.</p>
  
                            <p style="margin-bottom:25px">If there is anything you need to know, please contact us through <i>LapXuongShop@support.com</i></p>
  
                            <p style="margin-bottom:12px">Have a nice day!</p>
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