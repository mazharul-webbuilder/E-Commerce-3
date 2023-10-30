<html>
<!-- ==============================================
* Name: Mobify Email Template
* Author: Alejandro Finy // 3E Studio
* Framework Version: 1.0
=============================================== -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Mobify Email Template</title>

    <!-- CSS Reset -->
    <style type="text/css">
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }
        /* Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        /* Forces Outlook.com to display emails full width. */
        .ExternalClass {
            width: 100%;
        }
        /* Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }
        /* Stops Outlook from adding extra spacing to tables. */
        table, td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
        /* Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        table table table {
            table-layout: auto;
        }
        /* Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode: bicubic;
        }
        /* Overrides styles added when Yahoo's auto-senses a link. */
        .yshortcuts a {
            border-bottom: none !important;
        }
        /* Another work-around for iOS meddling in triggered links. */
        a[x-apple-data-detectors] {
            color: inherit !important;
        }
    </style>

    <!-- Progressive Enhancements -->
    <style type="text/css">
        /* Hover styles for buttons */
        .button-td, .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover, .button-a:hover {
            background: #319ecb !important;
            border-color: #319ecb !important;
        }

        /* Media Queries */
        @media screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
            }

            /* Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
            .fluid, .fluid-centered {
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }
            /* And center justify these ones. */
            .fluid-centered {
                margin-left: auto !important;
                margin-right: auto !important;
            }

            /* Forces table cells into full-width rows. */
            .stack-column, .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;
            }

            /* Generic utility class for centering. Useful for images, buttons, and nested tables. */
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }
            table.center-on-narrow {
                display: inline-block !important;
            }
        }
    </style>
</head>

<body bgcolor="#f7f7f7" width="100%" style="margin: 0;" yahoo="yahoo">
<table bgcolor="#f7f7f7" cellpadding="0" cellspacing="0" border="0" height="100%" width="100%" style="border-collapse:collapse;" style="margin: margin-top:50px">
    <tr>
        <td>
            <center style="width: 100%;">

                <!-- Visually Hidden Preheader Text : BEGIN -->
                <div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;"> (Optional) This text will appear in the inbox preview, but not the email body. </div>
                <!-- Visually Hidden Preheader Text : END -->

                <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="600" class="email-container">
                    <tr>
                        <td style="padding: 20px; text-align: center; font-family: sans-serif; font-size: 12px; mso-height-rule: exactly; line-height: 20px; color: #555555;"> Use this area to offer a short preview of your email's content.<br>
                            <a href="#" style="color:#555555">View this email in your browser</a>
                            <br>
                    </tr>
                </table>


                <!-- Email Header : BEGIN -->

                <!-- Email Header : END -->

                <!-- Email Body : BEGIN -->
                <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="600" class="email-container">


                    <!-- 1 Column Text : BEGIN -->
                    <tr>
                        <td style="padding: 40px; text-align: center; font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555;">

                            {{$data['body']}}
                            <!-- Button : END -->
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 40px; text-align: center; font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555;">

                            Best Regards <br>
                            <h4>Netel Mart</h4>
                            <!-- Button : END -->
                        </td>
                    </tr>


                </table>
                <!-- Email Body : END -->

                <!-- Email Footer : BEGIN -->
                <table align="center" width="600" class="email-container">
                    <tr>
                        <td style="padding: 20px 0px 0px 0px; text-align: center"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/189260/logo.png" width="20%" alt="alt_text" border="0"></td>
                    </tr>
                </table>

                <table align="center" width="600" class="email-container">
                    <tr>
                        <td style="padding: 10px 10px;width: 100%;font-size: 12px; font-family: sans-serif; mso-height-rule: exactly; line-height:18px; text-align: center; color: #888888;">
                            <span class="mobile-link--footer">Copyright &copy; 2015 Mobify. All rights reserved.<br>725 Granville Street, Suite #420, Vancouver, BC, Canada, V7Y 1C6</span> <br>
                            <br>
                            <unsubscribe style="color:#888888; text-decoration:underline;">Unsubscribe</unsubscribe>
                        </td>
                    </tr>
                    <tr>

                    </tr>
                </table>
                <!-- Email Footer : END -->

            </center>
        </td>
    </tr>
</table>
</body>

</html>
