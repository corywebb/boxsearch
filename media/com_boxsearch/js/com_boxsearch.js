jQuery(document).ready(function(){
	$('#clear').hide();
	$('#getMoreResults').hide();
	var offset = 0;
	$(".boxsearch-loading").hide();
	jQuery("#pagination").submit(function () {
		event.preventDefault();
		clear();
		search(offset);
	}); // end event
	jQuery("#clear").click(function () {
			clear();
	});
	jQuery('#getMoreResults').click(function () {
			offset = offset+30;
			search(offset);
	});
	function clear()
	{
		offset = 0;
		$('div.box-results').html('');
		$('#getResults').attr('value','Get Results');
		$('#getMoreResults').hide();
	}
	function search(offset)
	{
		$(".boxsearch-loading").show();
		$('#getResults').prop('disabled', true); //TO DISABLED
		var query = $('#query').val();
		//alert (query);
		//alert(offset);
		if ($('select.filter-subfolders option:selected').val())
		{
			var filter = $('select.filter-subfolders option:selected').val();
		}
		else
		{
			var filter = $('input.filter-subfolders').val();
		}
		
		//alert(filter);
		var url = 'index.php?option=com_boxsearch&view=ajax&format=raw&offset='+offset+'&query='+query+'&filter='+filter;
		offset = offset+30;
		//alert(url);
		$.getJSON(url, function(data) {
			
			 $(".boxsearch-loading").show();
			 var items = [];
			 if (data.total_count == 0 || data.entries.length < 1)
			 {
				 items.push('<div id="system-message-container"><dl id="system-message">');
				 items.push('<dt class="error">Error</dt><dd class="error message"><ul>');
				 items.push('<li>No Entries Found</li>');
				 items.push('</ul></dd></dl></div>');
			 }
			 entries = data.entries;
			 //alert (entries);
			 $.each(entries, function(key, entry) {
			    items.push('<div class="boxsearch-item ' + key + '">');
				    items.push('<div class="span1"><img src="' + entry.icon + '" /></div>');
				    items.push('<div class="span11">');
				    	items.push('<h4>');
				    		if (typeof entry.shared_link == undefined || entry.shared_link == null )
				    		{
				    			items.push(entry.name);
				    		}
				    		else
				    		{
				    			//alert(entry.shared_link);
				    			items.push('<a href="' + entry.shared_link.download_url + '" target="_blank">' + entry.name + '</a>');
				    		}
				    	items.push('</h4>');
				    items.push('</div>'); // end span 11
				    items.push('<ul class="boxsearch">');
				    	items.push('<li>Created: ' + entry.created_at + '</li>');
				    	items.push('<li>Modified: ' + entry.modified_at + '</li>');
				    	items.push('<li>Created By: ' + entry.created_by.name + '</li>');
				    items.push('</ul>');
				    items.push('<br />');
				    items.push('<ul class="boxsearch">');
				    	if (typeof entry.shared_link != undefined && entry.shared_link != null)
				    	{	
				    		//alert(entry.shared_link);
					    	items.push('<li><a href="' + entry.shared_link.download_url + '" target="_blank">Download File</a></li>');
					    	items.push('<li><a href="' + entry.shared_link.url + '" target="_blank">View File</a></li>');
				    	}
				    	items.push('<li>Located In: ' + entry.parent.name + '</li>');
			    	items.push('</ul>'); 
			    items.push('</div>'); // end boxsearch item  
			    items.push('<hr />');
			  }); 
			  $('<div/>', {
			    'class': 'my-new-list',
			    html: items.join('')
			  }).appendTo('div.box-results');
			  $('#clear').show();
			  $(".boxsearch-loading").hide();
			  $('#getMoreResults').show();
			  $('#getResults').prop('disabled', false); //TO ENABLE
		}); // end json 
	}
}); // end dom
