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