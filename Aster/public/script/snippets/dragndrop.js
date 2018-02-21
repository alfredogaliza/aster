// Funções Drag-n-Drop
var $droparea = $("<div class='droparea'>");
var $dragged = null;

$(document).on('dragstart', function(event) {
	$dragged = $(event.target).parents('.panel');
	event.originalEvent.dataTransfer.setDragImage($dragged[0], 0, 0);
	$('.droppable').append($droparea);
}).on('dragover', function(event) {
	event.preventDefault();
}).on('dragend', function(event) {
	$('.droparea').remove();
});

$(document).on('drop', function(event) {
	event.preventDefault();
	
	var $target = $(event.target);
	if ($target.hasClass('droparea')) {
		$new = $dragged.clone();
		$target.append($new);
		$new.unwrap('.droparea');
		$dragged.remove();
	}
	$('.droparea').remove();
	
});