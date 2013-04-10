jQuery(document).ready(function(){
	var offset = 0;
	$(".boxsearch-loading").hide();
	jQuery("#pagination").submit(function () {
		event.preventDefault();
		$(".boxsearch-loading").show();
		var query = $('#query').val();
		//alert (query);
		offset = offset+30;
		//alert(offset);
		var filter = $('select.filter-subfolders option:selected').val();
		//alert(filter);
		var url = 'index.php?option=com_boxsearch&view=ajax&format=raw&offset='+offset+'&query='+query;
		//alert(url);
		$.getJSON(url, function(data) {
			 $(".boxsearch-loading").show();
			 var items = [];
			 entries = data.entries;
			 //alert (entries);
			 $.each(entries, function(key, entry) {
			    items.push('<div class="boxsearch-item ' + key + '">');
				    items.push('<div class="span1">icon</div>');
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
			  $(".boxsearch-loading").hide();
		}); // end json 
	}); // end event
}); // end dom
	