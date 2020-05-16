<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form class="form-client" action="" method="post">
    <p><input type="text" class="last-name form-control" name="last-name" placeholder="Фамилия" value="<?php
        if (isset($client)) echo $client->getLastName(); ?>"></p>
    <p><input type="text" class="first-name form-control" name="first-name" placeholder="Имя" value="<?php
        if (isset($client)) echo $client->getFirstName(); ?>"></p>
    <p><input type="text" class="middle-name form-control" name="middle-name" placeholder="Отчество" value="<?php
        if (isset($client)) echo $client->getMiddleName(); ?>"></p>
    <p>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-phone"></i></span>
        </div>
        <input
                type="text" class="phone form-control" name="phone"
                data-inputmask='"mask": "(999) 999-9999"' data-mask
                value="<?php if (isset($client)) echo $client->getPhone(); ?>"
        >
    </div>
    </p>
    <?php if (isset($id)): ?>
    <input type="hidden" name="client-id" value="<?php echo $id; ?>">
    <?php endif; ?>
    <div class="client-info error mb-3"></div>
    <button class="btn btn-info btn-block btn-client<?php echo isset($id)?'-edit':''; ?>">
        <i class="fa fa-user-plus"></i>
        <?php if (isset($id)): ?>Редактировать<?php else: ?>Добавить<?php endif; ?> клиента
    </button>
</form>