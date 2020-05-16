<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper p-2">
    <div class="hide-tag">
        <div class="insert-forms-complaint"></div>
        <div class="insert-forms-client"></div>
    </div>
    <section class="content">
        <form class="filter-form" name="filter-complaint" method="post" action="">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-filter mr-1"></i>
                        Фильтр
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <input
                                class="date-from form-control ml-2"
                                name="date-from"
                                type="text"
                                placeholder="C"
                                value="<?php echo date('Y-m-d'); ?>"
                        >
                        <input class="date-to form-control ml-1" name="date-to" type="text" placeholder="По">
                    </div>
                    <div class="mt-2">
                        <select data-placeholder="ВЫБЕРИТЕ ФИЛИАЛ" name="office" class="office">
                            <option value=""></option>
                            <?php foreach ($offices as $office): ?>
                                <option
                                    value="<?php echo $office->getId(); ?>"
                                ><?php echo $office->getName(); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mt-2">
                        <select data-placeholder="КЛИЕНТ" name="client" class="client">
                            <option value=""></option>
                            <?php foreach ($clients as $client): ?>
                                <option
                                        value="<?php echo $client->getId(); ?>"
                                ><?php  echo trim(
                                        "{$client->getLastName()} {$client->getFirstName()} {$client->getMiddleName()}"
                                        ) . ' (' . $client->getPhone() . ')'; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select data-placeholder="ВИДЫ ЖАЛОБ" name="complaint-type" class="complaint-type">
                            <option value=""></option>
                            <?php foreach ($complaints_type as $complaintType): ?>
                                <option
                                        value="<?php echo $complaintType->getId(); ?>"
                                ><?php echo $complaintType->getTitle(); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mt-2">
                        <select data-placeholder="ОПЕРАТОР" name="operator" class="operator mr-2">
                            <option value=""></option>
                            <?php foreach ($operators as $operator): ?>
                                <option
                                    <?php echo ($this->session->userdata(models\Operator::KEY_ID) == $operator->getId() &&
                                        ($this->session->userdata(models\Operator::KEY_ROLE_ID) == models\Role::ID_OPERATOR ||
                                         $this->session->userdata(models\Operator::KEY_ROLE_ID) == models\Role::ID_SENIOR_OPERATOR)
                                    ) ? 'selected' : ''; ?>
                                        value="<?php echo $operator->getId(); ?>"
                                ><?php echo trim(
                                        "{$operator->getLastName()} {$operator->getFirstName()} {$operator->getMiddleName()}"
                                    ); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select data-placeholder="СТАТУС" name="complaint-status" class="complaint-status">
                            <option value=""></option>
                            <?php foreach ($complaints_status as $complaintStatus): ?>
                                <option
                                        value="<?php echo $complaintStatus->getId(); ?>"
                                ><?php echo $complaintStatus->getTitle(); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <button
                            type="button"
                            id="btn-filter"
                            class="btn btn-info float-right"
                    ><i class="fa fa-filter"></i> Применить фильтр
                    </button>
                </div>
            </div>
        </form>
    </section>
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
                        <?php echo $this->session->userdata(models\Operator::KEY_ROLE_ID) < models\Role::ID_OPERATOR ? 'disabled' : ''; ?>
                            type="button"
                            id="btn-add-complaint"
                            class="btn btn-info"
                    ><i class="fa fa-plus"></i> Добавить жалобу
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body layer">
                <table id="complaint-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>№</th>
                        <th>Дата</th>
                        <th>Оператор</th>
                        <th>Клиент</th>
                        <th>Телефон</th>
                        <th>Филиал</th>
                        <th>Описание</th>
                        <th>Вид жалобы</th>
                        <th>Ответственный</th>
                        <th>Статус</th>
                        <th>Обратная связь</th>
                        <th>Причина</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($complaints)): ?>
                    <?php foreach ($complaints as $complaint): ?>
                        <tr>
                            <td>
                                <?php if ($this->session->userdata(models\Operator::KEY_ROLE_ID) >= models\Role::ID_OPERATOR): ?>
                                    <div class="tools text-center сontrol">
                                        <div class="fa fa-edit"></div>
                                        <div class="fa fa-trash-o"></div>
                                        <div class="hide-tag complaint-id"><?php echo $complaint->getId(); ?></div>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $complaint->getId(); ?></td>
                            <td><?php echo $complaint->getCreateDate()->format('Y-m-d H:i'); ?></td>
                            <td><?php echo trim(
                                    "{$complaint->getOperator()->getLastName()}
                                          {$complaint->getOperator()->getFirstName()}
                                          {$complaint->getOperator()->getMiddleName()}"
                                ); ?></td>
                            <td><?php echo trim(
                                    "{$complaint->getClient()->getLastName()}
                                          {$complaint->getClient()->getFirstName()}
                                          {$complaint->getClient()->getLastName()}"
                                ); ?></td>
                            <td><?php echo $complaint->getClient()->getPhone(); ?></td>
                            <td><?php echo $complaint->getOffice()->getName() . ' [' . $complaint->getOffice()->getId() . ']'; ?></td>
                            <td><?php echo $complaint->getDescription(); ?></td>
                            <td><?php echo $complaint->getComplaintType()->getTitle(); ?></td>
                            <td><?php
                                $operators = [];
                                foreach ($complaint->getAssocComplaintsOperators() as $responsible) {
                                    $operators[] = $responsible->getOperator()->getLastName() .' '.
                                        $responsible->getOperator()->getFirstName() .' '.
                                        $responsible->getOperator()->getMiddleName();
                                }
                                echo implode(', ', $operators);
                            ?></td>
                            <td><?php if ($complaint->getComplaintStatus())
                                echo $complaint->getComplaintStatus()->getTitle(); ?></td>
                            <td<?php echo !empty($complaint->getResult()) ? ' class="bg-result"' : ''; ?>>
                                <?php echo $complaint->getResult(); ?>
                            </td>
                            <td><?php echo $complaint->getReason(); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>&nbsp;</th>
                        <th>№</th>
                        <th>Дата</th>
                        <th>Оператор</th>
                        <th>Клиент</th>
                        <th>Телефон</th>
                        <th>Филиал</th>
                        <th>Описание</th>
                        <th>Вид жалобы</th>
                        <th>Ответственный</th>
                        <th>Статус</th>
                        <th>Обратная связь</th>
                        <th>Причина</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
</div>
<!-- /.content-wrapper -->