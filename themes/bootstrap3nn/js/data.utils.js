
function JavaDT2JQueryDTData(data) {
	
	var tDataArray = [];
	
	// Acondiciona los datos del formato de entrada al formato de datatables
	$.each( data.rows, function( i, rowdata ) {
		var row = {};
		$.each( rowdata.c, function( j, celldata ) {
			row["C" + (j + 1)] = celldata.v;
		});
		tDataArray.push(row);
	});

	return tDataArray;
} 


function JavaDT2JQueryDTColumns(data, translateMap) {

	var columns = [];
	
	$.each( data.cols, function( i, coldata ) {
		
		if ( coldata["label"] in translateMap ) {
			coldata["label"] = translateMap[coldata["label"]];
		}
		
		var col = {};
		col["data"] = coldata["id"];
		col["title"] = coldata["label"]	;
	
		columns.push(col);	
	});
	
	return columns;

}