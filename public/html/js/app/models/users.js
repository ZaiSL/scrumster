

App.User = Backbone.Model.extend({

//    urlRoot : _live_site + '/users',

    defaults : {
        'username'  : '',
        'email'     : '',
        'avatar'    : ''
    }

});


App.Users = Backbone.Collection.extend({

    model : App.User,

    localStorage: new Store("youboard-users")

});