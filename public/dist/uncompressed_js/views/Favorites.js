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