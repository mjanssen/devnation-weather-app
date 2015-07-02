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