<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper p-2">
    <div class="hide-tag">
        <div class="insert-forms-client"></div>
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
                    <!--<button
                        <?php echo $this->session->userdata(models\Operator::KEY_ROLE_ID) < models\Role::ID_SENIOR_OPERATOR ? 'disabled' : ''; ?>
                            type="button"
                            id="btn-add-client"
                            class="btn btn-info"
                    ><i class="fa fa-plus"></i> Добавить клиента
                    </button>-->
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body layer">
                <table id="client-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>id</th>
                        <th>Телефон</th>
                        <th>Фамилия</th>
                        <th>Имя</th>
                        <th>Отчество</th>
                        <th>Дата добавления</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($clients)): ?>
                    <?php foreach ($clients as $client): ?>
                    <tr>
                        <td>
                        <?php if ($this->session->userdata(models\Operator::KEY_ROLE_ID) >= models\Role::ID_SENIOR_OPERATOR): ?>
                            <div class="tools text-center сontrol">
                                <div class="fa fa-edit"></div>
                                <!--<div class="fa fa-trash-o"></div>-->
                                <div class="hide-tag client-id"><?php echo $client->getId(); ?></div>
                            </div>
                        <?php endif; ?>
                        </td>
                        <td><?php echo $client->getId(); ?></td>
                        <td><?php echo $client->getPhone(); ?></td>
                        <td><?php echo $client->getLastName(); ?></td>
                        <td><?php echo $client->getFirstName(); ?></td>
                        <td><?php echo $client->getMiddleName(); ?></td>
                        <td><?php echo $client->getCreateDate()->format('Y-m-d H:i'); ?></td>
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