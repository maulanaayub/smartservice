<?php
$action = "/service_iain/oauth2/Authorize?response_type=" . $response_type . "&client_id=" . $client_id . "&redirect_uri=" . $redirect_uri . "&state=" . $state . "&scope=" . $scope;
?>

<body>
	<div style="text-align:center;">
		<form method="post">
			<div class="oauth_content" node-type="commonlogin">
				<p class="oauth_main_info">Authorisasi? Klik Submit Jika anda mengijinkan
					<input name="authorized" value="yes" hidden>
					<button>submit</button>
			</div>
		</form>

	</div>
</body>

</html>