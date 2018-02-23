$(document).ready(function() {
	
	$(".pagination-ajax").each(function(){
		
		//Tag: .pagination-ajax[data-form]	
		var $form = null;
		
		//Tag: .pagination-ajax[data-target]	
		var $target = null;	
		
		//Tag: .pagination-ajax[data-url] ou form[action]	
		var url = "";
		
		//Tag: li, criadas dinamicamente
		var $navs = [];

		//Tag: .pagination-ajax
		var $parent = $(this);
		
		url = $parent.attr('data-url');		
		$form = $($parent.attr('data-form'));
		var hasForm = ($form.length > 0);
		
		if (hasForm) url = $form.attr('action');
		
		$target = $($parent.attr('data-target'));	
		
		var hasForm = ($form.length > 0);
		
		var $home = $("<li><a href='#' class='home'><i class='fa fa-fast-backward'></i>&nbsp;</a></li>");
		var $prev = $("<li class='disabled'><a href='#' class='prev'><i class='fa fa-backward'></i>&nbsp;</a></li>");
		var $next = $("<li><a href='#' class='next'><i class='fa fa-forward'></i>&nbsp;</a></li>");				

		$(this).empty();
		$navs = [];
		
		for (i = 1; i <= 5 ; i++){
			var $li = $("<li><a href='#' class='page'>"+i+"</a></li>");
			$navs.push($li);
		}
		$current = $navs[0];
		
		
		$home.click(function(){
			if ($home.hasClass('disabled')) return false;
			$prev.addClass('disabled');
			$navs.forEach(function($nav, i){
				$('a', $nav).text(i+1);
			});			
			$navs[0].click();			
		});
		
		$prev.click(function(){
			if ($prev.hasClass('disabled')) return false;
			
			if (parseInt($('a', $current).text()) <= 10){
				$home.addClass('disabled');
				$prev.addClass('disabled');
			}					
			$navs.forEach(function($nav){
				var $a = $('a', $nav);
				$a.text(parseInt($a.text())-5);
			});
			
			$current.click();			
		});

		$next.click(function(){
			if ($next.hasClass('disabled')) return false;					
			$navs.forEach(function($nav){
				var $a = $('a',$nav);
				$a.text(parseInt($a.text())+5);
			});
			$home.removeClass('disabled');
			$prev.removeClass('disabled');
			$current.click();
		});

		$navs.forEach(function($nav, i){			
			$nav.click(function(){
				
				var page = parseInt($('a', $nav).text());				
				var data = "page="+page;
				if (hasForm)
					//$("[name='page']", $form).val(page);
					data = data + "&" + $form.serialize();
				
				if (page == "1")
					$home.addClass('disabled');
				else
					$home.removeClass('disabled');	
				
				//$fallback = $("<li class='disabled'><a href='#'><i class='fa fa-spin fa-spinner'></i>&nbsp;</a></li>");	
				//$parent.prepend($fallback);
				$target.load(url, data, function(response){
					if (response.length == 0){
						$target.text('Sem registros.');
						
						$navs.forEach(function($_nav){
							if (parseInt($('a',$_nav).text()) > page)
								$_nav.addClass('disabled');
						});						
						
						$next.addClass('disabled');						
					} else {
						$navs.forEach(function($_nav){
							if (parseInt($('a',$_nav).text()) > page)
								$_nav.removeClass('disabled');
						});
						$next.removeClass('disabled');
					}
					//$fallback.remove();
					$navs.forEach(function($_nav){$_nav.removeClass('active')});
					$nav.addClass('active');
					$current = $nav;
				});				
								
			});
		});
		
		$form.submit(function(event){
			event.preventDefault();
			$current.click();
			return false;
		});		
	
		$parent
			.append($home)
			.append($prev)
			.append($navs)
			.append($next);
		
		$current.click();
						
	});
});

