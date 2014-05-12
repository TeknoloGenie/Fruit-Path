<?PHP
/* ---Property of Franklin Russell---
------Coded for FruitFore.st--------- */
class MySql_Con
{
    // ---Login Credentials---
    private $sql_user = "root";
    private $sql_pass = "pass";
    private $sql_ip = "localhost";
    private $sql_DB = "fruitpat_vendors";

    //---register function start---//
    public function register( $email, $password, $phone, $address, $zip, $type, $fruits, $name, $avatar)
    {
        $mysqli = new mysqli($this->sql_ip, $this->sql_user, $this->sql_pass, $this->sql_DB);
        if ($stmt = $mysqli->prepare("SELECT email FROM vendors WHERE email=?")) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();
            $count = $stmt->num_rows;
            $stmt->close();
        }
        if ($count > 0) {
            return "exists";
        }
        $getJSON = "http://maps.googleapis.com/maps/api/geocode/json?address=" . str_replace(" ", "+",$address) . "&components=postal_code:" . $zip . "|country:US&sensor=false";
        $contentJSON = file_get_contents($getJSON);
        $Geocode_array = json_decode($contentJSON, true);
        if ($Geocode_array['status'] == "OK") {
            $lat = $Geocode_array['results'][0]['geometry']['location']['lat'];
            $long = $Geocode_array['results'][0]['geometry']['location']['lng'];
            if ($stmt2 = $mysqli->prepare("INSERT INTO `vendors` SET email=?, password=?, phone=?, name=?, zip=?, `type`=?, fruits=?, address=?, signupdate=?, actKey=?, `lat`=?, `lng`=?")) {
                $passwordmd = md5($password);
                $token = md5(uniqid($email, true));
                $today = date("Y-m-d");
                $stmt2->bind_param('ssssisssssss', $email, $passwordmd, $phone, $name, $zip, $type, $fruits, $address, $today, $token, $lat, $long);
                $stmt2->execute();
                $stmt2->close();
                $mysqli->close();
                $userray = $this->getprivID($email, $passwordmd);
                if ($userray !== false) {
                /*if ($avatar !== false){
                    $this->uploadAvatar($userray, $avatar);
                    }*/
                    $subject = 'Fruit Path Vendor Activation';
                $message = '
				<html>
				<head>
				<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
				<title>Welcome to Fruit Path!</title>
				<style type="text/css">
				html
				{
					width: 100%;
				}

				body {
				   background-color: #f8f8f8;
				   margin: 0;
				   padding: 0;
				}

				.ReadMsgBody
				{
					width: 100%;
					background-color: #f8f8f8;
				}
				.ExternalClass
				{
					width: 100%;
					background-color: #f8f8f8;
				}

				a {
				    color:#00bbf1;
					text-decoration:none;
					font-weight:normal;
				}
				a:hover {
				    color:#818181;
					text-decoration:underline;
					font-weight:normal;
				}

				a.top-link {
					color:#00bbf1;
					text-decoration:none;
					font-weight:normal;
				}

				a.top-link:hover {
					color:#888888;
					text-decoration:underline;
					font-weight:normal;
				}


				p, div {
					margin: 0;
				}
				table {
					border-collapse: collapse;
				}

				@media only screen and (max-width: 640px)  {
					/*** below is style for body */
					body{width:auto !important;}

					/*** below is style for full width table */
					table table{width:100%!important; }

					/*** below is style for 660px table area */
					table[class="table-660"] {width: 460px !important; }

					/*** below is style for 660px image area */
					img[class="img-660"] {width: 460px !important;  line-height: 0 !important;}
					img[class="img-radius"] {width: 460px !important; height: 10px !important; line-height: 0 !important;}

					/*** below is style for 1/2 column area */
					td[class="one-half-first"] {width: 400px !important; display: block !important; text-align: center !important; padding-bottom: 0px !important; padding-right: 30px !important;}
					td[class="one-half-last"] {width: 400px !important; display: block !important; text-align: center !important; padding-left: 30px !important;}

					/*** below is style for 1/2 column with icon area */
					td[class="one-half-icon-first"] {width: 400px !important; display: block !important; text-align: left !important; padding-bottom: 0px !important; padding-right: 30px !important;}
					td[class="one-half-icon-last"] {width: 400px !important; display: block !important; text-align: left !important; padding-left: 30px !important;}

					/*** below is style for 1/3 column area */
					td[class="one-third"] {width: 400px !important;  display: block !important; text-align: center !important; padding-bottom: 10px !important; padding-right: 30px !important;}
					td[class="one-third-middle"] {width: 400px !important; display: block !important; text-align: center !important; padding-bottom: 10px !important; padding-left: 30px !important; padding-right: 30px !important;}
					td[class="one-third-last"] {width: 400px !important; display: block !important; text-align: center; padding-left: 30px !important; }
					img[class="pro-img-180"] {width: 400px !important;}


					/*** below is style for 3/4 and 1/4 column area */
					td[class="one-fourth-right"] {width: 150px !important; text-align: left !important; padding-bottom: 0px !important;}
					td[class="three-fourth-left"] {width: 250px !important; text-align: left !important; padding-bottom: 0px !important;}
					td[class="three-fourth-left-last"] {width: 250px !important; text-align: left !important; padding-bottom: 40px !important;}
					td[class="one-fourth-right-last"] {width: 150px !important;  text-align: left !important; padding-bottom: 40px !important;}
					img[class="img-180"] {width: 150px !important;}

					/*** below is style for 1/4 and 3/4 column area */
					td[class="one-fourth-left"] {width: 150px !important; text-align: left !important; padding-bottom: 0px !important;}
					td[class="three-fourth-right"] {width: 250px !important; text-align: left !important; padding-bottom: 0px !important;}
					td[class="three-fourth-right-last"] {width: 250px !important; text-align: left !important; padding-bottom: 40px !important;}
					td[class="one-fourth-left-last"] {width: 150px !important;  text-align: left !important; padding-bottom: 40px !important;}
					img[class="img-180"] {width: 150px !important;}

					/*** below is style for 285px image area */
					img[class="img-285"] {width: 400px !important; text-align: center !important;}

					/*** below is style for left content and sidebar area */
					table[class="left-content"] {width: 220px !important; text-align: left !important; }
					td[class="left-content"] {width: 220px !important; text-align: left !important; }
					img[class="img-blog"] {width: 220px !important;}
					img[class="divider-350"] {width: 220px !important; height:1px !important}

					table[class="right-sidebar"] {width: 150px !important;  text-align: left !important; }
					td[class="right-sidebar"] {width: 150px !important; text-align: left !important; }
					img[class="img-gallery"] {width: 110px !important;}
					img[class="divider-220"] {width: 150px !important; height:2px !important}

					/*** below is style for left sidebar and right content area */
					table[class="right-content"] {width: 220px !important; text-align: left !important; }
					td[class="right-content"] {width: 220px !important; text-align: left !important; }
					img[class="img-blog"] {width: 220px !important;}
					img[class="divider-350"] {width: 220px !important; height:1px !important}

					table[class="left-sidebar"] {width: 150px !important; text-align: left !important; }
					td[class="left-sidebar"] {width: 150px !important; text-align: left !important; }
					img[class="img-gallery"] {width: 110px !important;}
					img[class="divider-220"] {width: 150px !important; height:2px !important}
				}

				@media only screen and (max-width: 568px)  {
					/*** below is style for body */
					body{width:auto !important;}

					/*** below is style for full width table */
					table table{width:100%!important; }

					/*** below is style for 660px table area */
					table[class="table-660"] {width: 460px !important; }

					/*** below is style for 660px image area */
					img[class="img-660"] {width: 460px !important;  line-height: 0 !important;}
					img[class="img-radius"] {width: 460px !important; height: 10px !important; line-height: 0 !important;}

					/*** below is style for 1/2 column area */
					td[class="one-half-first"] {width: 400px !important; display: block !important; text-align: center !important; padding-bottom: 0px !important; padding-right: 30px !important;}
					td[class="one-half-last"] {width: 400px !important; display: block !important; text-align: center !important; padding-left: 30px !important;}

					/*** below is style for 1/2 column with icon area */
					td[class="one-half-icon-first"] {width: 400px !important; display: block !important; text-align: left !important; padding-bottom: 0px !important; padding-right: 30px !important;}
					td[class="one-half-icon-last"] {width: 400px !important; display: block !important; text-align: left !important; padding-left: 30px !important;}

					/*** below is style for 1/3 column area */
					td[class="one-third"] {width: 400px !important;  display: block !important; text-align: center !important; padding-bottom: 10px !important; padding-right: 30px !important;}
					td[class="one-third-middle"] {width: 400px !important; display: block !important; text-align: center !important; padding-bottom: 10px !important; padding-left: 30px !important; padding-right: 30px !important;}
					td[class="one-third-last"] {width: 400px !important; display: block !important; text-align: center; padding-left: 30px !important; }
					img[class="pro-img-180"] {width: 400px !important;}


					/*** below is style for 3/4 and 3/4 column area */
					td[class="one-fourth-right"] {width: 150px !important; text-align: left !important; padding-bottom: 0px !important;}
					td[class="three-fourth-left"] {width: 250px !important; text-align: left !important; padding-bottom: 0px !important;}
					td[class="three-fourth-left-last"] {width: 250px !important; text-align: left !important; padding-bottom: 40px !important;}
					td[class="one-fourth-right-last"] {width: 150px !important;  text-align: left !important; padding-bottom: 40px !important;}
					img[class="img-180"] {width: 150px !important;}

					/*** below is style for 1/4 and 3/4 column area */
					td[class="one-fourth-left"] {width: 150px !important; text-align: left !important; padding-bottom: 0px !important;}
					td[class="three-fourth-right"] {width: 250px !important; text-align: left !important; padding-bottom: 0px !important;}
					td[class="three-fourth-right-last"] {width: 250px !important; text-align: left !important; padding-bottom: 40px !important;}
					td[class="one-fourth-left-last"] {width: 150px !important;  text-align: left !important; padding-bottom: 40px !important;}
					img[class="img-180"] {width: 150px !important;}

					/*** below is style for 285px image area */
					img[class="img-285"] {width: 400px !important; text-align: center !important;}

					/*** below is style for left content and sidebar area */
					table[class="left-content"] {width: 220px !important; text-align: left !important; }
					td[class="left-content"] {width: 220px !important; text-align: left !important; }
					img[class="img-blog"] {width: 220px !important;}
					img[class="divider-350"] {width: 220px !important; height:1px !important}

					table[class="right-sidebar"] {width: 150px !important;  text-align: left !important; }
					td[class="right-sidebar"] {width: 150px !important; text-align: left !important; }
					img[class="img-gallery"] {width: 110px !important;}
					img[class="divider-220"] {width: 150px !important; height:2px !important}

					/*** below is style for left sidebar and right content area */
					table[class="right-content"] {width: 220px !important; text-align: left !important; }
					td[class="right-content"] {width: 220px !important; text-align: left !important; }
					img[class="img-blog"] {width: 220px !important;}
					img[class="divider-350"] {width: 220px !important; height:1px !important}

					table[class="left-sidebar"] {width: 150px !important; text-align: left !important; }
					td[class="left-sidebar"] {width: 150px !important; text-align: left !important; }
					img[class="img-gallery"] {width: 110px !important;}
					img[class="divider-220"] {width: 150px !important; height:2px !important}
				}

				@media only screen and (max-width: 479px)  {
					/*** below is style for body */
					body{width:auto !important;}

					/*** below is style for full width table */
					table table{width:100%!important; }

					/*** below is style for 660px table area */
					table[class="table-660"] {width: 300px !important; }

					/*** below is style for logo area */
					td[class="logo"] {width: 240px !important; display: block !important; padding-bottom: 0px !important;}
					td[class="social"] {width: 240px !important; display: block !important; }

					/*** below is style for 660px image area */
					img[class="img-660"] {width: 300px !important;  line-height: 0 !important;}
					img[class="img-radius"] {width: 300px !important; height: 10px !important; line-height: 0 !important;}

					/*** below is style for 1/2 column area */
					td[class="one-half-first"] {width: 240px !important; display: block !important; text-align: center !important; padding-bottom: 0px !important; padding-right: 30px !important;}
					td[class="one-half-last"] {width: 240px !important; display: block !important; text-align: center !important; padding-left: 30px !important;}

					/*** below is style for 1/2 column with icon area */
					td[class="one-half-icon-first"] {width: 240px !important; display: block !important; text-align: left !important; padding-bottom: 0px !important; padding-right: 30px !important;}
					td[class="one-half-icon-last"] {width: 240px !important; display: block !important; text-align: left !important; padding-left: 30px !important;}

					/*** below is style for 1/3 column area */
					td[class="one-third"] {width: 240px !important; display: block !important; text-align: center; padding-bottom: 10px !important; padding-right: 30px !important;}
					td[class="one-third-middle"] {width: 240px !important; display: block !important; text-align: center; padding-bottom: 10px !important; padding-left: 30px !important; padding-right: 30px !important;}
					td[class="one-third-last"] {width: 240px !important; display: block !important; text-align: center; padding-left: 30px !important;}
					img[class="pro-img-180"] {width: 240px !important;}

					/*** below is style for 285px image area */
					img[class="img-285"] {width: 240px !important; text-align: center !important;}

					/*** below is style for 3/4 and 1/4 column area */
					td[class="three-fourth-left"] {width: 240px !important; display: block !important; text-align: center !important; padding-bottom: 0px !important; padding-right: 30px !important;}
					td[class="one-fourth-right"] {width: 240px !important; display: block !important; text-align: center !important; padding-bottom: 0px !important; padding-left: 30px !important;}
					td[class="three-fourth-left-last"] {width: 240px !important; display: block !important; text-align: center !important; padding-bottom: 0px !important; padding-right: 30px !important;}
					td[class="one-fourth-right-last"] {width: 240px !important; display: block !important; text-align: center !important; padding-bottom: 40px !important; padding-left: 30px !important;}
					img[class="img-180"] {width: 240px !important; text-align: center !important;}


					/*** below is style for 1/4 and 3/4 column area */
					td[class="one-fourth-left"] {width: 240px !important; display: block !important; text-align: left !important; padding-bottom: 0px !important;}
					td[class="three-fourth-right"] {width: 240px !important; display: block !important; text-align: left !important; padding-bottom: 0px !important; padding-left: 30px !important;}
					td[class="three-fourth-right-last"] {width: 240px !important; display: block !important; text-align: left !important; padding-bottom: 40px !important; padding-left: 30px !important;}
					td[class="one-fourth-left-last"] {width: 240px !important; display: block !important;  text-align: left !important; padding-bottom: 40px !important;}
					img[class="img-180"] {width: 240px !important;display: block !important; }


					/*** below is style for left content and sidebar area */
					table[class="left-content"] {width: 240px !important; margin: 0;  text-align: left !important; padding-bottom: 40px !important;  display: block !important;}
					td[class="left-content"] {width: 240px !important; margin: 0; text-align: left !important; display: block !important; }
					img[class="img-blog"] {width: 240px !important; display: block !important;}
					img[class="divider-350"] {width: 240px !important; height:1px !important display: block !important;}

					table[class="right-sidebar"] {width: 240px !important; text-align: center !important;  display: block !important; }
					table[class="right-sidebar-last"] {width: 240px !important; text-align: center !important; margin-bottom: 40px !important; display: block !important; }
					td[class="right-sidebar"] {width: 240px !important; text-align: left !important; display: block !important; }
					img[class="img-gallery"] {width: 200px !important; display: block !important;}
					img[class="divider-220"] {width: 240px !important; height:2px !important display: block !important;}

					/*** below is style for left sidebar and right content area */
					table[class="right-content"] {width: 240px !important; margin: 0 !important;  text-align: right !important; padding-left: 30px !important; padding-bottom: 40px !important; display: block !important;}
					td[class="right-content"] {width: 240px !important; margin: 0 !important; text-align: left !important; display: block !important; }
					img[class="img-blog"] {width: 240px !important; display: block !important;}
					img[class="divider-350"] {width: 240px !important; height:1px !important display: block !important;}

					table[class="left-sidebar"] {width: 240px !important; text-align: center !important;  display: block !important; }
					table[class="left-sidebar-last"] {width: 240px !important;  text-align: center !important; margin-bottom: 40px !important; display: block !important; }
					td[class="left-sidebar"] {width: 240px !important; text-align: left !important; display: block !important; }
					img[class="img-gallery"] {width: 200px !important; display: block !important;}
					img[class="divider-220"] {width: 240px !important; height:2px !important display: block !important;}


					/*** below is style for footer area */
					td[class="footer-left"] {width: 240px !important; display: block !important; text-align: center !important; padding-bottom: 0px !important;}
					td[class="footer-right"] {width: 240px !important; display: block !important; text-align: center !important; }
				}

				</style>
				</head>
				<body bgcolor="#f8f8f8">
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8f8f8">
					<tr>
						<td align="center">
						<!-- START OF TOP LINKS BLOCK-->
						<table class="table-660" width="660" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8f8f8" style="padding:0; margin: 0; ">
							<tr>
								<td bgcolor="#f8f8f8" align="left" style="padding: 30px 0px 10px 0px; font-size:12px ; font-family: Helvetica, Arial, sans-serif; line-height: 22px; font-style: italic;">
									<span>
										<a class="top-link" href="http://fruitpath.st/">View online</a>
										&nbsp;&nbsp;
										<a class="top-link" href="https://www.facebook.com/">Forward to friends</a>
									</span>
								</td>
							</tr>
						</table>
						<!-- END OF TOP LINKS BLOCK-->

						<!-- START OF LOGO AND SOCIAL ICONS BLOCK-->
							<table class="table-660" width="660" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="padding:0; margin: 0; ">
								<tr>

									<!-- START OF LOGO HERE-->
									<td class="logo" colspan="2" width="330" bgcolor="#ffffff" align="left" valign="top" style=" padding-top: 25px; font-size:12px ; font-family: Helvetica, Arial, sans-serif; line-height: 22px; font-style: italic;">
										<span>
											<a href="http://fruitpath.com/" style="color:#ffffff;">
											<img src="http://fruitpath.com/websiteimages/fruitpathlogo.png" alt="logo" />
											</a>
										</span>
									</td>
									<!-- END OF LOGO HERE-->

									<!-- START OF SOCIAL ICONS HERE-->
									<td class="social" colspan="2" width="330" bgcolor="#ffffff" align="right" valign="middle" style="padding: 30px; font-size:12px ; font-family: Helvetica, Arial, sans-serif; line-height: 22px; font-style: italic;">
										<span>
											<a href="https://www.facebook.com/fruitpath" style="color:#ffffff;">
												<img src="images/facebook.jpg" alt="facebook" border="0" />
											</a>
										</span>
									</td>
									<!-- END OF SOCIAL ICONS HERE-->
								</tr>
							</table>
						<!-- END OF LOGO AND SOCIAL ICONS BLOCK-->

						<!-- START OF SUBJECT LINE AREA BLOCK-->
							<table class="table-660" width="660" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#00bbf1" style="padding:0; margin: 0; ">
								<tr>
									<td width="660" bgcolor="#00bbf1" align="left" valign="top" style="padding: 30px; font-size:32px ; font-family: Helvetica, Arial, sans-serif; line-height: 42px; color:#ffffff; text-transform: uppercase;">
										<span>
											Welcome to Fruit Path
										</span>
									</td>
								</tr>
							</table>
						<!-- END OF SUBJECT LINE AREA BLOCK-->



						<!-- START OF INTRO TEXT AREA BLOCK-->
							<table class="table-660" width="660" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="padding:0; margin: 0; ">
								<tr>
									<td width="660" bgcolor="#ffffff" align="left" style="padding: 40px 30px ; font-size:16px ; font-family: Helvetica, Arial, sans-serif; line-height: 26px; color:#aaaaaa; ">
										<p>
											We received your vendor request for
											<span style="background:#fff7a8; font-style: italic;">
											Fruit Path <br>
				<br />
				<p>
				Please click on the link below to confirm your fruit stand or marketplace and be added to the Fruit Path map.
				<br />
				Thanks!
										</p>

										<br />

										<p align="center">
											<a href="http://fruitpath.com/activateuser.php?usr=' . $userray . '&token=' . $token . '" style="color:#ffffff; text-transform: uppercase; background:#00bbf1; font-style: normal; border-top: 10px solid #00bbf1; border-right: 15px solid #00bbf1; border-bottom: 10px solid #00bbf1; border-left: 15px solid #00bbf1;">
											please confirm
											</a>
										</p>

									</td>
								</tr>
							</table>
						<!-- END OF INTRO TEXT BLOCK-->

						<!-- START OF FOOTER AREA BLOCK-->
							<table class="table-660" width="660" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ececec" style="padding:0; margin: 0; ">
								<tr>

									<!-- START OF FOOTER LEFT HERE-->
									<td class="footer-left" colspan="2" width="430" bgcolor="#ececec" align="left" valign="top" style="padding: 30px 15px 20px 30px; font-size:12px ; font-family: Helvetica, Arial, sans-serif; line-height: 14px; font-style: italic; color:#aaaaaa;">

										<p>
										Our mailing address is: <a href="http://fruitpath.com/">Fruit Path</a>, 1040 W. Friesen Ave, Reedley, CA. 93654
										</p>
									</td>
									<!-- END OF FOOTER LEFT HERE-->

									<!-- START OF FOOTER RIGHT HERE-->
									<td class="footer-right" colspan="2" width="200" bgcolor="#ececec" align="left" valign="top" style="padding:  30px 30px 20px 15px;  font-size:12px ; font-family: Helvetica, Arial, sans-serif; line-height: 14px; font-style: italic; color:#aaaaaa;">
										<p>
											Copyright 2013 <a href="http://fruitpath.com/">Fruit Path</a> all right reserved.
										</p>
									</td>
									<!-- END OF FOOTER RIGHT HERE-->
								</tr>
							</table>
						<!-- END OF FOOTER AREA BLOCK-->

						<!-- START OF RADIUS IMAGE AREA BLOCK-->
							<table class="tablbe-660" width="660" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8f8f8" style="padding:0; margin: 0; ">
								<tr>
									<td width="660" bgcolor="#f8f8f8" align="center" style="padding-bottom: 30px; line-height: 0 !important;">
										<span>
											<img class="img-radius" src="images/image-radius.jpg" alt="image radius" border="0" />
										</span>
									</td>
								</tr>
							</table>
						<!-- END OF RADIUS IMAGE AREA BLOCK-->
						</td>
					</tr>
				</table>
				</body>
				</html>';
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
                $headers .= 'From: Fruit Path <aaron@teknologenie.com>' . "\r\n";
                mail($email, $subject, $message, $headers);
                    return true;
                } else {
                    return false;
                }

            } else {
                $mysqli->close();
                return false;
            }
        }
    }

    //---register function end---//
    private function getprivUser($username, $pass)
    {
        $mysqlis = new mysqli($this->sql_ip, $this->sql_user, $this->sql_pass, $this->sql_DB);
        if ($stmt = $mysqlis->prepare("SELECT id FROM vendors WHERE email=? AND password=? LIMIT 1")) {
            $stmt->bind_param('ss', $username , $pass);
            $rstl = $stmt->execute();
            if ($rstl === TRUE) {
                $stmt->bind_result($id);
                while ($stmt->fetch()) {
                    return true;
                }
                $stmt->close();
                $mysqlis->close();
                return false;
            } else {
                return false;
            }
            $stmt->close();
        } else {
            $mysqlis->close();
            return false;
        }

    }
    //---register function end---//
    private function getprivID($username, $pass)
    {
        $mysqlis = new mysqli($this->sql_ip, $this->sql_user, $this->sql_pass, $this->sql_DB);
        if ($stmt = $mysqlis->prepare("SELECT id FROM vendors WHERE email=? AND password=? LIMIT 1")) {
            $stmt->bind_param('ss', $username , $pass);
            $rstl = $stmt->execute();
            if ($rstl === TRUE) {
                $stmt->bind_result($id);
                while ($stmt->fetch()) {
                    return $id;
                }
                $stmt->close();
                $mysqlis->close();
                return false;
            } else {
                return false;
            }
            $stmt->close();
        } else {
            $mysqlis->close();
            return false;
        }

    }

//---Changing fruit function start---//
    public function changefruit($fruit, $email, $pass)
    {
        if ($this->getprivUser($email, $pass) !== false){
            $mysqli = new mysqli($this->sql_ip, $this->sql_user, $this->sql_pass, $this->sql_DB);
            if ($stmt = $mysqli->prepare("UPDATE `vendors` SET fruits=? WHERE id=?")) {
                $id = $this->getprivID($email, $pass);
                $stmt->bind_param('si', $fruit, $id);
                $stmt->execute();
                $stmt->close();
                $mysqli->close();
                return true;
            } else {
                $mysqli->close();
                return false;
            }
        } else {
            return false;
        }
    }

    private function getToken($email){
        $mysqli = new mysqli($this->sql_ip, $this->sql_user, $this->sql_pass, $this->sql_DB);
        if ($stmt = $mysqli->prepare("SELECT actKey FROM vendors WHERE email=?")) {
            $stmt->bind_param('ss', $email);
            $rstl = $stmt->execute();
            if ($rstl === TRUE) {
                $stmt->bind_result($id);
                while ($stmt->fetch()) {
                    return $id;
                }
                $stmt->close();
                $mysqli->close();
                return false;
            } else {
                return false;
            }
            $stmt->close();
            $mysqli->close();
            return true;
        } else {
            $mysqli->close();
            return false;
        }
    }

    public function updateaddress($address, $zip, $email, $pass)
    {
		if ($this->getprivUser($email, $pass) !== false){
			$mysqli = new mysqli($this->sql_ip, $this->sql_user, $this->sql_pass, $this->sql_DB);
			$prepAddr = str_replace(' ', '+', $address);
			$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&components=postal_code:' . $zip .'|country:US&sensor=false');
			$output = json_decode($geocode);
			if ($output->status == "OK") {
				if ($stmt = $mysqli->prepare("UPDATE vendors SET address=?, zip=?, `lat`=?, `lng`=?, activated=0 WHERE email=?")) {
					$latitude = $output->results[0]->geometry->location->lat;
					$longitude = $output->results[0]->geometry->location->lng;
					$stmt->bind_param('sisss', $address, $zip, $latitude, $longitude, $email);
					$stmt->execute();
                    $id = $this->getprivID($email, $pass);
                    $token = $this->getToken($email);
                    $subject = 'FruitPath Vendor Activation';
                    $message = '<html><p align="center">
								<a href="http://fruitpath.com/activateuser.php?usr=' . $id . '&token=' . $token . '" >
								please confirm
								</a>
							</p></html>';
                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
                    $headers .= 'From: FruitPath.com <actvivate@fruitpath.com>' . "\r\n";
                    $activatorsEmail = 'franklin.russell.0@gmail.com';
                    mail($activatorsEmail, $subject, $message, $headers);
					$stmt->close();
				} else {
					$mysqli->close();
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
    }

    public function grabmarkers($getbound)
    {
        $mysqli = new mysqli($this->sql_ip, $this->sql_user, $this->sql_pass, $this->sql_DB);
        $tmp = explode(',', $getbound);
        $latsw = $tmp[2];
        $latne = $tmp[0];
        $lngsw = $tmp[3];
        $lngne = $tmp[1];
        $points = array();

        if ($stmt = $mysqli->prepare("SELECT `lat`, `lng`, `type`, name, id, fruits, address, phone FROM vendors WHERE activated=1 AND `lat` BETWEEN ? AND ? AND `lng` BETWEEN ? AND ?")) {

            $stmt->bind_param('ssss', $latsw, $latne, $lngsw, $lngne);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($lats, $lngs, $attr, $name, $username, $fruit, $addr, $phone);
            $fruitPathurl = 'http://www.fruitpath.com/';
            while ($stmt->fetch()) {
                    array_push($points, array('id' => $username, 'lat' => $lats, 'lng' => $lngs, 'type' => $attr, 'name' => $name, 'fruit' => $fruit, 'address' => $addr, 'phone' => $phone));
            }
            $stmt->close();
            $mysqli->close();
        } else {
            $mysqli->close();
            return false;
        }

        return $points;

    }


    public function activate($username, $token)
    {
        $mysqli = new mysqli($this->sql_ip, $this->sql_user, $this->sql_pass, $this->sql_DB);
        if ($stmt = $mysqli->prepare("UPDATE vendors SET activated=1 WHERE id=? AND actKey=? AND activated=0")) {
            $stmt->bind_param('ss', $username, $token);
            $stmt->execute();
            $stmt->close();
            $mysqli->close();
            return true;
        } else {
            $mysqli->close();
            return false;
        }

    }
  /*  
    public function process_image($photo) {
			$type = null;
			if (preg_match('/^data:image\/(jpg|jpeg|png)/i', $photo, $matches)) {
				$type = $matches[1];
			} else {
				return false;
			}
		
			// Remove the mime-type header
			$data = reset(array_reverse(explode('base64,', $photo)));
		
			// Use strict mode to prevent characters from outside the base64 range
			$image = base64_decode($data, true);
		
			if (!$image) { return false; }
		
			return array(
				'data' => $image,
				'type' => $type
			);
		}

    public function uploadAvatar($username, $img)
    {
	define('UPLOAD_PATH', 'images/');

	if (!$img) { 
		return false;
		exit;
	 }
	
	$image = $this->process_image($img);
	if (!$image) { exit; }
	
	// Just use a unique ID for the filename for this example
	$filename = $username . '_' . uniqid() . '.' . $image['type'];
	$output_file = UPLOAD_PATH . $filename;
	if (is_writable(UPLOAD_PATH) && !file_exists($output_file)) {
		if (file_put_contents($output_file, $image['data']) !== false) {
		        $mysqli = new mysqli($this->sql_ip, $this->sql_user, $this->sql_pass, $this->sql_DB);
		        if ($stmt = $mysqli->prepare("UPDATE vendors SET avatar=? WHERE id=?")) {
		            $stmt->bind_param('si', $output_file, $username);
		            $stmt->execute();
		            $stmt->close();
		            return true;
		        } else {
		            return false;
		        }
		        $mysqli->close();
		} else {
		return false;
		}
	} else {
		return false;
	}
        

    }
*/

}

?>