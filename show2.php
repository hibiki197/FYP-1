<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
	<script type="text/javascript">
		window.onload = function () {
			var oricanvas = document.getElementById('normal');
			var orictx = oricanvas.getContext("2d");
			var image = document.getElementById('originalimage');
			var imagewidth = image.width;
			var imageheight = image.height;
			if(image.width < image.height){
				if(image.height > 500){
					imagewidth = (image.width / image.height) * 500;  // reduce the size of the image //
					imageheight = 500;
				}
				else{
					imagewidth = image.width;
					imageheight = image.height;
				}
			}
			else if(image.width > image.height){
				if(image.width >  500){
					imageheight = (image.height / image.width) * 500; //reduce the size of the image //
					imagewidth = 500;
				}
				else{
					imagewidth = image.width;
					imageheight = image.height;
				}
			}
			else if(image.width == image.height){
			 if(image.width >  500){
				imageheight = 500;
				imagewidth = 500;
			 }
			 else{
				imagewidth = image.width;
				imageheight = image.height;
			 }
			}
			document.getElementById('normal').setAttribute("width", parseInt(imagewidth));
			document.getElementById('normal').setAttribute("height", parseInt(imageheight));
			orictx.drawImage(image, 0, 0, imagewidth, imageheight);
			
			var imageData = orictx.getImageData(0, 0, imagewidth, imageheight);
			var imgdata = imageData.data;
			var imagevari;
			var ImageVariable = new Array();
			var DispRed;
			var DispGreen;
			var DispBlue;
			var pixelcounter = 0;
			var totalpixel = 0 ;
			var total = 0;
			
			totalpixel = (imgdata.length / 4) ;
			total = (imageData.width * imageData.height);
			
			window.alert(imgdata.length);
			window.alert(totalpixel);
			window.alert(total);
				
			for (var i = 0, n = imgdata.length; i < n; i += 4){
				
				ImageVariable.push({
					Red : imgdata[i],
					Green : imgdata[i+1],
					Blue : imgdata[i+2],
					Alpha : imgdata[i+3],
					Vari : (imgdata[i+1] - imgdata[i]) / (imgdata[i+1] + imgdata[i] - imgdata[i+2]),
					position : pixelcounter
				});
				
				pixelcounter = pixelcounter + 1;
			}
			
			var redmax = 0, redmin = 255, greenmax = 0, greenmin = 255, bluemax = 0, bluemin = 255;
			for (var i = 0, n=ImageVariable.length; i<n; i += 1){
				if(redmax < ImageVariable[i].Red ){
					redmax = ImageVariable[i].Red;
				}
				if(redmin > ImageVariable[i].Red){
					redmin = ImageVariable[i].Red;
				}
				if(greenmax < ImageVariable[i].Green){
					greenmax = ImageVariable[i].Green;
				}
				if(greenmin > ImageVariable[i].Green){
					greenmin = ImageVariable[i].Green;
				}
				if(bluemax < ImageVariable[i].Blue){
					bluemax = ImageVariable[i].Blue;
				}
				if(bluemin > ImageVariable[i].Blue){
					bluemin = ImageVariable[i].Blue;
				}
			}
			
			imagevari = ImageVariable.sort(function(a,b){return a.Vari-b.Vari});
			
			var re = document.getElementById('result');
			var vic = re.getContext("2d");
			document.getElementById('result').setAttribute("width", parseInt(imagewidth));
			document.getElementById('result').setAttribute("height", parseInt(imageheight));
			var finalvariimage = vic.createImageData(imagewidth,imageheight);
			var pixelindex = 0;
			
			
			/*var totalclass = document.getElementById("totalclass").$value;*/
			var dataperclass = Math.ceil(imagevari.length / 35);
			 
			window.alert("Pixel per Class = "+dataperclass);
			var classnum = 1;
			var classlabel = "<tableborder ='0' cellspacing ='0' cellpading ='0'>";
			var cvalue;
			var x = 0;
			
			for (var i = 0, n= imagevari.length; i < n ; i += 1){
				
				if ( x < dataperclass){
					x = 0;
					classnum = classnum + 1;
				}
			
			imagevari[i]["class"] = classnum;
			cvalue = (imagevari[i].class/ 35) * 100;
			if(x==0){
				classlabel += '<tr><td width="10px" style="background-color:rgba('+(255 * (100 - cvalue)) / 100+', '+(255 * cvalue) / 100+', '+0+', '+ImageVariable[i].Alpha+')"></td><td>' + imagevari[i].value + ' ~ ';
			}
			
			if(x == dataperclass || i == n-1){
			classlabel += imagevari[i].value+' </td><tr/>';
			}
							 
			x = x + 1;
		}
		
			window.alert("Total Class = " + classnum)
			imagevari = imagevari.sort(function(a,b){return a.position-b.position});
			console.log("image:", imagevari);
			var pixelvalue;
			for(var i = 0, n=imagevari.length; i < n; i += 1){
				pixelvalue = imagevari[i].class;
				pixelvalue = (pixelvalue / 35) * 100; // convert class value to 100% //
				finalvariimage.data[pixelindex] = (255 * (100 - pixelvalue)) / 100;
				finalvariimage.data[pixelindex + 1] = (255 * pixelvalue) / 100;
				finalvariimage.data[pixelindex + 2] = 0;
				finalvariimage.data[pixelindex + 3] = ImageVariable[i].alpha;
				pixelindex = pixelindex + 4;
			}
			
			var finalimagered = new Array;
			var finalimagegreen = new Array
			var finalimageblue = new Array;
			var finalimagealpha = new Array;
			var displayfinalimagered;
			var displayfinalimagegreen;
			var displayfinalimageblue;
			pixelcounter = 0;
			var finalvaridata = finalvariimage.data;
			for(var i = 0, n = finalvaridata.length; i < n; i += 4) {
				finalimagered[pixelcounter] = finalvaridata[i];
				finalimagegreen[pixelcounter] = finalvaridata[i + 1];
				finalimageblue[pixelcounter] = finalvaridata[i + 2];
				finalimagealpha[pixelcounter] = finalvaridata[i + 3];
				
				if(i == 0){
				displayfinalimagered = " " + finalimagered[pixelcounter];
				displayfinalimagegreen = " " + finalimagegreen[pixelcounter];
				displayfinalimageblue = " " + finalimageblue[pixelcounter];
				}
							
				else if(pixelcounter % parseInt(image.width) == 0){
				displayfinalimagered += " " + finalimagered[pixelcounter] + "<br /><br />";
				displayfinalimagegreen += " " + finalimagegreen[pixelcounter] + "<br /><br />";
				displayfinalimageblue += " " + finalimageblue[pixelcounter] + "<br /><br />";
				}
							 
				else{
				displayfinalimagered += " " + finalimagered[pixelcounter];
				displayfinalimagegreen += " " + finalimagegreen[pixelcounter];
				displayfinalimageblue += " " + finalimageblue[pixelcounter];
				}
				pixelcounter = pixelcounter + 1;
			}
			
			 
			var finalimagered = new Array;
			var finalimagegreen = new Array
			var finalimageblue = new Array;
			var finalimagealpha = new Array;
			var displayfinalimagered;
			var displayfinalimagegreen;
			var displayfinalimageblue;
			pixelcounter = 0;
			var finalvaridata = finalvariimage.data;
			
			for(var i = 0, n = finalvaridata.length; i < n; i += 4) {
				finalimagered[pixelcounter] = finalvaridata[i];
				finalimagegreen[pixelcounter] = finalvaridata[i + 1];
				finalimageblue[pixelcounter] = finalvaridata[i + 2];
				finalimagealpha[pixelcounter] = finalvaridata[i + 3];
				
				if(i == 0){
				    displayfinalimagered = " " + finalimagered[pixelcounter];
					displayfinalimagegreen = " " + finalimagegreen[pixelcounter];
					displayfinalimageblue = " " + finalimageblue[pixelcounter];
				}
							 
				else if(pixelcounter % parseInt(image.width) == 0){
				displayfinalimagered += " " + finalimagered[pixelcounter] + "<br /><br />";
				displayfinalimagegreen += " " + finalimagegreen[pixelcounter] + "<br /><br />";
				displayfinalimageblue += " " + finalimageblue[pixelcounter] + "<br /><br />";
				}
							 
				else{
				displayfinalimagered += " " + finalimagered[pixelcounter];
				displayfinalimagegreen += " " + finalimagegreen[pixelcounter];
				displayfinalimageblue += " " + finalimageblue[pixelcounter];
				}
				
				pixelcounter = pixelcounter + 1;
			}
			victx.putImageData(finalvariimage, 0, 0);
			document.getElementById("orisize").innerHTML = image.width+" x "+image.height;
			document.getElementById("resize").innerHTML = imagewidth+" x "+imageheight;
						 /*document.getElementById("imagered").innerHTML = displayimagered;
						 document.getElementById("imagegreen").innerHTML = displayimagegreen;
						 document.getElementById("imageblue").innerHTML = displayimageblue;
						 document.getElementById("imagevari").innerHTML = displayimagevari;*/
			document.getElementById("imagevarimax").innerHTML = varimax;
			document.getElementById("imagevarimin").innerHTML = varimin;
			document.getElementById("imagevarimedian").innerHTML = varimedian;
						 /*document.getElementById("varineg").innerHTML = displayvarineg;
						 document.getElementById("varipos").innerHTML = displayvaripos;
						 document.getElementById("varinegmedian").innerHTML = varinegmedian;
						 document.getElementById("variposmedian").innerHTML = variposmedian;
						 document.getElementById("varineglist").innerHTML = displaylistvarineg;*/
			document.getElementById("variimgred").innerHTML = displayfinalimagered;
			document.getElementById("variimggreen").innerHTML = displayfinalimagegreen;
			document.getElementById("variimgblue").innerHTML = displayfinalimageblue;
			document.getElementById("classlabel").innerHTML = classlabel;
			
	     
		    window.alert("Load Complete");
		 	FR.readAsDataURL( this.files[0] );
	 
			document.getElementById('result').setAttribute("height",parseInt(imageheight));
			document.getElementById("Red").innerHTML = DispRed;
			document.getElementById("Green").innerHTML = DispGreen;
			document.getElementById("Blue").innerHTML = DispBlue;
			document.getElementById("Redmax").innerHTML = redmax;
			document.getElementById("Redmin").innerHTML = redmin;
			document.getElementById("Greenmax").innerHTML = greenmax;
			document.getElementById("Greenmin").innerHTML = greenmin;
			document.getElementById("Bluemax").innerHTML = bluemax;
			document.getElementById("Bluemin").innerHTML = bluemin;
		
		}
		
		 
			
	</script>
</head>
<body>
	<?php
	$con = mysqli_connect('localhost', 'root', '', 'fyp');
	$id=$_GET["id"];
	$showid = "SELECT * FROM test WHERE ID = '$id'";
	$data = mysqli_query($con, $showid);
	$fetch = mysqli_fetch_array($data);
	$filename = $fetch['name'];
	echo "<p style='display:none;'><img id='originalimage' src='".$filename."''></img></p>";
	?>
	<canvas id="normal"></canvas><canvas id="result"></canvas><br>
	<b>Red Max</b>
	<p id="Redmax"></p>
	<b>Red Min</b>
	<p id="Redmin"></p>
	<b>Green Max</b>
	<p id="Greenmax"></p>
	<b>Green Min</b>
	<p id="Greenmin"></p>
	<b>Blue Max</b>
	<p id="Bluemax"></p>
	<b>Blue Min</b>
	<p id="Bluemin"></p>
	<b>Red</b>
	<p id="Red"></p>
	<b>Green</b>
	<p id="Green"></p>
	<b>Blue</b>
	<p id="Blue"></p>
</body>
</html>