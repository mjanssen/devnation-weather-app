(function() {

    getLocation();

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            console.log('Geolocation is not supported by this browser.');
        }
    }

    function showPosition(position) {

        var data = { longitude: position.coords.latitude, latitude: position.coords.longitude };

        $.post('/ajax/location/getAddress', data)
            .done(function(result) {
                var address = JSON.parse(result);
                getWeatherForCity(address.city);
            });
    }

    function getWeatherForCity(city) {

        $.getJSON("/ajax/weather/city/" + city, function(data){

            console.log(data);
        });
    }
})();
(function () {
    window.site = {};
    site.$document = $(document);
    site.views = {};
    site.collections = {};
    site.models = {};
    site.routers = {};
    site.router;
    site.events = _.clone(Backbone.Events);
})();

console.log('%c' + 'Weatherapp by Colin & Marnix', 'background: #00BCD4; color: #ffffff; padding: 3px 5px;');
site.models.Favorite = Backbone.Model.extend({});
site.models.Location = Backbone.Model.extend({});
site.collections.Favorites = Backbone.Collection.extend({
    model: site.models.Favorite,
    url: 'http://localhost/weatherapp/favorites.json'
});
site.collections.Locations = Backbone.Collection.extend({
    model: site.models.Location,
    baseUrl: 'http://weather.devnation.net/ajax/weather/city/'
});
site.routers.Weather = Backbone.Router.extend({
    routes: {
        'info/:city': 'cityAction',
        'info/:city/:compare': 'compareTwo',
        'info/:city/:compare/:third': 'compareThree',
        'map': 'mapAction'
    },

    cityAction: function (city) {
        site.events.trigger('newLocation', {
            location: city
        });
    },

    compareTwo: function(city, compare){
        console.log('two');
        site.events.trigger('newComparison', {
            city: city,
            compare: compare
        });
    },

    compareThree: function(city, compare, third){
        site.events.trigger('newComparison', {
            city: city,
            compare: compare,
            third: third
        });
    },

    mapAction: function(){
        console.log('Map');
    }

});
site.views.Compare = Backbone.View.extend({
    templateLocation: _.template(site.settings.templates.location),
    templateError: _.template(site.settings.templates.error),

    initialize: function () {
        site.events.on('newComparison', this.loadLocations, this);
        console.log('compare has been loaded');
    },

    loadLocations: function (data) {
        console.log(data);
        this.$el.html('');
        this.collection.url = this.collection.baseUrl + data.city + '&units=metric';
        this.collection.fetch({
            success: _.bind(this.loadLocationSuccessHandler, this),
            error: _.bind(this.loadLocationErrorHandler, this)
        });

        this.collection.url = this.collection.baseUrl + data.compare + '&units=metric';
        this.collection.fetch({
            success: _.bind(this.loadLocationSuccessHandler, this),
            error: _.bind(this.loadLocationErrorHandler, this)
        });

        if(data.third) {
            this.collection.url = this.collection.baseUrl + data.third + '&units=metric';
            this.collection.fetch({
                success: _.bind(this.loadLocationSuccessHandler, this),
                error: _.bind(this.loadLocationErrorHandler, this)
            });
        }
    },

    loadLocationSuccessHandler: function (collection, response, options) {
        this.$el.append(this.templateLocation({location: response}));
    },

    loadLocationErrorHandler: function (collection, response, options) {
        this.$el.append(this.templateError());
    }
});
site.views.CompareInput = Backbone.View.extend({
    template: _.template(site.settings.templates.compare),

    events: {
        'click .btn': 'search'
    },

    initialize: function(){
        this.render();
    },


    search: function(e){
        e.preventDefault();
        site.router.navigate('info/' + this.$('input').val(), {trigger: true, replace: true});
    },

    render: function () {
        this.$el.html(this.template());
        return this;
    }
});
site.views.Favorite = Backbone.View.extend({
    template: _.template(site.settings.templates.favorite),

    events: {
        'click': 'showDetail'
    },


    showDetail: function(e){
        e.preventDefault();
        var $target = $(e.currentTarget);
        //site.events.trigger('newLocation', {
        //    location: $target.data('city')
        //});
        site.router.navigate('info/' + $target.data('city'), {trigger: true, replace: true});
    },

    render: function (attributes) {
        this.setElement(this.template({favorite: attributes}))
        //this.$el.html(this.template({favorite: attributes}));
        return this;
    }
});
site.views.Favorites = Backbone.View.extend({
    templateFavorites: _.template(site.settings.templates.favorites),
    templateError: _.template(site.settings.templates.error),

    initialize: function () {
        this.loadFavorites();
    },

    /**
     *
     */
    loadFavorites: function () {
        this.collection.fetch({
            success: _.bind(this.loadFavoritesSuccessHandler, this),
            error: _.bind(this.loadFavoritesErrorHandler, this),
            data: {}
        });
    },

    /**
     *
     * @param collection
     * @param response
     * @param options
     */
    loadFavoritesSuccessHandler: function (collection, response, options) {
        console.log(response);
        //this.$el.html(this.templateFavorites({favorites: response}));
        this.collection.each(this.addOne, this);
    },

    /**
     *
     * @param collection
     * @param response
     * @param options
     */
    loadFavoritesErrorHandler: function (collection, response, options) {

    },

    addOne: function(e){
        var favoriteView = new site.views.Favorite({
            model: site.models.Favorite,
        });
        this.$el.append(favoriteView.render(e.attributes).el);
    }
});
site.views.Location = Backbone.View.extend({
    templateLocation: _.template(site.settings.templates.location),
    templateError: _.template(site.settings.templates.error),

    initialize: function () {
        site.events.on('newLocation', this.loadLocation, this);
    },

    /**
     *
     * @param data
     */
    loadLocation: function (data) {
        this.collection.url = this.collection.baseUrl + data.location;
        console.log(this.collection.url);
        this.collection.fetch({
            success: _.bind(this.loadLocationSuccessHandler, this),
            error: _.bind(this.loadLocationErrorHandler, this)
        });
    },

    /**
     *
     * @param collection
     * @param response
     * @param options
     */
    loadLocationSuccessHandler: function (collection, response, options) {
        console.log(response[0]);
        response[0].day = 'Today';
        this.$el.html(this.templateLocation({location: response}));
    },

    /**
     *
     * @param collection
     * @param response
     * @param options
     */
    loadLocationErrorHandler: function (collection, response, options) {
        console.log(response);
    }
});
(function () {
    site.init = function () {
        alert('nigguh');
        site.router = new site.routers.Weather();

        var favoritesCollection = new site.collections.Favorites();
        var locationsCollection = new site.collections.Locations();

        var favoritesView = new site.views.Favorites({el: "#favorites", collection: favoritesCollection});
        var locationView = new site.views.Location({el: "#location", collection: locationsCollection});
        var compareInputView = new site.views.CompareInput({el: '#compare'});
        var compareView = new site.views.Compare({el: '#location', collection: locationsCollection});

        Backbone.history.start({pushState: true, root: site.settings.basePath});

        $('.switch').on('click', function(e){
            e.preventDefault();
           $('body').toggleClass('night-mode');
            if($('body').attr('class') == 'night-mode'){
                $('.switch').html('Night');
            } else {
                $('.switch').html('Day')
            }
        });
    };

    site.$document.on('ready', site.init);
})();