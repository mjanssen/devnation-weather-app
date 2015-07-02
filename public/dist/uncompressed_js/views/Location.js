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