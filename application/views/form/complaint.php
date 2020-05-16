<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form class="form-complaint">
    <p>
        <select data-placeholder="ВЫБЕРИТЕ ФИЛИАЛ" name="office" class="office-complaint select-chosen">
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
    <p>
        <select data-placeholder="ВЫБЕРИТЕ КЛИЕНТА" name="client" class="client-complaint select-chosen">
            <option value=""></option>
            <?php foreach ($clients as $client): ?>
                <option
                        <?php echo isset($client_id) && $client_id == $client->getId() ? 'selected':''; ?>
                        value="<?php echo $client->getId(); ?>"
                ><?php echo trim(
                            "{$client->getLastName()} {$client->getFirstName()} {$client->getMiddleName()}"
                        ) . ' (' . $client->getPhone() . ')'; ?></option>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <select data-placeholder="ОТВЕТСТВЕННОЕ ЛИЦО" multiple="" name="operators[]" class="responsible-complaint select-multiple">
            <option value=""></option>
            <?php foreach ($operators as $operator): ?>
                <option
                        <?php
                        if (isset($responsible)) {
                            foreach ($responsible as $res) {
                                echo $res->getOperator()->getId() == $operator->getId() ? 'selected':'';
                            }
                        } ?>
                        value="<?php echo $operator->getId(); ?>"
                ><?php echo trim(
                            "{$operator->getLastName()} {$operator->getFirstName()} {$operator->getMiddleName()}"
                        ); ?></option>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <select data-placeholder="ВИДЫ ЖАЛОБ" name="complaint-type" class="type-complaint select-chosen">
            <option value=""></option>
            <?php foreach ($complaints_type as $complaintType): ?>
                <option
                        <?php echo isset($complaint_type_id) &&
                        $complaint_type_id == $complaintType->getId() ? 'selected':''; ?>
                        value="<?php echo $complaintType->getId(); ?>"
                ><?php echo $complaintType->getTitle(); ?></option>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <select data-placeholder="СТАТУС" name="complaint-status" class="status-complaint select-chosen">
            <option value=""></option>
            <?php foreach ($complaints_status as $complaintsStatus): ?>
                <option
                    <?php echo isset($complaint_status_id) &&
                    $complaint_status_id == $complaintsStatus->getId() ? 'selected':''; ?>
                    value="<?php echo $complaintsStatus->getId(); ?>"
                ><?php echo $complaintsStatus->getTitle(); ?></option>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <textarea name="description" class="description" placeholder="Описание"><?php
            echo isset($description) ? $description : ''; ?></textarea>
    </p>
    <p>
        <textarea name="result" class="result" placeholder="Обратная связь"><?php
            echo isset($result) ? $result : ''; ?></textarea>
    </p>
    <p>
        <textarea name="reason" class="reason" placeholder="Причина"><?php
            echo isset($reason) ? $reason : ''; ?></textarea>
    </p>
    <?php if (isset($id)): ?>
    <input type="hidden" name="complaint-id" value="<?php echo $id; ?>">
    <?php endif; ?>
    <div class="complaint-info hide-tag error mt-1 float-left"></div>
    <button
            class="btn btn-info float-right btn-complaint<?php echo isset($id)?'-edit':''; ?>"
    ><i class="fa fa-address-card"></i> Добавить</button>
</form>