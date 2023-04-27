<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php
$positionColors = array(
    1 => 'badge-success',
    2 => 'badge-primary',
    3 => 'badge-info',
    4 => 'badge-secondary'
); ?>


<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    Empleados
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Dashboard</a></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <?= $title ?>
                        </h3>

                        <div class="card-tools">
                            <a href="<?= base_url('/employees/create') ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Crear Empleado
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="employees-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Cumpleaños</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Salario</th>
                                    <th class="text-center">Posicion</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->
            </div>
        </div>

    </div>
</section>
<!-- /.content -->

<?= $this->endSection() ?>