

App.Issue = Backbone.Model.extend({
    defaults : {
        project_id      : 0,
        sprint_id       : 0,
        type            : 0,
        title           : '',
        description     : '',
        estimate        : 0,
        is_feature      : 0,
        stage           : 0,
        created_at      : 0,
        owner           : 0,
        assigned_to     : 0,
        parent_feature  : 0

    }
});


App.Issues = Backbone.Collection.extend({

    model : App.Issue,

    localStorage: new Store("youboard-issues")


});