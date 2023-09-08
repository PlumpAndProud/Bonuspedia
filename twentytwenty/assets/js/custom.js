/**
 * Copy a string to clipboard
 * @param  {String} string         The string to be copied to clipboard
 * @return {Boolean}               returns a boolean correspondent to the success of the copy operation.
 */
function copyToClipboard(string) {
  let textarea;
  let result;

  try {
    textarea = document.createElement('textarea');
    textarea.setAttribute('readonly', true);
    textarea.setAttribute('contenteditable', true);
    textarea.style.position = 'fixed'; // prevent scroll from jumping to the bottom when focus is set.
    textarea.value = string;

    document.body.appendChild(textarea);

    textarea.focus();
    textarea.select();

    const range = document.createRange();
    range.selectNodeContents(textarea);

    const sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);

    textarea.setSelectionRange(0, textarea.value.length);
    result = document.execCommand('copy');
  } catch (err) {
    console.error(err);
    result = null;
  } finally {
    document.body.removeChild(textarea);
  }

  // manual copy fallback using prompt
  if (!result) {
    const isMac = navigator.platform.toUpperCase().indexOf('MAC') >= 0;
    const copyHotkey = isMac ? '⌘C' : 'CTRL+C';
    result = prompt(`Press ${copyHotkey}`, string); // eslint-disable-line no-alert
    if (!result) {
      return false;
    }
  }
  return true;
}
/*!
 * clipboard.js v2.0.6
 * https://clipboardjs.com/
 * 
 * Licensed MIT © Zeno Rocha
 */
 
Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

( function( $) {


function BonusModalShow( modal_code ){
		if(modal_code.substr(0,9)=='showcode-'){
		var id;
		id = modal_code.replace('showcode-','');
		
		if(id)
			$.get('/wp-json/wp/v2/kody/'+id+'?_embed', function(data){
				
				$.each( data, function(k,v){
					if( $('#bonusModal .modal_result .'+k).length)
						$('#bonusModal .modal_result .'+k).html(v);
						if( k=='acf' || k=='title'|| k=='content' )
						$.each( v, function(kc,vc){
									if($('#bonusModal .modal_result .'+k+"_"+kc).length)
											$('#bonusModal .modal_result .'+k+"_"+kc).html(vc);
								});
					});
				if( data.acf){
					if( data.acf.cta_link ){
						$('#bonusModal .acf_link a').attr('href',data.acf.cta_link )
					}else{
						$('#bonusModal .acf_link a').attr('href',"#" )
					}
					if( data.acf.cta_link ){
						$('#bonusModal .acf_link a').text(data.acf.cta_nazwa )
					}
					
					
					$('#bonusModal .btn-cpy').data('cpycode-id', id);
					$('#bonusModal .btn-cpy').data('cpycode-code', data.acf.kod);
					if(data.acf.urlafter)
						$('#bonusModal .btn-cpy').data('cpycode-code', data.acf.urlafter);
						else
						$('#bonusModal .btn-cpy').data('cpycode-code', '#');
					
				}
					
				var img='';
				if( data._embedded )
					if( data._embedded['wp:featuredmedia'] )
						$.each( data._embedded['wp:featuredmedia'] , function (k,v){
							if(v.source_url)
								img='<img src="'+v.source_url+'" >';
						})
				$('#bonusModal .modal_result .topimg').html( img );
				var datato = $('#bonusModal .timerTime span').text();
				
				if(datato !='Oferta wygasła' )
				$('#bonusModal .timerTime span').countdown( datato, function(event) {
							  $(this).html(event.strftime('%D dni %H:%M:%S'));
							}).on('finish.countdown', function(event) {
							  $(this).html('Oferta wygasła!')
							    .parent().addClass('disabled');
							});
				$("#bonusModal").modal('show');			
		});
	}/* if url has modal code string*/
}


$(document).ready( function(){
	
	$(".countdownme").each( function(){
				var da =$(this).text();
				$(this).removeClass('countdownme');
				$(this).countdown( da , function(event) {
							  $(this).html(event.strftime('%D dni %H:%M:%S'));
							}).on('finish.countdown', function(event) {
							  $(this).html('Oferta wygasła!')
							    .parent().addClass('disabled');
							});
			});		
			

var modal_code = window.location.href.split('#')[1];

if( modal_code ){
	BonusModalShow( modal_code );
}/* */

$('.type-kody').on('click', 'a.main-link.read-more-wrap', function(e){
	e.preventDefault();
	var modal_code_local = $(this).attr('href').split('#')[1];

	if( modal_code_local )
		BonusModalShow( modal_code_local );
})

$('.type-kody').on('click','.archive-kody', function(e){
	e.preventDefault();
	var modal_code_local = $(this).data('href').split('#')[1];

	if( modal_code_local )
		BonusModalShow( modal_code_local );
});

$('.tag .bottom-category ').on('click','.archive-kody', function(e){
	e.preventDefault();
	var modal_code_local = $(this).data('href').split('#')[1];

	if( modal_code_local )
		BonusModalShow( modal_code_local );
		/*
	e.preventDefault();
	var modal_code_local = $(this).data('href');

	if( modal_code_local )
		document.location.href = modal_code_local;
		*/
});

	$(".as_popup, type-kody").on('click', 'a.main-link.read-more-wrap', function(e){
		e.preventDefault();
		var id= $(this).data('id');
		
		if(id)
			$.get('/wp-json/wp/v2/bonusy/'+id+'?_embed', function(data){
				console.log( data);
				
				$.each( data, function(k,v){
					if( $('#bonusModal .modal_result .'+k).length)
						$('#bonusModal .modal_result .'+k).html(v);
						if( k=='acf' || k=='title'|| k=='content' )
						$.each( v, function(kc,vc){
									if($('#bonusModal .modal_result .'+k+"_"+kc).length)
											$('#bonusModal .modal_result .'+k+"_"+kc).html(vc);
								});
					});
				if( data.acf)
				if( data.acf.cta ){
					$('#bonusModal .acf_link a').attr('href',data.acf.cta )
				}else{
					$('#bonusModal .acf_link a').attr('href',"#" )
				}
				var img='';
				if( data._embedded )
					if( data._embedded['wp:featuredmedia'] )
						$.each( data._embedded['wp:featuredmedia'] , function (k,v){
							if(v.source_url)
								img='<img src="'+v.source_url+'" >';
						})
				$('#bonusModal .modal_result .topimg').html( img );
				var datato = $('#bonusModal .timerTime span').text();
				$('#bonusModal .timerTime span').countdown( datato, function(event) {
							  $(this).html(event.strftime('%D dni %H:%M:%S'));
							}).on('finish.countdown', function(event) {
							  $(this).html('Oferta wygasła!')
							    .parent().addClass('disabled');
							});
							
		});
			
			
			
		$("#bonusModal").modal('show');
		/*$('#bonusModal .modal_result').load(url+' article', function() {
			var title = $('#bonusModal .modal_result').find('header').html();
			
			$('#bonusModal .modal_result').find('header').remove();			
			$('#bonusModal .modal_result').find('nav').remove();	
			
			$('#bonusModal .modal_result').find('.activeto').remove();
			$('#bonusModal .modal_result').find('.post-inner').first().prepend( title )
			$('#bonusModal .modal_result article > .section-inner').remove();
					console.log( datato );
			
			var datato = $('#bonusModal .modal_result').find('.activeto').first().text();
			if(datato)
				$('#bonusModal .timerTime span').countdown( datato, function(event) {
							  $(this).html(event.strftime('%D dni %H:%M:%S'));
							}).on('finish.countdown', function(event) {
							  $(this).html('Oferta wygasła!')
							    .parent().addClass('disabled');
							});
				

		});
		*/

	});
	$.get('/wp-json/wp/v2/kody', function(data){
		$("table.loadhomecode tbody").html('');
		$.each( data, function(k,v){
			if(v.acf.firma){
				var text ='<tr>';
				text +='<td><img src="'+cy_tdir+'/'+v.acf.firma.toLowerCase().replace(' ',"_")+'.png"/></td>';
				text +='<td>'+v.acf.kwota+'</td>';
				text +='<td>'+v.acf.podsumowanie+'</td>';
				text +='<td>'+v.acf.kiedy_otrzymam+'</td>';
				text +='<td> <div class="timer"> </div> <span class="countdownme">'+v.acf.kiedy_wygasa+'</div></td>';
				text +='<td><span class="btn-code actions showcode" data-url="'+v.link+'" data-id="'+v.id+'">Odkryj kod</span></td>';
				text +='</tr>';
				$("table.loadhomecode tbody").append(text);
			}
			/*
			<span class="actions showcode" data-url="'+v.link+'" data-id="'+v.id+'">Odkryj kod</span>
			*/
			
			$(".countdownme").each( function(){
				var da =$(this).text();
				$(this).removeClass('countdownme');
				$(this).countdown( da , function(event) {
							  $(this).html(event.strftime('%D dni %H:%M:%S'));
							}).on('finish.countdown', function(event) {
							  $(this).html('Oferta wygasła!')
							    .parent().addClass('disabled');
							});
			});		
		});
	});
	$(document).on('click','.showcode', function(){
		var id = $(this).data('id');
		if(id){
			$.get('/wp-json/wp/v2/kody/'+id, function(data){
				if(data.title.rendered)
				$('#kodyModal').find('.title').html( data.title.rendered );
				if(data.acf.logo_popup_kody)
					$('#kodyModal').find('.logo').html('<img src="'+data.acf.logo_popup_kody.url+'"/> ');
					
				if( data.acf.kod )
				$('#kodyModal').find('.code').text( data.acf.kod);
				if(data.acf.kiedy_wygasa)
				$('#kodyModal').find('.countdownmehere').html( data.acf.kiedy_wygasa );
				$("#kodyModal").modal('show');
				
				$('#kodyModal .btn-cpy').text( $('#kodyModal .btn-cpy').data('default') );
				
				$('#kodyModal .btn-cpy').data('cpycode-id', id);
				if(data.acf.kod)
					$('#kodyModal .btn-cpy').data('cpycode-code', data.acf.kod);
					else
					$('#kodyModal .btn-cpy').data('cpycode-code', '');
				if(data.acf.urlafter)
					$('#kodyModal .btn-cpy').data('cpycode-urlafter', data.acf.urlafter);
					else
					$('#kodyModal .btn-cpy').data('cpycode-urlafter', '#');
						
					
				if(data.acf.kiedy_wygasa)
				$('#kodyModal .countdownmehere').countdown( data.acf.kiedy_wygasa, function(event) {
							  $(this).html(event.strftime('%D dni %H:%M:%S'));
							}).on('finish.countdown', function(event) {
							  $(this).html('Oferta wygasła!')
							    .parent().addClass('disabled');
							});
							
			});
		}
	})


	$("[data-cpycode-id]").each( function(){
		var id = $(this).data('cpycode-id');
		var ty = $(this).data('cpycode-type');
		var $this = $(this);
		
		if(ty)
			{
			var request = $.ajax({	url: '/wp-json/wp/v2/'+ty+"/"+id });
			//$.get('/wp-json/wp/v2/'+ty+"/"+id, function(data){
			request.done(function( data ) {	
				if(data.acf.kod)
						{
							if( $this.hasClass('code')){
									$this.text( data.acf.kod );	
								}
								
							$this.data('cpycode-code', data.acf.kod)
							if( $this.hasClass('cpy_cnt'))
								$this.text( data.acf.cpy_cnt );	
							
							if(data.acf.urlafter)
								$this.data('cpycode-urlafter', data.acf.urlafter)
						}
				});
			}
			request.fail(function( jqXHR, textStatus ) {
			  	$this.text('b/d');
			  	$this.data('cpycode-code', '')
			  	$this.data('cpycode-urlafter', '#')	
			});

	});
	
	$(document).on('click', '.btn-cpy', function(){
		var id = $(this).data('cpycode-id');
		
			var code = $(this).data('cpycode-code');
			var url_after = $(this).data('cpycode-urlafter');
			var text_after = $(this).data('cpycode-textafter');
		
			if(code)
			    {
			    	if(text_after)
			    		 $(this).html( text_after );
			    		 
			    	var $temp = $("<input class='rmme'>");
					    $(this).parent().append($temp);
				    	$temp.val( code );
				    	$temp.select();
				    	document.execCommand("copy");
				 	
				 		$('.rmme').remove();
			    		console.log('copy: '+ code+' id: '+id);
			    	var data = {
				        'action': 'cy_action',
				        'act' : 'cpycnt',
				        'post_id': id,
				        'contentType': 'application/json', 
    					'dataType': 'json'
				    };
					if(id)
				    	$.post(cy_ajax_url, data, function(response) {
					        
					        $(".cpy_cnt[data-cpycode-id="+id+"]").text(response);
					        if( url_after !='#')
				    			document.location.href = url_after;
				    	});
				    	else
				    	if( url_after !='#')
				    		document.location.href = url_after;
    
    
			    	
			    	
					
				}
	});
	
});/* jq end */

$('.putdate').each( function(){
	var today = new Date();
	var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
	var yyyy = today.getFullYear();
	$(this).text( dd+'.'+mm+'.'+yyyy );

});

$(".displayvar").each( function(){
	var v_name = $(this).data('var')
	
	$(this).text( window[v_name] );
});
	var faq_group={};
	$(".faq").each( function(){
			if( !faq_group[ $(this).data('group') ])
				faq_group[ $(this).data('group') ] = $(this).data('group');
	});
		
	$.each( faq_group, function (k,v){
		$(".faq[data-group='"+k+"']").first().addClass('in');
		$(".faq[data-group='"+k+"']").first().find('.answer').stop().slideDown()
	});
	
	$(".faq").click( function(){
		
		if($(this).hasClass('in') ){
			$(this).removeClass('in');
			$(this).find('.answer').stop().slideUp('slow');
		}else{
			$(this).addClass('in');
			$(this).find('.answer').stop().slideDown('slow');
		}
	});
// $('.table-responsive').animate({ scrollLeft: $('.thposition1').position().left }, 500);
}( jQuery ) );