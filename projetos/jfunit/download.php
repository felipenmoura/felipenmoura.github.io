<?php
	include 'includes/header.php';
	include 'includes/menu.php';
	?>
<div id="body">
	<div id="body-top">
		<div id="body-bot">
			<div id="about-box">
				<h2><b>What about</b> unit tests</h2>
				<img src="images/Download-icon.png"  height="92" alt="Download" class="left" />
				<!--<img src="images/pic_1.jpg" width="112" height="92" alt="Pic 1" class="left" />-->
				<div style="padding-top:25px;margin-bottom:35px;">
					<p>
						Download all the source files, plus some examples.<br/>
						These files come straight from GitHub and are really up to date
					</p>
				</div>
				<ul>
					<li>
						<a href="https://github.com/felipenmoura/jfUnit/zipball/master">
							Download
						</a>
					</li>
				</ul>
		  </div>
			<div id="express-box">
				<h2><b>Contribute</b></h2>
				<img src="images/contribute.png" height="80" alt="Contribute" class="left" />
				<p>
					In our case, here, as an open source project, you can help us contributing with it.<br/>
					Check our <a href="contribute.php">contribute</a> area to see how helpful you may be!
				<br/><br/><br/>
				<p>
					<div style="float:left;">You can also </div>
					<div style="float:left;">
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHJwYJKoZIhvcNAQcEoIIHGDCCBxQCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYBjqjcPicNtXCCF0pKA+sKwpVIlhlralGisQkurCkK4/IP069X2gxLJraD+Motu1ZBpNtKERg5yBa3CVQqaZJmbeBEOI1/MTNBwDa2NRyvl6M/GHKw0RwmdBzWYxR+QZB4Q1n19Oqiw8mozbgqF4bOcLngAKwA5K17aFlgsQSg1ODELMAkGBSsOAwIaBQAwgaQGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIvaShKxMGesSAgYBigqv9RbSSj7q7eNIQnvNfA/3Mqq2b6GzNdMKRBFcFALCHby15wrMBY6TmRlE8/XQdFrYYccTEuTkVqV3++txn3ihG0D37vazaeLJBREF+hhIbrYeJpUheenMlG92soQWfvetgG41omD/Ml9QJ9TQiTSIGzWuEs6SpysswnY4vbaCCA4cwggODMIIC7KADAgECAgEAMA0GCSqGSIb3DQEBBQUAMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTAeFw0wNDAyMTMxMDEzMTVaFw0zNTAyMTMxMDEzMTVaMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEAwUdO3fxEzEtcnI7ZKZL412XvZPugoni7i7D7prCe0AtaHTc97CYgm7NsAtJyxNLixmhLV8pyIEaiHXWAh8fPKW+R017+EmXrr9EaquPmsVvTywAAE1PMNOKqo2kl4Gxiz9zZqIajOm1fZGWcGS0f5JQ2kBqNbvbg2/Za+GJ/qwUCAwEAAaOB7jCB6zAdBgNVHQ4EFgQUlp98u8ZvF71ZP1LXChvsENZklGswgbsGA1UdIwSBszCBsIAUlp98u8ZvF71ZP1LXChvsENZklGuhgZSkgZEwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tggEAMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQEFBQADgYEAgV86VpqAWuXvX6Oro4qJ1tYVIT5DgWpE692Ag422H7yRIr/9j/iKG4Thia/Oflx4TdL+IFJBAyPK9v6zZNZtBgPBynXb048hsP16l2vi0k5Q2JKiPDsEfBhGI+HnxLXEaUWAcVfCsQFvd2A1sxRr67ip5y2wwBelUecP3AjJ+YcxggGaMIIBlgIBATCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwCQYFKw4DAhoFAKBdMBgGCSqGSIb3DQEJAzELBgkqhkiG9w0BBwEwHAYJKoZIhvcNAQkFMQ8XDTEwMTEyMTAzMDQwN1owIwYJKoZIhvcNAQkEMRYEFFVqkul9pGKivoy5xlGEhwFAaXTeMA0GCSqGSIb3DQEBAQUABIGAitX2bjN4UqgD6y98gEwCw1cFS/hwi+7hX4JXoGxKFvV3s6xwqnoWq4mEpRyiNVXcYzNVf4g9Ra2GO4OUP3JU7c/t6EDBhE+xjOrVw5j26gNQq+cMqiL6I11nYj1vWV27EVaEDnNATtNHepldF3PPPqFc+xEXhzkFb0xBts1W10A=-----END PKCS7-----
							">
							<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
							<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</div>
					some money to shear us up!<br/>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<?php
	include 'includes/footer.php';
?>