$(function () {

$('#cmd').click(function () {
   
var pdf = new jsPDF('l','pt','a4');
pdf.addHTML(document.body,function() {
   pdf.save('récapitulatif_horaires.pdf');
});
 
}); 
});