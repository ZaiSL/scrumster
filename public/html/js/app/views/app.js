


/**
 * Главная вьюха всего приложения.
 * Включает в себя верхний тулбар и контейнер для вьюхи доски. *
 * */
App.AppView = Backbone.View.extend({

    boardView : null,
    addIssueView : null,

    events : {
        'click .add-issue-button' : 'addIssueButtonClick' //
    },

    initialize : function(){

    },

    render : function (){

        App.issues = new App.Issues(App.Storage.Issues);
        App.users = new App.Users(App.Storage.Users);

        App.Settings.currentUser = App.users.get(App.Settings.currentUserId);

        console.log(App.Settings.currentUser.toJSON());

        this.boardView = new App.BoardView({
            el : $('#content'),
            collection : App.issues
        });

        this.boardView.render();



    },

    addIssueButtonClick : function (){



        var issue = new App.Issue();

        if (!this.addIssueView) {
            this.addIssueView = new App.AddIssueSidebarView({model : issue });
        } else {
            this.addIssueView.model = issue;
        }

        this.addIssueView.render();
        this.addIssueView.open();

    }


});