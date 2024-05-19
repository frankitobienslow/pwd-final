<?php
include_once("../../configuracion.php");
require_once '../../vendor/autoload.php'; // Incluir el archivo de autoload de Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$datos = data_submitted();

class MailSender
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->CharSet = 'utf-8';
        $this->mail->UseSendmailOptions = 0;
        $this->mail->setFrom("franinsua7@gmail.com", "WESH WESH");
        $this->mail->isSMTP();
        $this->mail->IsHTML(true);
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'franinsua7@gmail.com';
        $this->mail->Password = 'nwtrbloritlhvkxq';
        $this->mail->Port = 465;
        $this->mail->SMTPSecure = 'ssl';
    }

    public function sendEstado($objCompra)
    {
        $this->mail->addAddress($objCompra->getUsuario()->getMail());
        $objAbmCompraEstado = new AbmCompraEstado;
        $objAbmCompraItem = new AbmCompraItem;
        $objAbmProducto = new AbmProducto;
        $ultimoCE = $objAbmCompraEstado->buscar(["idcompra" => $objCompra->getId(), "cefechafin" => "null"])[0];
        if ($ultimoCE != null) {
            $compraestadotipo = $ultimoCE->getObjCompraEstadoTipo()->getId();
            // Obtener datos de la compra
            $nombreUsuario = $objCompra->getUsuario()->getNombre();
            $arrCI = $objAbmCompraItem->buscar(["idcompra" => $objCompra->getId()]);
            $monto = 0;
            for ($i = 0; $i < count($arrCI); $i++) {
                $monto += $arrCI[$i]->getObjProducto()->getPrecio() * $arrCI[$i]->getCantidad();
            }
            switch ($compraestadotipo) {
                case 2:
                    $subject = "¡Gracias por su compra!";
                    $message = "¡Hola ".$nombreUsuario."! Ya registramos su compra. Confirmaremos el envío a la brevedad.";
                    break;
                case 3:
                    $subject = "¡En camino!";
                    $message = "Estimado ".$nombreUsuario.", le informamos que su compra fue enviada. ¡La recibiras pronto!";
                    break;
                case 4:
                    $subject = "¡Compra entregada!";
                    $message = "Estimado ".$nombreUsuario.", le informamos que su compra fue entregada. ¡Gracias por confiar en nosotros!";
                    break;
                case 5:
                    $subject = "Hemos cancelado su compra.";
                    $message = $nombreUsuario.", lo sentimos. Su compra ha sido cancelada. El monto fue acreditado al medio de pago empleado. Lamentamos los inconvenientes.";
                    break;
                case 6:
                    $subject = "¡Oops! Pasaron cosas...";
                    $message = "Estimado ".$nombreUsuario.", lamentamos informar que se han producido cambios en su compra, por favor, confirmar si desea continuar con la misma desde <strong>Mis Compras</strong>. Fue transferido el monto de el/los producto(s) cancelados al medio de pago empleado. Disculpe las molestias.";
                    break;
            }
            $templateContent = '<!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>' . $subject . '</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f4f4f4;
                            margin: 0;
                            padding: 0;
                        }
                
                        .container {
                            max-width: 600px;
                            margin: 20px auto;
                            padding: 20px;
                            background-color: #fff;
                            border-radius: 5px;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        }
                
                        header {
                            color: rgb(159, 22, 30);
                            text-align: center;
                        
                            border-radius: 5px 5px 0 0;
                            display: flex;
                            align-items: center;
                        }
                
                        h1 {
                            margin: 0 auto; 
                        }
                
                        p {
                            line-height: 1.6;
                        }
                
                        .footer {
                            text-align: center;
                            margin-top: 20px;
                        }
                
                        .footer p {
                            color: #666;
                        }
                
                        img {
                            width: 100px;
                            height: auto;
                        }

                        .custom-table {
                            width: 100%;
                            margin-bottom: 1rem;
                            color: #212529;
                            border-collapse: collapse;
                        }
                        
                        .custom-table th,
                        .custom-table td {
                            padding: 0.75rem;
                            vertical-align: top;
                            border-top: 1px solid #dee2e6;
                        }
                        
                        .custom-h6 {
                            font-size: 1rem;
                            font-weight: 500;
                        }
                        
                        .custom-fw-bolder {
                            font-weight: bolder;
                        }
                        
                        .custom-text-center {
                            text-align: center;
                        }
                        
                        
                        .custom-align-middle {
                            vertical-align: middle;
                        }
                        
                        .custom-table thead th {
                            vertical-align: bottom;
                            border-bottom: 2px solid #dee2e6;
                        }
                        
                        .custom-table tbody + tbody {
                            border-top: 2px solid #dee2e6;
                        }
                    </style>
                </head>
                
                <body>
                    <div class="container">
                        <header>
                            <h1>' . $subject . '</h1>
                        </header>
                        <p>' . $message . '</p>
                        <h3>Compra #' . $objCompra->getId() . '</h3>
                        <table class="custom-table">
    <thead>
        <tr>
            <th class="custom-h6 custom-fw-bolder">Producto</th>
            <th class="custom-h6 custom-fw-bolder custom-text-center">Cantidad</th>
            <th class="custom-h6 custom-fw-bolder custom-text-center">Precio</th>
        </tr>
    </thead>
    <tbody>';
            foreach ($arrCI as $compraitem) {
                $nombre = $compraitem->getObjProducto()->getNombre();
                $detalle = $compraitem->getObjProducto()->getDetalle();
                $cantidad = $compraitem->getCantidad();
                $precio = ($compraitem->getObjProducto()->getPrecio()) * $cantidad;
                $templateContent .= ' <tr>
                <td class="custom-align-middle custom-h6">
                    ' . $nombre . " " . $detalle . '
                </td>
                ';
                if ($precio != 0) {
                    $templateContent .= '
                    <td class="custom-align-middle custom-h6 custom-text-center">
                        ' . $cantidad . '
                    </td>
                    <td class="custom-align-middle custom-h6 custom-text-center">
                        $' . $precio . '
                    </td>';
                } else {
                    $templateContent .= '<td class="custom-align-middle custom-h6 custom-text-center">
                    Producto cancelado
                </td> <td class="custom-align-middle custom-h6 custom-text-center">
                -
            </td>';
                }
                $templateContent .= '
            </tr>';
            }
            $templateContent .= ' </tbody>
            </table>
                        ';
            if ($compraestadotipo != 5) {
                $templateContent .= '<p><strong>Monto total:</strong>$' . $monto . '</p>';
            }
            $templateContent .= '
                        <div class="footer">
                            <p>Este correo electrónico fue enviado automáticamente. Por favor no responda.</p>
                        </div>
                    </div>
                </body>
                
                </html>';
        }

        // Establecer el asunto y el cuerpo del correo
        $this->mail->Subject = $subject;
        $this->mail->msgHTML($templateContent);

        try {
            // Enviar el correo electrónico
            $this->mail->send();
            return true; // Envío exitoso
        } catch (Exception $e) {
            // Manejo de errores
            return $e; // Envío fallido
        }
    }
}
