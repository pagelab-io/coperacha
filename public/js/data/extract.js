// https://countrycode.org/

var data = [];

$($('table.main-table > tbody')[1]).find('tr').each(function(i, r){

    data.push({
        name: $(r).find('td:eq(0)').find('a').text(),
        code: $(r).find('td:eq(1)').text(),
        iso: $(r).find('td:eq(2)').text()
    });

});

var json = JSON.stringify(data);