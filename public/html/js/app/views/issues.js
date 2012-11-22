

/**
 * Вьюха для конкртеного ишью
 * Завязана на модельку конкретного ишью и представляет стикер на доске
 */
App.IssueView = Backbone.View.extend({

    template : App.JST['issues/issue'],
    tagName : App.JST['issues/issue'].tagName,
    className : App.JST['issues/issue'].className,

    events : {


    },

    initialize : function (){

    },

    render : function (){

        this.$el.html(this.template.layout(this.model.toJSON()))

        return this;
    }


});

/**
 * Вьюха для фичи.
 * Завязана на модельку ишью, которое является фичей.
 * Представляет горизонтальную полоску с татлом фичи *
 */
App.FeatureView = Backbone.View.extend({

    template : App.JST['issues/feature'],
    className : App.JST['issues/feature'].className,
    tagName : App.JST['issues/feature'].tagName,


    events : {


    },

    initialize : function (){
    },


    render : function (){

	    this.$el.html(this.template.layout(this.model.toJSON()));
        return this;
    }

});


/**
 * Вьюха группы ишью.
 * Завязана на модельку фичи и коллекции из дочерних ишью. Моделька фичи - необязательна
 * Представляет часть доски - полоску фичи и группу дочерних стикеров.
 */
App.IssuesGroupView = Backbone.View.extend({

    template : App.JST['issues/group'],

    $columns : null,

    events : {


    },

    initialize : function (){

        this.$el.html(this.template.layout);
        this.$columns = this.$('.column-line');
    },

    render : function (){

        var self = this;

        if (this.model){
            //рендерим фичу
            // prependTo(this.$el);

	        var featureView = new App.FeatureView({
		        model : this.model
	        });
	        featureView.render().$el.prependTo(this.$el);
        }


        this.collection.each(function (issue){
            self.addIssue(issue);
        });

        return this;
    },

    addIssue : function (issue){
        var issueView;

        issueView = new App.IssueView({
            model : issue
        });

        issueView.render().$el.appendTo(this.$columns[issue.get('stage')-1]);
    }

});

/**
 * Вьюха для всей доски с фичами и ишью.
 * Должна попилить коллекцию всех ишью на группы и создать соответсвующие группы.
 */
App.BoardView = Backbone.View.extend({

    template : App.JST['issues/board'],

    $groupsContainer : null,

    groups : [],

    events : {


    },

    initialize : function (){

        var self = this;

        this.collection.bind('reset', this.render, this);

        this.$el.html(this.template.layout);

        this.$groupsContainer = this.$('.issues-groups');


        var features = new App.Issues(this.collection.filter(function (issue){
            return issue.get('is_feature')==1;
        }));


        //разбиваем по группам

        //самая первая группа - с ишью, не привязанными ни к какой фиче
        this.groups = [
            {
                feature : null,
                issues : new App.Issues(this.collection.filter(function (issue){
                    return !issue.get('is_feature') && issue.get('parent_feature') == 0;
                }))
            }
        ];

        features.each(function(feature){

            self.groups.push({
                feature : feature,
                issues : new App.Issues(self.collection.filter(function (issue){
                    return !issue.get('is_feature') && issue.get('parent_feature') == feature.id;
                }))
            });

        });


    },


    render : function (){

        var i;

        this.$groupsContainer.empty();
        for (i=0; i<this.groups.length; i++){
            this.addGroup(this.groups[i]);
        }

        return this;
    },

    addGroup : function (group){
        var groupView;

        groupView = new App.IssuesGroupView({
            model : group.feature,
            collection : group.issues
        });

        groupView.render().$el.appendTo(this.$groupsContainer);
    }


});