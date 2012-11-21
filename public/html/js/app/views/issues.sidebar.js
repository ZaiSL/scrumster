

/**
 * Базовая вьюха для сайдбаров редактирования ипросмотра ишью
 * Вьюха завязана на модель конкретного ишью
 */
App.IssueSidebarView = Backbone.View.extend({

    sidebarTemplate : App.JST['issues.sidebar/sidebar'],
    template : '',

    events : {
        'click .close-sidebar' : 'close'
    },

    initialize : function (){


        _.extend(this.events, App.IssueSidebarView.prototype.events); // наследуем события
    },

    render : function (){

        //рендерим базовый темплейт сайдбара

        //рендерим внутренний темплейт сайдбара

        return this;
    },

    open : function (){

    },

    close : function (){

    }

});



/**
 * Вьюха для сайдбара создания нового ишью
 */
App.AddIssueSidebarView = App.IssueSidebarView.extend({

    events : {

    },

    initialize : function (){
        App.IssueSidebarView.prototype.initialize.call(this); // parent::initialize();


    },

    render : function (){
        App.IssueSidebarView.prototype.render.call(this); // parent::initialize();

    }



});



/**
 * Вьюха для сайдбара просмотра ишью
 */
App.ViewIssueSidebarView = App.IssueSidebarView.extend({

    events : {

    },

    initialize : function (){
        App.IssueSidebarView.prototype.initialize.call(this); // parent::initialize();

    },

    render : function (){
        App.IssueSidebarView.prototype.render.call(this); // parent::initialize();

    }



});