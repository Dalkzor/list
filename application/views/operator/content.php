<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper p-2">
    <div class="hide-tag">
        <div class="insert-forms-operator"></div>
    </div>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="card-header-left mt-2 float-left">
                    <h3 class="card-title">
                        <i class="ion ion-clipboard mr-1"></i>
                        <?php echo $title; ?>
                    </h3>
                </div>
                <div class="card-header-right float-right">
                    <button
                        <?php echo $this->session->userdata(models\Operator::KEY_ROLE_ID) < models\Role::ID_ADMIN ? 'disabled' : ''; ?>
                            type="button"
                            id="btn-add-operator"
                            class="btn btn-info"
                    ><i class="fa fa-plus"></i> Добавить оператора
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body layer">
                <table id="operator-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>id</th>
                        <th>Роль</th>
                        <th>Логин</th>
                        <th>Фамилия</th>
                        <th>Имя</th>
                        <th>Отчество</th>
                        <th>Филиал</th>
                        <th>Дата регистрации</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($operators)): ?>
                        <?php foreach ($operators as $operator): ?>
                            <tr>
                                <td>
                                    <?php if ($this->session->userdata(models\Operator::KEY_ROLE_ID) >= models\Role::ID_ADMIN): ?>
                                        <div class="tools text-center сontrol">
                                            <div class="fa fa-edit"></div>
                                            <div class="hide-tag operator-id"><?php echo $operator->getId(); ?></div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $operator->getId(); ?></td>
                                <td><?php echo $operator->getRole()->getTitle(); ?></td>
                                <td><?php echo $operator->getLogin(); ?></td>
                                <td><?php echo $operator->getLastName(); ?></td>
                                <td><?php echo $operator->getFirstName(); ?></td>
                                <td><?php echo $operator->getMiddleName(); ?></td>
                                <td><?php echo $operator->getOffice() ? $operator->getOffice()->getName() : ''; ?></td>
                                <td><?php echo $operator->getCreateDate()->format('Y-m-d H:i'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
</div>