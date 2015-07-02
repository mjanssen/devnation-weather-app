site.collections.Locations = Backbone.Collection.extend({
    model: site.models.Location,
    baseUrl: 'http://weather.devnation.net/ajax/weather/city/'
});