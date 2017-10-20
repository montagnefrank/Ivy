<!DOCTYPE html>
<?php
if (isset($this->session->userdata['logged_in'])) {
    header(base_url() . "/admin/inicio");
}
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$link_vars = explode("/", $actual_link);
?>
<html lang="es">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="<?php echo base_url() ?>public/images/logotipo.png">
        <title><?php echo WEB_SITE_TITLE . " - " . (strip_tags($title)) ?></title>

        <?php foreach ($css as $sheet): ?>
            <link rel="stylesheet" type="text/css" href="<?php
            if ($link_vars[4] == "inicio") {
                if ($sheet !== "estilos") {
                    echo $css_path . $sheet;
                } else {
                    echo $css_path . "theme-default";
                }
            } else {
                echo $css_path . $sheet;
            }
            ?>.css" media="screen" />
              <?php endforeach; ?>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo base_url() ?>public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="<?php echo base_url() ?>public/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?php echo base_url() ?>public/css/sb-admin-2.css" rel="stylesheet">
        <?php if ($link_vars[4] == "inicio") { ?>
        <link href="<?php echo base_url() ?>public/css/videocontainer.css" rel="stylesheet">
        <?php } ?>
        <!-- Custom Fonts -->
        <link href="<?php echo base_url() ?>public/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <?php foreach ($scripts as $script): ?>
            <script type="text/javascript" src="<?php echo $scripts_path . $script ?>.js" charset="utf-8"></script>
        <?php endforeach; ?>
    </head>

    <body class="">

        <div id="wrapper">