<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<!--<div>Список задач</div>-->

<section class="tasks">
    <div class="container">
        <? if(!empty($arResult['ITEMS'])): ?>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Название</th>
                <th scope="col">Комментарий</th>
                <th scope="col">Дата создания</th>
                <th scope="col">Редактировать</th>
                <th scope="col">Выполнена</th>
            </tr>
            </thead>
            <tbody>
                <? foreach ($arResult['ITEMS'] as $arItem): ?>
                    <tr class="item <? if($arItem['PROPERTY_STATUS_ENUM_ID'] == 1):?>done<? endif; ?>" data-id="<?= $arItem['ID']?>">
                        <th scope="row"><?= $arItem['COUNT'] ?> </th>
                        <td class="task__name"> <?= $arItem['NAME'] ?> </td>
                        <td class="task__comment">
                            <?= $arItem['PREVIEW_TEXT'] ?>
                        </td>
                        <td class="task__date-create">
                            <?= $arItem['DATE_CREATE'] ?>
                        </td>
                        <td>
                            <img class="tasks__edit" src="<?= SITE_TEMPLATE_PATH?>/images/edit.svg" alt="">
                        </td>
                        <td class="task__status">
                            <input type="checkbox" class="change-status" <? if($arItem['PROPERTY_STATUS_ENUM_ID'] == 1):?> checked <? endif; ?>>
                        </td>
                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>
        <? else: ?>
            <div class="empty">
                <?= GetMessage('EMPTY_LIST')?>
            </div>
        <? endif; ?>
        <button type="button" class="btn btn-primary add-task"><?= GetMessage('ADD_TASK')?></button>

        <form class="new-task-form task-form mt-5">
            <div class="form-header">
                <h2 class="form-title">Создать задачу</h2>
                <div class="form-close">Закрыть форму</div>
            </div>
            <div class="form-group">
                <label for="name">Название задачи</label>
                <input type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Введите название">
            </div>
            <div class="form-group">
                <label for="comment">Комментарий</label>
                <textarea class="form-control" id="comment" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Добавить</button>
        </form>

        <form class="edit-task-form task-form mt-5">
            <div class="form-header">
                <h2 class="form-title">Редактировать задачу</h2>
                <div class="form-close">Закрыть форму</div>
            </div>
            <div class="form-group">
                <label for="edit-name">Название задачи</label>
                <input type="text" class="form-control" id="edit-name" aria-describedby="emailHelp" placeholder="Введите название">
            </div>
            <div class="form-group">
                <label for="edit-comment">Комментарий</label>
                <textarea class="form-control" id="edit-comment" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Изменить задачу</button>
        </form>

    </div>

</section>
