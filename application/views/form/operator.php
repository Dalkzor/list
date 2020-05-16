<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form class="form-operator" action="" method="post">
    <p>
        <select data-placeholder="ФИЛИАЛ" name="office" class="office select-chosen">
            <option value=""></option>
            <?php foreach ($offices as $office): ?>
                <?php if ((!$office->getDeleted() && !$id) || ($id)): ?>
                    <option
                        <?php echo isset($office_id) && $office_id == $office->getId() ? 'selected':''; ?>
                            value="<?php echo $office->getId() ?>"
                    ><?php echo $office->getName(); ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </p>
    <p><input type="text" class="login form-control" name="login" placeholder="Логин" value="<?php
        if (isset($operator)) echo $operator->getLogin(); ?>"></p>
    <p><input type="password" class="password form-control" name="password" placeholder="Пароль"></p>
    <p><input type="password" class="password_check form-control" name="password_check" placeholder="Подтверждение пароля"></p>
    <p>
        <select data-placeholder="РОЛЬ" name="role" class="role select-chosen">
            <option value=""></option>
            <?php foreach ($roles as $role): ?>
                <option
                    <?php echo isset($operator) &&
                    $operator->getRole()->getId() == $role->getId() ? 'selected':''; ?>
                    value="<?php echo $role->getId(); ?>"
                ><?php echo $role->getTitle(); ?></option>
            <?php endforeach; ?>
        </select>
    </p>
    <p><input type="text" class="last-name form-control" name="last-name" placeholder="Фамилия" value="<?php
        if (isset($operator)) echo $operator->getLastName(); ?>"></p>
    <p><input type="text" class="first-name form-control" name="first-name" placeholder="Имя" value="<?php
        if (isset($operator)) echo $operator->getFirstName(); ?>"></p>
    <p><input type="text" class="middle-name form-control" name="middle-name" placeholder="Отчество" value="<?php
        if (isset($operator)) echo $operator->getMiddleName(); ?>"></p>
    <?php if (isset($id)): ?>
        <input type="hidden" name="operator-id" value="<?php echo $id; ?>">
    <?php endif; ?>
    <div class="operator-info error mt-1 float-left"></div>
    <button class="btn btn-info float-right btn-operator<?php echo isset($id)?'-edit':''; ?>">
        <i class="fa fa-user-plus"></i>
        <?php if (isset($id)): ?>Редактировать<?php else: ?>Добавить<?php endif; ?> оператора
    </button>
</form>
