site.collections.Favorites = Backbone.Collection.extend({
    model: site.models.Favorite,
    url: '/dist/data/favorites.json'
});