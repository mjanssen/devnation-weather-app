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