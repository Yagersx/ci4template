<?= $this->extend('layout') ?>
<?= $this->section('content') ?>


<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <?= $title ?>
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
                            <?= $subtitle ?>
                        </h3>

                        <div class="card-tools">
                            <a href="<?= base_url('/employees/create') ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Crear Empleado
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Posicion</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($employees as $employee) { ?>
                                    <tr>
                                        <td>
                                            <?= $employee->name; ?>
                                        </td>
                                        <td>
                                            <?= $employee->last_name; ?>
                                        </td>
                                        <td>
                                            <?= $employee->email; ?>
                                        </td>
                                        <td>
                                            <?= $employee->phone; ?>
                                        </td>
                                        <td>
                                            <?php if ($employee->position == 1) { ?>
                                                <span class="badge badge-success">Administrador</span>
                                            <?php } ?>
                                            <?php if ($employee->position == 2) { ?>
                                                <span class="badge badge-primary">Vendedor</span>
                                            <?php } ?>
                                            <?php if ($employee->position == 3) { ?>
                                                <span class="badge badge-default">Transportista</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($employee->position == 1) { ?>
                                                <a href="<?php echo base_url('employees/edit/' . $employee->employee_id); ?>"
                                                    class="btn btn-primary">Editar</a>
                                            <?php } ?>
                                            <?php if ($employee->position != 1) { ?>
                                                <a href="<?php echo base_url('employees/delete/' . $employee->employee_id); ?>"
                                                    class="btn btn-danger">Eliminar</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
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