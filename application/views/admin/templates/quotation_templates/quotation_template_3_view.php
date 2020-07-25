<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $quotation->quotation_number; ?> - CERTIFICADO SSL</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600&display=swap" rel="stylesheet">
    <style>
       
        /*-- float utilities --*/
        .float-left {
        float: left   !important;
        }
        .float-right {
        float: right  !important;
        }
        .float-none {
        float: none   !important;
        }
        /*-- text utilities --*/
        .text-left {
        text-align: left   !important;
        }
        .text-right {
        text-align: right  !important;
        }
        .text-center {
        text-align: center !important;
        }
        /*-- spacing utilities --*/
        .m-0 {
        margin: 0 0 !important;
        }
        .mt-0 {
        margin-top: 0 !important;
        }
        .mr-0 {
        margin-right: 0 !important;
        }
        .mb-0 {
        margin-bottom: 0 !important;
        }
        .ml-0 {
        margin-left: 0 !important;
        }
        .mx-0 {
        margin-right: 0 !important;
        margin-left: 0 !important;
        }
        .my-0 {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        }
        .m-1 {
        margin: 0.25rem 0.25rem !important;
        }
        .mt-1 {
        margin-top: 0.25rem !important;
        }
        .mr-1 {
        margin-right: 0.25rem !important;
        }
        .mb-1 {
        margin-bottom: 0.25rem !important;
        }
        .ml-1 {
        margin-left: 0.25rem !important;
        }
        .mx-1 {
        margin-right: 0.25rem !important;
        margin-left: 0.25rem !important;
        }
        .my-1 {
        margin-top: 0.25rem !important;
        margin-bottom: 0.25rem !important;
        }
        .m-2 {
        margin: 0.5rem 0.5rem !important;
        }
        .mt-2 {
        margin-top: 0.5rem !important;
        }
        .mr-2 {
        margin-right: 0.5rem !important;
        }
        .mb-2 {
        margin-bottom: 0.5rem !important;
        }
        .ml-2 {
        margin-left: 0.5rem !important;
        }
        .mx-2 {
        margin-right: 0.5rem !important;
        margin-left: 0.5rem !important;
        }
        .my-2 {
        margin-top: 0.5rem !important;
        margin-bottom: 0.5rem !important;
        }
        .m-3 {
        margin: 1rem 1rem !important;
        }
        .mt-3 {
        margin-top: 1rem !important;
        }
        .mr-3 {
        margin-right: 1rem !important;
        }
        .mb-3 {
        margin-bottom: 1rem !important;
        }
        .ml-3 {
        margin-left: 1rem !important;
        }
        .mx-3 {
        margin-right: 1rem !important;
        margin-left: 1rem !important;
        }
        .my-3 {
        margin-top: 1rem !important;
        margin-bottom: 1rem !important;
        }
        .m-4 {
        margin: 1.5rem 1.5rem !important;
        }
        .mt-4 {
        margin-top: 1.5rem !important;
        }
        .mr-4 {
        margin-right: 1.5rem !important;
        }
        .mb-4 {
        margin-bottom: 1.5rem !important;
        }
        .ml-4 {
        margin-left: 1.5rem !important;
        }
        .mx-4 {
        margin-right: 1.5rem !important;
        margin-left: 1.5rem !important;
        }
        .my-4 {
        margin-top: 1.5rem !important;
        margin-bottom: 1.5rem !important;
        }
        .m-5 {
        margin: 3rem 3rem !important;
        }
        .mt-5 {
        margin-top: 3rem !important;
        }
        .mr-5 {
        margin-right: 3rem !important;
        }
        .mb-5 {
        margin-bottom: 3rem !important;
        }
        .ml-5 {
        margin-left: 3rem !important;
        }
        .mx-5 {
        margin-right: 3rem !important;
        margin-left: 3rem !important;
        }
        .my-5 {
        margin-top: 3rem !important;
        margin-bottom: 3rem !important;
        }
        .p-0 {
        padding: 0 0 !important;
        }
        .pt-0 {
        padding-top: 0 !important;
        }
        .pr-0 {
        padding-right: 0 !important;
        }
        .pb-0 {
        padding-bottom: 0 !important;
        }
        .pl-0 {
        padding-left: 0 !important;
        }
        .px-0 {
        padding-right: 0 !important;
        padding-left: 0 !important;
        }
        .py-0 {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        }
        .p-1 {
        padding: 0.25rem 0.25rem !important;
        }
        .pt-1 {
        padding-top: 0.25rem !important;
        }
        .pr-1 {
        padding-right: 0.25rem !important;
        }
        .pb-1 {
        padding-bottom: 0.25rem !important;
        }
        .pl-1 {
        padding-left: 0.25rem !important;
        }
        .px-1 {
        padding-right: 0.25rem !important;
        padding-left: 0.25rem !important;
        }
        .py-1 {
        padding-top: 0.25rem !important;
        padding-bottom: 0.25rem !important;
        }
        .p-2 {
        padding: 0.5rem 0.5rem !important;
        }
        .pt-2 {
        padding-top: 0.5rem !important;
        }
        .pr-2 {
        padding-right: 0.5rem !important;
        }
        .pb-2 {
        padding-bottom: 0.5rem !important;
        }
        .pl-2 {
        padding-left: 0.5rem !important;
        }
        .px-2 {
        padding-right: 0.5rem !important;
        padding-left: 0.5rem !important;
        }
        .py-2 {
        padding-top: 0.5rem !important;
        padding-bottom: 0.5rem !important;
        }
        .p-3 {
        padding: 1rem 1rem !important;
        }
        .pt-3 {
        padding-top: 1rem !important;
        }
        .pr-3 {
        padding-right: 1rem !important;
        }
        .pb-3 {
        padding-bottom: 1rem !important;
        }
        .pl-3 {
        padding-left: 1rem !important;
        }
        .px-3 {
        padding-right: 1rem !important;
        padding-left: 1rem !important;
        }
        .py-3 {
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
        }
        .p-4 {
        padding: 1.5rem 1.5rem !important;
        }
        .pt-4 {
        padding-top: 1.5rem !important;
        }
        .pr-4 {
        padding-right: 1.5rem !important;
        }
        .pb-4 {
        padding-bottom: 1.5rem !important;
        }
        .pl-4 {
        padding-left: 1.5rem !important;
        }
        .px-4 {
        padding-right: 1.5rem !important;
        padding-left: 1.5rem !important;
        }
        .py-4 {
        padding-top: 1.5rem !important;
        padding-bottom: 1.5rem !important;
        }
        .p-5 {
        padding: 3rem 3rem !important;
        }
        .pt-5 {
        padding-top: 3rem !important;
        }
        .pr-5 {
        padding-right: 3rem !important;
        }
        .pb-5 {
        padding-bottom: 3rem !important;
        }
        .pl-5 {
        padding-left: 3rem !important;
        }
        .px-5 {
        padding-right: 3rem !important;
        padding-left: 3rem !important;
        }
        .py-5 {
        padding-top: 3rem !important;
        padding-bottom: 3rem !important;
        }
    </style>
    <style>
        @page {
            margin: 0cm 0cm;
        }
        body {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
            margin: 2cm;
            font-size: 10px;
            
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            padding: 0 2cm;

            /** Extra personal styles **/
            /* background-color: #03a9f4;
            color: white;
            text-align: center;
            line-height: 1.5cm; */
        }

        /** Define the footer rules **/
        footer {
            position: fixed; 
            bottom: 0cm; 
            left: 0cm; 
            right: 0cm;
            height: 2cm;
            padding: 0 2cm;

            /** Extra personal styles **/
            /* background-color: #03a9f4;
            color: white;
            text-align: center;
            line-height: 1.5cm; */
        }
        
        table {
            border-collapse: collapse;
        }

        ul {
            margin: 0;
            padding-left: 16px;
        }

        ul li {
            line-height: 11px;
        }

        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 6px;
        }
        .m-0 {margin:0;}
        .p-0 {padding: 0;}
        .pb-3 {
            padding-bottom: 16px;
        }

        .pb-4 {
            padding-bottom: 24px;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }
        .table td {
            line-height: 10px;
        }
        /* .table td, .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        } */
        .table-bordered {
            border: 1px solid #dee2e6;
        }
        .table-bordered thead td, .table-bordered thead th {
            border-bottom-width: 2px;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }
        .table thead th {
            vertical-align: middle;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }

        .table-active, .table-active>td, .table-active>th {
            background-color: #eee;
        }
        .title {
            font-size: 25px;
            color: #029bca;
            padding-bottom: 25px;
        }
        .subtitle {
            color: #029bca;
            font-weight: normal;
            font-size: 20px;
            /* padding-bottom: 20px; */
        }
        .header__logo {
            width: 200px;
        }
    </style>
</head>
<body>
    <header>
        <table width="100%" style="font-size: 12px;">
            <tr>
                <td width="50%" height="2cm" align="left" valign="middle"><?php echo $quotation->quotation_number; ?></td>
                <td width="100%" height="2cm" align="right" valign="middle">
                    <img class="header__logo" src="<?php echo base_url('assets/backend/images/logo.png'); ?>">
                </td>
            </tr>
        </table>
    </header>

    <footer>
        <table style="width: 100%;">
            <tr>
                <td width="25%" valign="middle">
                    <img src="<?php echo base_url('assets/backend/images/logo_2.png'); ?>" width="150px">
                </td>
                <td valign="middle">
                <p style="font-weight: light; font-size: 9px; border-left: 1px solid #000; text-align: justify; padding-left: 10px; line-height: 7px; margin: 0;">
                © <?php echo date("Y");?> Propiedad de PeruSecurity. Todos los derechos reservados. Prohibida cualquier reproducción, distribución o comunicación pública, 
                a excepción de logos y textos pertenecientes aa sus respectivas marcas comerciales.</p>
                </td>
            </tr>
        </table>
    </footer>

    <main>    
        <div style="page-break-after: always;">
            <table style="width: 100%; font-size: 12px;">
                <tr>
                    <td style="text-align: right; width: 100%; padding: 20px 0;"><?php echo "Lima, " . fecha_es($quotation->created_at, 'd de F de a'); ?></td>
                </tr>
                <tr>
                    <td class="title">COTIZACIÓN</td>
                </tr>
                <tr>
                    <td>Señores:</td>
                </tr>
                <tr>
                    <td><strong><?php echo $quotation->customer_name; ?></strong></td>
                </tr>
                <tr>
                    <td><strong>RUC: <?php echo $quotation->customer_document_number; ?></strong></td>
                </tr>
                <tr>
                    <td><strong>Presente.-</strong></td>
                </tr>
                <tr>
                    <td style="height: 15px; background: #029bca;"></td>
                </tr>
                <tr>
                    <td style="color: #029bca; font-weight: normal; font-size: 25px; padding-bottom: 15px; padding-top: 20px;">PROPUESTA ECONÓMICA</td>
                </tr>
            </table>

            <table class="table table-bordered">
                <thead>
                    <tr class="table-active">
                    <th class="text-center" valign="center">Item</th>
                        <th class="text-center" valign="center">Cant</th>
                        <th class="text-center" valign="center">Descripción del Producto / Servicio</th>
                        <th class="text-center" valign="center">Subtotal</th>
                        <th class="text-center" valign="center">Desc.</th>
                        <th class="text-center" valign="center">Total</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($products as $key => $product): ?>
                    <tr>
                        <td valign="top" class="text-center"><?php echo ++$key ?></td>
                        <td valign="top" class="text-center"><?php echo $product->amount; ?></td>
                        <td  valign="top" width="55%" style="font-size: 10px;">
                            <?php echo $product->concept_name; ?> de 
                            (<?php echo $product->amount; ?>) <?php echo $product->product_name; ?> por 
                            <?php echo $product->quantity_year_name; ?>.<br>
                            <?php $domains = (int) 1 + $product->san_base + (int) $product->qty_san; ?>
                            <?php if($domains > 1): ?>
                                (PROTEGE <?php echo $domains == 1 ? " $domains DOMINIO O SUBDOMINIO" : "$domains DOMINIOS O SUBDOMINIOS"; ?>)
                            <?php endif; ?> 
                            <br>
                             
                            <?php
                            if($product->quotation_products_domains) {
                          $domains = ($product->quotation_products_domains) 
                                        ? explode(",", $product->quotation_products_domains) 
                                        : array($quotation->contact_email);
                                    echo '<strong>Dominio(s):</strong> <br>';
                                      foreach ($domains as $domain) {
                                          echo $domain . '<br>';
                                      }   
                              }
                            ?>  
                 
                            <br>
                                <u><strong>ESPECIFICACIONES TÉCNICAS:</strong></u>
                                <p><?php echo nl2br($product->technical_specifications); ?></p>
                                <br>
                        </td>
                        <td class="text-right" valign="top" style="white-space:nowrap;"><?php echo $quotation->currency_type_symbol; ?> <?php echo number_format($product->subtotal, 2, '.', ','); ?></td>
                        <td class="text-right" valign="top" style="white-space:nowrap;"><?php echo $quotation->currency_type_symbol; ?> <?php echo number_format($product->discount, 2, '.', ','); ?></td>
                        <td class="text-right" valign="top" style="white-space:nowrap;"><?php echo $quotation->currency_type_symbol; ?> <?php echo number_format($product->total, 2, '.', ','); ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <u><strong>Incluye:</strong></u>
                            <br>--
                            <ul>
                                <li>Soporte técnico gratuito durante todo el tiempo de vigencia del certificado.</li>
                                <li>Instalación gratuita.</li>
                                <li>Generación del archivo CSR.</li>
                            </ul>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="5">Subtotal</td>
                        <td colspan="1" class="text-right" style="white-space:nowrap;"><?php echo $quotation->currency_type_symbol; ?> <?php echo number_format($quotation->subtotal, 2, '.', ','); ?></td>
                    </tr>
                    <tr>
                        <td colspan="5">IGV (18%)</td>
                        <td colspan="1" class="text-right" style="white-space:nowrap;"><?php echo $quotation->currency_type_symbol; ?> <?php echo number_format($quotation->tax, 2, '.', ','); ?></td>
                    </tr>
                    <tr>
                        <td colspan="5" style="font-weight: bold; text-transform: uppercase;">Nota: Monto expresado en <?php echo $quotation->currency_type_name; ?></td>
                        <td colspan="1" class="text-right" style="white-space:nowrap;"><?php echo $quotation->currency_type_symbol; ?> <?php echo number_format($quotation->total, 2, '.', ','); ?></td>
                    </tr>
                </tbody>
            </table>

            <table style="width: 100%; margin-bottom: 20px; font-size: 12px;">
                <tr>
                    <td style="padding-bottom: 15px; width: 100%;"><strong>Consultas o comentarios:</strong> <?php echo $quotation->observation; ?></td>
                </tr>
                <tr>
                    <td style="padding-bottom: 5px;"><img src="<?php echo base_url('assets/backend/images/logo.png'); ?>" width="100px"></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;"><?php echo $quotation->user_full_name; ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;"><?php echo $quotation->user_job_title; ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Teléfonos: (511) 500-5441 - (511) 445-5601</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Anexo <?php echo $quotation->user_extension; ?></td>
                </tr>
            </table>

        </div>
        <div style="page-break-after: always;">
            <table style="width: 100%; font-size: 12px;">
                <tr>
                    <td class="subtitle" style="width: 100%;">CONDICIONES DE VENTA</td>
                </tr>
                <tr>
                    <td class="pb-4">
                        Los precios indicados están en <strong style="text-transform: uppercase;"><?php echo $quotation->currency_type_name; ?></strong><br>
                        Forma de Pago: <?php echo $quotation->credit_time_name; ?><br>
                        Afecto a Detracción 12% del precio total<br><br>

                        El número de la cuenta corriente para las detracciones del 12% es:<br>
                        <strong>BANCO DE LA NACION: 00-003-197522</strong><br><br>

                        Deposito a la cuenta en <strong>SOLES</strong> a nombre de: <br>
                        <strong>RUC PERU MEDIA SECURITY SAC: 20601709652</strong><br>
                        <strong>BANCO DE CREDITO Nº 194-2384799-0-76</strong><br>
                        <strong>BANCO DE CREDITO - Cuenta Interbancaria es CCI: 00219400238479907691</strong><br><br>

                        Deposito a la cuenta en <strong>DÓLARES</strong> a nombre de:<br>
                        <strong>RUC PERU MEDIA SECURITY SAC: 20601709652</strong><br>
                        <strong>BANCO DE CREDITO Nº 194-2417495-1-50</strong><br>
                        <strong>BANCO DE CREDITO - Cuenta Interbancaria en DOLARES CCI: 00219400241749515099</strong><br><br>
                        Validez de la Oferta: 15 días calendario a partir de la fecha de presentación de esta propuesta.
                    </td>
                </tr>
                <tr>
                    <td class="subtitle" style="width: 100%;">SOPORTE Y MANTENIMIENTO: 24 x 7 x 365</td>
                </tr>
                <tr style="text-align: justify;">
                    <td>
                        <ul>
                            <li style="margin-bottom: 5px;">Soporte al cliente gratuito: Existe un soporte técnico gratuito durante el horario laboral normal mediante un número telefónico exclusivo y por correo electrónico.</li>
                            <li style="margin-bottom: 5px;">Base de conocimientos y documentos de soporte en línea disponibles en cualquier momento.</li>
                            <li style="margin-bottom: 5px;">Duración: Durante el período de validez del o los certificados adquiridos.</li>
                            <li style="margin-bottom: 5px;">Perú Security ofrecerá un servicio de asistencia telefónica al usuario. Todas las preguntas, consultas y solicitudes deberán realizarse a dicho servicio a través de la línea: (51 1) 4455601.</li>
                            <li style="margin-bottom: 5px;">El servicio de asistencia telefónica de Perú Security funcionará desde las 09:00 horas hasta las 18:30 horas, de Lunes a Viernes. El servicio de asistencia vía mail será de 24 x 7 x 365.</li>
                            <li>Si un problema no puede ser resuelto inmediatamente, el equipo del servicio de asistencia de Perú Security lo remitirá al área de soporte técnico correspondiente. El solicitante será avisado por el referido equipo tan pronto como sea encontrada la solución o será informado acerca de los avances en la resolución del problema.</li>
                        </ul>
                    </td>
                </tr>
                
            </table>
        </div>

        <div style="page-break-after: never;">
            <table style="font-size:12px;">
                <tr>
                    <td class="subtitle" style="width: 100%;">RESPONSABILIDADES</td>
                </tr>
                <tr style="text-align:justify;">
                    <td><br>
                    <strong>RESPONSABILIDADES DE PERÚ SECURITY</strong><br>

                        Confidencialidad: La empresa Proveedora de bienes y servicios se compromete a mantener en reserva, y no revelar a tercero alguno sin previa 
                        conformidad escrita por el CLIENTE, toda información que le sea suministrada y se genere producto del servicio prestado.<br><br>
                        <br>
                        <strong>RESPONSABILIDADES</strong><br> 
                        En ningún caso, las partes serán responsables por los daños indirectos, mediatos o imprevisibles. En especial, 
                        de Perú Security. no será responsable por los daños derivados de la pérdida de información provocada por el uso, distribución, 
                        licencia, empleo o falta de empleo de producto o servicios, o por la realización de transacciones o servicios ofrecidos no 
                        contemplados por esta propuesta.<br><br>

                        Perú Security cuenta con un  equipo de profesionales orientados al servicio del cliente de primer nivel. Son responsabilidades de Perú Security: <br><br>
                        <ul>
                            <li>La asignación de personal certificado, capacitado y competente en los distintos ítems cubiertos por la presente oferta.</li>
                            <li>Garantizar la calidad de los servicios y equipos considerados en la presente propuesta.</li>
                        </ul>
                        <br>
                        En ningún caso, excepto por dolo, incluido el eventual, será Perú Security responsable por ningún daño indirecto, incidental o causal, 
                        ni por lucro cesante, pérdida de datos u otros, debido o en conexión con el uso, distribución licencia, empleo o falta de empleo de los productos 
                        o cualquiera otras transacciones o servicios ofrecidos no contemplados en esta propuesta, incluso aunque sea de conocimiento Perú Security de la 
                        responsabilidad de producción de tales daños.
                    </td>
                </tr>
            </table>
        </div>
    </main>
</body>
</html>