(function () {
    site.init = function () {
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