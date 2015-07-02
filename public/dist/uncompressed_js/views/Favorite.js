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