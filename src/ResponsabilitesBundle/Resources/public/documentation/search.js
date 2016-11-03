var LAST_ID = 0;

function addElement(name, where) {
	LAST_ID++;
	var element;
	element = $('#template'+name.toUpperCase()).html().replace(/%id%/g, LAST_ID).replace(/%value%/g, '');
	if (name == 'or' || name == 'and') {
		LAST_ID++;
		element = element.replace(/%id2%/g, LAST_ID);
	}
	if (typeof where === 'undefined') {
		$('#addElement').before(element);
		console.log('Élément '+name+' ajouté');
	} else {
		$('#'+where).append(element);
		console.log('Élément '+name+' ajouté en '+where);
	}
	$('.alert').hide('fast');
}

function editElement(which, type) {
	whichElement = $('#groupe'+which);
	var originalType = whichElement.attr('type');
	if (type == originalType)
		return;

	if (/default|quote|site|inurl|not/.test(originalType) && /default|quote|site|inurl|not/.test(type)) {
		whichElement.attr('type', type);
		$('#groupe'+which+' label').text($('#template'+type.toUpperCase()+' label').text());
		$('#groupe'+which+' li.active').removeClass('active');
		$($('#groupe'+which+' a[value="'+type+'"]').get().parentElement).addClass('active');
	} else if (/or|and/.test(originalType) && /or|and/.test(type)) {
		whichElement.attr('type', type);
		$('#groupe'+which+' label[for="input'+which+'"]')
			.text(
				$('#template'+type.toUpperCase()+' label').text()
				);
		$('#edit'+which+' li.active').removeClass('active');
		$($('#edit'+which+' a[value="'+type+'"]').get().parentElement).addClass('active');
	} else if (/default|quote|site|inurl|not/.test(originalType) && /or|and/.test(type)) {
		whichElement.attr('type', type);
		LAST_ID++;
		whichElement.html(
			$('#template'+type.toUpperCase()+' > .row')
				.html()
				.replace(/%id%/g, which)
				.replace(/%id2%/g, LAST_ID)
				.replace(
					/%value%/g,
					$('#input'+which).val()
					)
			);
	} else if (/or|and/.test(originalType) && /default|quote|site|inurl|not/.test(type)) {
		whichElement.attr('type', type);
		var value = '';
		$('#groupe'+which+' input').each(function(index) {
			value += $(this).val();
			value += ' ';
		});
		whichElement.html(
			$('#template'+type.toUpperCase()+' > .row')
				.html()
				.replace(/%id%/g, which)
				.replace(
					/%value%/g,
					value.trim()
					)
			);
	}
}

function error(type) {
	switch(type)
	{
		case 'no_block':
			console.error('Erreur: pas d\'éléments lors du lancement de la recherche')
			$('.alert').text('Veuillez insérer un élément de recherche').show('slow');
			break;
	}
}

function parseElement(element) {
	var groups = element.querySelectorAll('.row'),
		length = groups.length;
	var parsed = Array();
	for (var i = 0; i < length; i++) {
		var group = $(groups[i]);
		if (!group.attr('done')) {
			group.attr('done', true);
			var input = document.getElementById(group.attr('id').replace("groupe", "input"));
			if (/or|and/i.test(group.attr('type'))) {
				parsed.push({type: group.attr('type'), content: parseElement(input)});
			} else {
				parsed.push({type: group.attr('type'), content: input.value});
			}
		}
	}
	return parsed;
}

function elementsToString(elements, separator) {
	if (typeof separator == 'undefined')
		separator = ' ';

	var string = '';

	elements.forEach(function(value, index, elements) {
		if (/or|and/.test(value.type)) {
			string += separator + elementsToString(value.content, ' '+value.type.toUpperCase()+' ');
		} else {
			switch (value.type)
			{
				case 'inurl':
					string += separator + 'inurl:(' + value.content.trim() + ')';
					break;
				case 'quote':
					string += separator + '"' + value.content.trim() + '"';
					break;
				case 'site':
					string += separator + 'site:(' + value.content.trim() + ')';
					break;
				case 'not':
					string += separator + 'NOT (' + value.content.trim() + ')';
					break;
				default:
					string += separator + '(' + value.content.trim() +')';
			}
		}
	});

	string = string.substring(separator.length);

	return string;
}

function submit(event) {
	event.preventDefault();

	var form = document.getElementsByTagName('form')[0];
	if (!form.querySelector('.form-group')) {
		error('no_block');
		return;
	}

	var elements = parseElement(form);
	console.log(elements);

	var string = elementsToString(elements);
	console.log(string);

	var search = 'http://www.google.com/search?q=' + string.replace(/ /g, '+');
}

$(function() {
	$('form').on('click.Caravane', '.close', function(event) {
		$('#groupe'+event.target.id.replace(/^close(\d+)$/, '$1')).remove();
	});

	$('#addElement a').on('click.Caravane', function(event) {
		addElement($(event.target).attr('value'));
	});

	$('form').on('click.Caravane', '.add', function(event) {
		addElement(
			$(event.target).attr('value'),
			'input'+event.target.parentElement.parentElement.id.replace(/^add(\d+)$/, '$1')
		);
	});

	$('form input[type="submit"]').on('click.Caravane', submit);

	$('form').on('click.Caravane', '.edit', function(event) {
		editElement(
			event.target.parentElement.parentElement.id.replace(/^edit(\d+)$/, '$1'),
			$(event.target).attr('value')
		);
	});
});
