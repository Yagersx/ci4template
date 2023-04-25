<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

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
                    <li class="breadcrumb-item"><a href="<?= base_url('/employees') ?>">Listado</a></li>
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
                    </div>
                    <form method="post" action="<?php echo base_url('employees/' . $action); ?>">
                        <div class="card-body">
                            <div style="color:red;">
                                <?= validation_list_errors() ?>
                            </div>
                            <div class="row">
                                <input type="hidden" name="id" value="<?= old('id', $id ?? ''); ?>">

                                <div class="form-group col-4">
                                    <label for="name">Nombre:</label>
                                    <input type="text" class="form-control" id="name" name="name" required
                                        value="<?= old('name', $employee->name ?? ''); ?>">
                                </div>
                                <div class="form-group col-4">
                                    <label for="last_name">Apellido:</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required
                                        value="<?= old('last_name', $employee->last_name ?? ''); ?>">
                                </div>
                                <div class="form-group col-4">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" required
                                        value="<?= old('email', $employee->email ?? ''); ?>">
                                </div>
                                <div class="form-group col-4">
                                    <label for="phone">Teléfono:</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required
                                        minlength="10" maxlength="10"
                                        value="<?= old('phone', $employee->phone ?? ''); ?>">
                                </div>
                                <div class="form-group col-8">
                                    <label for="address">Dirección:</label>
                                    <input type="text" class="form-control" id="address" name="address" required
                                        value="<?= old('address', $employee->address ?? ''); ?>">
                                </div>
                                <div class="form-group col-4">
                                    <label for="position">Posicion:</label>
                                    <select class="form-control" id="position" name="position" required>
                                        <option value=""></option>
                                        <?php foreach ($positions as $position) { ?>
                                            <option value="<?= $position->position_id; ?>" <?= old('position', $employee->position ?? '') == $position->position_id ? 'selected' : '' ?>><?= $position->description; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label for="password">Contraseña:</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        minlength="8" <?= !isset($employee) ? 'required' : '' ?>>
                                </div>
                                <div class="form-group col-4">
                                    <label for="password_confirm">Confirmar Contraseña:</label>
                                    <input type="password" class="form-control" id="password_confirm"
                                        name="password_confirm" minlength="8" <?= !isset($employee) ? 'required' : '' ?>>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="float-sm-right">
                                <a type="button" class="btn btn-danger "
                                    href="<?= base_url('/employees') ?>">Cancelar</a>
                                <button type="submit" class="btn btn-primary  ">Guardar</button>
                            </div>
                        </div>
                    </form>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->
            </div>
        </div>

    </div>
</section>
<!-- /.content -->

<?= $this->endSection() ?>