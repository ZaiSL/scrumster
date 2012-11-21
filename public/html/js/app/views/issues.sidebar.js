
/**
 * Базовая вьюха для сайдбаров редактирования ипросмотра ишью
 * Вьюха завязана на модель конкретного ишью
 */
App.IssueSidebarView = Backbone.View.extend({

    template : '',

    events : {
        'click .close-sidebar' : 'close'
    },

    initialize : function (){

        this.$el.appendTo('#content');
        _.extend(this.events, App.IssueSidebarView.prototype.events); // наследуем события
    },

    render : function (){



        return this;
    },

    open : function (){
        this.$el.show();
    },

    close : function (){
        this.$el.hide();
    }

});


/**
 * Вьюха для сайдбара создания нового ишью
 */
App.AddIssueSidebarView = App.IssueSidebarView.extend({

    template : App.JST['issues.sidebar/new'].layout,
    tagName : App.JST['issues.sidebar/new'].tagName,
    className : App.JST['issues.sidebar/new'].className,

    events : {
        'click .btn-close-sidebar' : 'close'
    },

    initialize : function (){
        App.IssueSidebarView.prototype.initialize.call(this); // parent::initialize();
    },

    render : function (){

        this.$el.html(this.template());

    }



});



/**
 * Вьюха для сайдбара просмотра ишью
 */
App.ViewIssueSidebarView = App.IssueSidebarView.extend({

    events : {

    },

    initialize : function (){


    },

    render : function (){


    }



});