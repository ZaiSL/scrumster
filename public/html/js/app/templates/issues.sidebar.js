


App.JST['issues.sidebar/new'] = {
    tagName : 'div',
    className : 'issue-add-panel',
    layout :_.template(''


        + '<form name="new_issue" class="form-horizontal">'
            + '<div class="control-group">'
                + '<label for="title">Заголовок задачи</label>'
                + '<input type="text" id="title" name="title">'
            + '</div>'
            + '<div class="control-group">'
                + '<label for="description">Описание задачи</label>'
                + '<textarea name="description" id="description" cols="30" rows="4"></textarea>'
            + '</div>'
            + '<div class="control-group">'
                + '<label class="control-label" for="project">Проект</label>'
                + '<div class="controls">'
                    + '<select name="project" id="project" class="input-small">'
                    + '</select>'
                + '</div>'
            + '</div>'
            + '<div class="control-group">'
                + '<label class="control-label" for="type">Тип</label>'
                + '<div class="controls">'
                    + '<select name="type" id="type" class="input-medium">'
                    + '</select>'
                + '</div>'
            + '</div>'
            + '<div class="control-group">'
                + '<label class="control-label" for="stage">Этап</label>'
                + '<div class="controls">'
                    + '<select name="stage" id="stage"  class="input-medium">'
                    + '</select>'
                + '</div>'
            + '</div>'
            + '<div class="control-group">'
                + '<label class="control-label" for="assigned_to">Исполнитель</label>'
                + '<div class="controls">'
                    + '<select name="assigned_to" id="assigned_to"  class="input-medium">'
                    + '</select>'
                + '</div>'
            + '</div>'
            + '<div class="control-group">'
                + '<label class="control-label" for="estimate">Оценка</label>'
                + '<div class="controls">'
                    + '<select name="estimate" id="estimate" class="input-mini">'
                    + '</select>'
                + '</div>'
            + '</div>'
            + '<div class="control-group">'
                + '<div class="controls">'
                    + '<label class="checkbox">'
                        + '<input type="checkbox" name="is_feature" id="is_feature"> это фича, да'
                    + '</label>'
                + '</div>'
            + '</div>'
            + '<div class="form-actions">'
                + '<button class="btn btn-primary">Сохранить</button> '
                + '<button class="btn btn-close-sidebar">Отмена</button>'
            + '</div>'
        + '</form>'
    )
};

App.JST['issues.sidebar/view'] = {
    tagName : 'div',
    className : '',
    layout : ''
};