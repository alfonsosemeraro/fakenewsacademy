$(document).ready(function() {
    $('#myTable tbody tr').each( function() {
        //Funzione che sostituisce i numeri compresi tra 0 e 1, delle
        //ultime due colonne della tabella, con delle frecce.
        var nTds = $('td', this);
        var s = $(nTds[7]).text();
        var t = $(nTds[8]).text();

        $(nTds[3]).css("text-align", "center");
        $(nTds[5]).css("text-align", "center");
        $(nTds[6]).css("text-align", "center");

        if(s>=0 && s<=0.2) {
            $(nTds[7]).attr("id","down");
        } else if (s>0.2 && s<=0.4) {
            $(nTds[7]).attr("id","south-east");
        } else if (s>0.4 && s<=0.6) {
            $(nTds[7]).attr("id","right");
        } else if (s>0.6 && s<0.8) {
            $(nTds[7]).attr("id","north-east");
        } else {
            $(nTds[7]).attr("id","up");
        }

        if(t>=0 && t<=0.2) {
            $(nTds[8]).attr("id","down");
        } else if (t>0.4 && t<=0.6) {
            $(nTds[8]).attr("id","right");
        } else if (t>0.2 && t<=0.4) {
            $(nTds[8]).attr("id","south-east");
        } else if (t>0.6 && t<0.8) {
            $(nTds[8]).attr("id","north-east");
        } else {
            $(nTds[8]).attr("id","up");
        }
    });

    //Pemette di ordinare la tabella e rendere le colonne 1 e 4
    // più piccole accorciando il testo presente nelle celle
    var table = $('#myTable').DataTable({
        columnDefs: [ 
            {
                targets: [1,4],
                render: function ( data, type, row ) {
                    return data.length > 100 ? data.substr( 0, 100 ) +'…' : data;
                }
            }
        ]
    });
});  