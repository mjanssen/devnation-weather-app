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