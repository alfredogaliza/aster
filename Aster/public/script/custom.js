var datetimepicker_tooltips = {
    today: 'Hoje',
    clear: 'Limpar Seleção',
    close: 'Fechar',
    selectMonth: 'Selecionar o Mês',
    prevMonth: 'Mês Anterior',
    nextMonth: 'Próximo Mês',
    selectYear: 'Selecionar o Ano',
    prevYear: 'Ano Anterior',
    nextYear: 'Próximo Ano',
    selectDecade: 'Selecionar Década',
    prevDecade: 'Década Anterior',
    nextDecade: 'Próxima Década',
    prevCentury: 'Século Século',
    nextCentury: 'Próximo Século'
}

var datetimepicker_options = {
	stepping: 5,
	tooltips: datetimepicker_tooltips,
	dayViewHeaderFormat: 'DD MMMM YYYY',
	format: 'DD/MM/YYYY',
	locale: 'pt-BR',
	showTodayButton: true,
	showClear: true,
	showClose: true
}; 

function init(event){
	
	var parent = event.target? event.target : document;
	
	$('[data-toggle="tooltip"]', parent).tooltip();
	
	$("[multiple]", parent).multiselect({
		numberDisplayed: 1
	});
	
	$('.dateyear', parent).datetimepicker($.extend(datetimepicker_options, {format: 'YYYY'}));
	$('.date', parent).datetimepicker($.extend(datetimepicker_options, {format: 'DD/MM/YYYY'}));
	$('.birthday', parent).datetimepicker($.extend(datetimepicker_options, {format: 'DD/MM'}));
	$('.date.end', parent).datetimepicker($.extend(datetimepicker_options, {format: 'DD/MM/YYYY',useCurrent: false}));
	$('.datetime', parent).datetimepicker($.extend(datetimepicker_options, {format: 'DD/MM/YYYY HH:mm', sideBySide:true}));
	$('.datetime.end', parent).datetimepicker($.extend(datetimepicker_options, {format: 'DD/MM/YYYY HH:mm', sideBySide:true, useCurrent: false}));
	
	$(".start", parent).on("dp.change", function (e) {
		$end = $(this).attr('data-end');
        $($end).data("DateTimePicker").minDate(e.date);
    });
	
	$(".end", parent).on("dp.change", function (e) {
		$start = $(this).attr('data-start');
        $($start).data("DateTimePicker").maxDate(e.date);
    });
	
	$(".telefone", parent).mask("(99) 9999-9999?9")
    .focusout(function (e) {  
        var target, phone, element;  
        target = (e.currentTarget) ? e.currentTarget : e.srcElement;  
        phone = target.value.replace(/\D/g, '');
        element = $(target);  
        element.unmask();  
        if(phone.length > 10) {  
            element.mask("(99) 99999-999?9");  
        } else {  
            element.mask("(99) 9999-9999?9");  
        }  
    });
	
	$(".cep", parent).mask("99.999-999");
	$(".cpf").mask("999.999.999-99");	
	$(".money", parent).maskMoney({
		prefix:'R$ ',
		allowNegative: false,
		thousands: '',
		decimal: '.',
		affixesStay: false
		}
	);
	
	$(".real", parent).maskMoney({
		prefix:'',
		allowNegative: false,
		thousands: '',
		decimal: '.',
		affixesStay: false
		}
	);
	
	$(".integer", parent).maskMoney({
		prefix:'',
		allowNegative: false,
		thousands: '',
		decimal: '',
		precision: 0,
		affixesStay: false
		}
	);
}

$(function(){	
	
	$(this).on("click", ".confirm", function(event){
		if (confirm("Essa ação não poderá ser desfeita! Confirma a ação?")){
			return true;
		} else {
			event.stopImmediatePropagation();
			return false;
		}
	});
	
	$(this).on("click", ".delete", function(){
		return confirm("Deseja realmente excluir este item?");
	});

	$(this).on("click", ".async", function(event){
		event.preventDefault();
		var href = $(this).attr("href")? $(this).attr("href") : $(this).attr("data-href");
		var pagination = $(this).attr('data-pagination');
		$.ajax(href).done(function(){
			if (pagination != '') $('.page', pagination).click();
			else location.reload();
		});
	});
	
	$(this).on("click", ".async-confirm", function(event){
		event.preventDefault();		
		var href = $(this).attr("href")? $(this).attr("href") : $(this).attr("data-href");
		var pagination = $(this).attr('data-pagination');
		if (confirm("Deseja realmente executar esta operação?")){
			$.ajax(href).done(function(){
				if (pagination != '') $('.page', pagination).click();
				else location.reload();
			});
		}
	});
	
	$(this).on("click", ".edit", function(event){
		event.preventDefault();				
		var href =  $(this).attr("href")?  $(this).attr("href") : $(this).attr("data-href");
		$("#modal-container").load(href);
		return false;
	});
	
	$(this).on("click", ".change-status", function(event){
		event.preventDefault();
		$('#status').val($(this).attr('data-status'));
		$('#form-busca').submit();
		return false;
	});
	
	$(this).on("submit", "form", function(){
		$("button[type='submit']", this).html("<i class='fa fa-spinner fa-pulse'></i> Carregando...").prop("disabled", true);
		$("input[type='submit']", this).val("Carregando...").prop("disabled", true);
		return true;
	});
	
	$(this).on("submit", ".form-async", function(e){
		
		e.preventDefault();
		
		$("button[type='submit']", this).html("<i class='fa fa-spinner fa-pulse'></i> Carregando...").prop("disabled", true);
		$("input[type='submit']", this).val("Carregando...").prop("disabled", true);
		
		$.post(
				$(this).attr('action'),
				$(this).serialize(),
				function(response){
					if (response == ""){
						location.reload(true);
						//$("#modal").modal("hide");
					} else {
						console.log(response);
					}
					$("button[type='submit']", this).html("<i class='fa fa-refresh'></i> Tentar Novamente").prop("disabled", false);
					$("input[type='submit']", this).val("Tentar Novamente").prop("disabled", false);
				}
			);
		
		return false;
	});	
	
	
	
	$(this).on('ajax.complete', '*', init);
	
}).ready(init);