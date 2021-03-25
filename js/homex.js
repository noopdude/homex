function validateHomeForm() {
  var x = document.forms["homeform"]["maintenance_dues[]"].value;
  if (x == "" || x == null) {
    //alert("Maintenance dues need to be filled. if none, update as 0");
    //return false;
  }
  var x = document.forms["homeform"]["other_dues[]"].value;
  if (x == "" || x == null) {
    //alert("Other dues need to be filled. if none, update as 0");
    //return false;
  }
  var table = document.getElementById("hometable");
  for (var i = 0, row; row = table.rows[i]; i++) {
   //iterate through rows
   //rows would be accessed using the "row" variable assigned in the for loop
   for (var j = 0, col; col = row.cells[j]; j++) {
     //iterate through columns
     //columns would be accessed using the "col" variable assigned in the for loop
     if(j=5){
       alert(row.cells[j].other_dues[]);
     }
   }
}
}
