function removeRow(id){
    $(id).remove();
    resCount();
}

function resCount(){
var count = 1;
$('.labelText').each(function(i, obj){
    $(obj).text('Item #' + count);
    count++;
});
}