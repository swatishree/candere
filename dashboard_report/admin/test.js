function test() {
    $.ajax({
        url: 'moslem.php',
        type: 'POST',
        success: function(data) {
            document.write(data);
        }
    });     
 }
 $(document).ready(function() {
   setTimeout( test, 1000);    
 });
