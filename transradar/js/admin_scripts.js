jQuery(document).ready(function($) {

// clicks start -------------
$('.fa-caret-square-o-down').click(function() {
  $(this).hide();
  $(this).parent().find('.fa-caret-square-o-up').show()
  $(this).parent().parent().find('.items_box').show();
});
$('.fa-caret-square-o-up').click(function() {
  $(this).hide();
  $(this).parent().find('.fa-caret-square-o-down').show()
  $(this).parent().parent().find('.items_box').hide();
});

var counter = $('input[name=counter]').val()-1;
console.log('categories - '+counter);
$('.main_item>.fa-minus-circle').click(function() {
	if( confirm('Вы точно хотите удалить этот раздел?') ) { 
  	$(this).parent().remove();
  	counter--;
  	$('input[name=counter]').val(counter);
  	console.log('categories - '+counter);
  	ChangeNameIndex();
 	} else {
  	console.log('not deleted');
 	} 
});
$('.item_box>.fa-minus-circle').click(function() {
	if( confirm('Вы точно хотите удалить этот вопрос-ответ?') ) { 
  	$(this).parent().remove();
 	} else {
  	console.log('not deleted');
 	} 
});

$('.add_question').click(function() {
	var prev_q_name = $(this).prev().find('.faq_input').attr('name');
	var prev_a_name = $(this).prev().find('.faq_textarea').attr('name');
	$('.prototype .item_box').clone(true, true) // сделаем копию
		.insertBefore($(this)); // вставим измененный элемент в конец элемента clone
		$(this).prev().find('.faq_input').attr('name', prev_q_name);
		$(this).prev().find('.faq_textarea').attr('name', prev_a_name);
});
$('.add_section').click(function() {
	counter++;
  	$('input[name=counter]').val(counter);
  	console.log('categories - '+counter);
	$('.prototype .main_item').clone(true, true) // сделаем копию 
		.insertBefore($(this)); // вставим измененный элемент в конец элемента clone
	$('.main_item_name:last').attr('name', 'main_item_name['+counter+']');
	$('.faq_input:last').attr('name', 'question['+counter+'][]');
	$('.faq_textarea:last').attr('name', 'answer['+counter+'][]');
	ChangeNameIndex();
});

function ChangeNameIndex() {
	var	counter_temp = counter+2;
	var i = -1;
	$(".main_item_name").each(
	    function() {
	      $(this).attr('name','main_item_name['+i+']');
	      console.log($(this).attr('name'));
	      i++;
	      if (i==counter_temp) {
	      	return false;
	      }
	    }
	);
}

$('.trash_ico').click(function(){
	console.log($(this));
    if( confirm('удалить логотип?') ) { 
        $(this).next().attr('type', 'file');
        $(this).next().val('');
        $(this).prev().remove();
        $(this).remove();
    } else {
        console.log('not deleted');
    }
});    

// clicks end -------------

// function confirmation() { 
// 	if( confirm('Вы хотите отформатировать C ?') ) 
//  { 
//   document.getElementById('yn').value = 1; 
//  } 
//  else 
//  { 
//   document.getElementById('yn').value = 0; 
//  } 
//  document.forms['form1'].submit(); 
// }

});