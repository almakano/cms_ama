var app = {
	init: function(){
		var d = $(document);
		var w = $(window);

		w.on('resize scroll', function(e){
			app.onload();
		});
		d.ajaxComplete(function(){
			app.onload();
		});
		d.on('click', function(e){
			app.onload();

			var th = $(e.target);
			th.filter('[data-toggle="sidebar"]').each(function(){
				var target = $(th.attr('data-target'));
				var target_class = target.hasClass('sidebar-left')?'sidebar-left-open':'sidebar-left-open';
				th.toggleClass('active');
				$('body').toggleClass(target_class);
			});
			th.filter('[data-toggle="sidebar_close"]').each(function(){
				$('[data-toggle="sidebar"].active').removeClass('active');
				$('body').removeClass('sidebar-left-open sidebar-right-open');
			});
		});

		app.onload();
	},
	onload: function(){
		$('[data-onload-src]').not('.loading').each(function(){
			var th = $(this);
			var target_selector = th.attr('data-target') || this;
			var src = th.attr('data-onload-src');
			var target = $(target_selector);

			th.addClass('loading');
			target.load(src, function(response, status, xhr){
				th.removeClass('loading');
				th.removeAttr('data-onload-src');
			});
		});
	}
};

$(function(){
	app.init();
});