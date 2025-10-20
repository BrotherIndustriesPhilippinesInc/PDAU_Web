<?php
$location = $_GET['location'];
?>
<div style="display: flex;justify-content: center; align-items: center;" id="text"></div>

<div id="img-out"></div>

	<script src="../assets/js/watermark.min.js"></script>
	<script type="text/javascript">
		watermark(['<?php echo $location; ?>'])
		.image(watermark.text.center('ABOLISHED', '120px serif', 'red', 5))
		.then(function (img) {
			document.getElementById('text').appendChild(img);
		});



        html2canvas($("#text"), {
            onrendered: function(canvas) {
            	var	imageData = canvas.toDataURL("../assets/img/test1234.jpeg");
                theCanvas = canvas;
                document.body.appendChild(canvas);

                // Convert and download as image 
                Canvas2Image.saveAsPNG(canvas); 
               /* $("#img-out").append(canvas);*/
                // Clean up 
                //document.body.removeChild(canvas);
            }
        });
    

	</script>
	
