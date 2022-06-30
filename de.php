<?php
die();
?>
<!DOCTYPE html>
<html>

<head>
      <title>
            How to Download files Using JavaScript
      </title>
</head>

<body>

      <!-- <textarea id="text">DelftStack</textarea> -->
      <br />
      <input type="button" id="btn" value="Download" />
      <script>
            function download(filename_d, file_name) {
                  var element = document.createElement('a');
                  element.setAttribute('href',file_name);
                  element.setAttribute('download', filename_d);
                  document.body.appendChild(element);
                  element.click();
                  document.body.removeChild(element);
            }
            document.getElementById("btn").addEventListener("click", function () {
                        var filename_d = "2_UML.png";
                        download(filename_d, "message_i_v_d/1653305287_8812_UML.png");
            }, false);
      </script>
</body>

</html>