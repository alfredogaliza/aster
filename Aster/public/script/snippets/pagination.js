$(document).ready(function() {
	
	$(".pagination-ajax").each(function(){
		
		//Tag: .pagination-ajax[data-form]	
		var $form = null;
		
		//Tag: .pagination-ajax[data-target]	
		var $target = null;	
		
		//Tag: .pagination-ajax[data-url] ou form[action]	
		var url = "";		

		//Tag: .pagination-ajax
		var $parent = $(this);
		
		url = $parent.attr('data-url');		
		$form = $($parent.attr('data-form'));
		var hasForm = ($form.length > 0);
		
		if (hasForm) url = $form.attr('action');
		
		$target = $($parent.attr('data-target'));	
		
		var hasForm = ($form.length > 0);
		
		var $home = $("<li><a href='#' class='home'><i class='fa fa-fast-backward'></i>&nbsp;</a></li>");
		var $prev = $("<li><a href='#' class='prev'><i class='fa fa-step-backward'></i>&nbsp;</a></li>");
		var $page = $("<li data-number='1'><a href='#' class='page'>1</a></li>")
		var $next = $("<li><a href='#' class='next'><i class='fa fa-step-forward'></i>&nbsp;</a></li>");				

		$(this).empty();
		
		$home.click(function(e){
			e.preventDefault();
			if ($home.hasClass('disabled')) return false;
			$page.attr('data-number', 1).click();
		});
		
		$prev.click(function(e){
			e.preventDefault();
			if ($prev.hasClass('disabled')) return false;
			var page = parseInt($page.attr("data-number")) - 1;
			$page.attr("data-number", page).click();		
		});

		$next.click(function(e){
			e.preventDefault();
			if ($next.hasClass('disabled')) return false;
			var page = parseInt($page.attr("data-number")) + 1;
			$page.attr("data-number", page).click();		
		});
		
		$page.click(function(e){
			e.preventDefault();
			
			var page = parseInt($(this).attr('data-number'));				
			var data = "page="+page;
			
			if (hasForm) data = data + "&" + $form.serialize();
			
			if (page == 1) {
				$home.addClass('disabled');
				$prev.addClass('disabled');
			}
			else {
				$home.removeClass('disabled');
				$prev.removeClass('disabled');
			}
			
			$target.load(url, data, function(response){
				if (response.length == 0){
					$target.text('Sem registros.');					
					$next.addClass('disabled');						
				} else {					
					$next.removeClass('disabled');
				}
				$('a', $page).text(page);
				$target.trigger("ajax.complete");
			});				
							
		});
		
		$form.submit(function(event){
			event.preventDefault();
			$page.click();
			return false;
		});		
	
		$parent
			.append($home)
			.append($prev)
			.append($page)
			.append($next);
		
		$page.click();
						
	});
});

