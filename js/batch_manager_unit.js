//===============================================================
// HOW TO VALIDATE EXTENSION DATA WITHIN BATCH MANAGER UNIT MODE
//===============================================================


// ==============================================================
// Method 1: Using ajax call to validate data
// ==============================================================
// 1. Add a web service method to save your specified fields
// (see facial.setInfo method registration and function in facial\include\ws_functions.inc.php)
// Don't forget to register an event handler for your method (see facial\main.inc.php)
//
// 2. Add an event handler for your method (see facial\main.inc.php)
//
// 3. Add a JS function named [pluginID]_batchManagerSave
// This function will be called whenever each picture is saved
// As an example, this function saves the value of the facial field in the facialValue variable
// and sends it as ajax data for the facial.setInfo method
function facial_batchManagerSave(pictureId) {
  var input = $("#picture-" + pictureId + " .facial");
  var inputValue = parseInt(input.val(), 10);
  var facialValue = (inputValue === 1) ? 1 : 0;
  $.ajax({
      type: 'POST',
      url: 'ws.php?format=json',
      data: {
          method: 'facial.setInfo',
          pwg_token: jQuery("input[name=pwg_token]").val(),
          image_id: pictureId,
          facial: facialValue
      },
      dataType: 'json',
      success: function(data) {
          const isOk = data.stat && data.stat === 'ok';
          if (isOk) {
              console.log("Facial value updated successfully for picture " + pictureId);
          } else {
              console.error("Error: " + data.message);
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          console.error("AJAX Error: " + textStatus + ": " + errorThrown);
      }
  });
}
// ==============================================================
// Method 2: Send data in a single HTTP request
// ==============================================================
// 1. Add a function to process the additional data sent in the pwg.images.setInfo request's payload
// This method will trigger whenever the extension is active and pwg.images.setInfo is called
// so you need verifications to make sure it only triggers when the method is called with your data in the payload
// (see facial_ws_images_setInfo in facial\include\ws_functions.inc.php)
//
// 2. Add a ws_invoke_allowed handler for your method (see facial\main.inc.php)
//
// 3. Register the field selectors that needs to be sent as data in the base API call
// Do so by pushing keys and values to the pluginValues JS variable, the api_key will be the
// name of the field in the payload and the selector will be a hook to the input the script has to retrieve the value from
// Example : if the selector is ".facial2" the data sent to the payload will be the result of $("#picture-" + pictureId + " .facial2").val();
$(document).ready(function() {
pluginValues.push({api_key: "facial", selector: ".facial2"});
});
