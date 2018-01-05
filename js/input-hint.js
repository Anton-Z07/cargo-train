(function( $ ) {
    $.fn.inputHint = function(url) {
    	return this.each(function() {
    		$(this).attr('src', url);
    		$(this).after('<div class="search-autocomplete"><ul></ul></div>');		
    		$(this).keydown(SearchHintsNavigate);
			$(this).keyup(ShowSearchHints);
			var that = $(this);
			$('body').click(function(e){
				if ($(e.target).hasClass('autocomplete-li')) return;
				autocomplete = that.next();
				autocomplete.hide();
			});
    	});
    };
 
    function SearchHintsNavigate(e)
	{
		autocomplete = $(this).next();
		if (e.keyCode == 40 || e.keyCode == 38)
		{
			var hints_count;
			if (hints_count = autocomplete.find('li').size())
			{
				var sel_num = -1;
				autocomplete.find('li').each(function(i) {
					if ($(this).hasClass('selected'))
						sel_num = i;
				});
				if (e.keyCode == 40 && ++sel_num >= hints_count) return;
				autocomplete.find('li.selected').removeClass('selected');
				if (e.keyCode == 40 || (e.keyCode == 38 && --sel_num >= 0))
				{
					if (e.keyCode == 40 && sel_num == 0)
						$(this).attr('old-data',$(this).val());
					$(this).val(autocomplete.find('li').eq(sel_num).attr('data'));
					autocomplete.find('li').eq(sel_num).addClass('selected');
				}
				else if (e.keyCode == 38 && sel_num == -1)
					$(this).val($(this).attr('old-data'));
			}
			e.preventDefault();
		}
		if (e.keyCode == 13 && autocomplete.find('li:visible').size())
			e.preventDefault();
		if (e.keyCode == 13 || e.keyCode == 9 || e.keyCode == 27)
			autocomplete.hide();
	}

	function ShowSearchHints(e)
	{
		autocomplete = $(this).next();
		if ((e.keyCode >= 37 && e.keyCode <= 40 ) || e.keyCode == 13 || e.keyCode == 27) return;
		if ($(this).val().length < 1) 
		{
			autocomplete.hide();
			return;
		}
		var that = $(this);
		$.getJSON($(this).attr('src') + '?q='+$(this).val(), function(data){
			if(Object.keys(data).length)
			{
				autocomplete.find('li').remove();
				for (i in data)
				{
					var hint = data[i];
					autocomplete.find('ul').append('<li class="autocomplete-li" data="'+hint+'">'+hint+'</li>');
				}
				autocomplete.css('width', that.outerWidth());
				autocomplete.css('left', that.position().left);
				autocomplete.find('li').click(function(){ OnSearchHintSelect($(this).attr('data'), autocomplete, that); });
				autocomplete.show();
			}
			else
				autocomplete.hide();
		});
	}

	function OnSearchHintSelect(data, autocomplete, input)
	{
		autocomplete.hide();
		input.val(data);
	}

}( jQuery ));