<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>A Simple Responsive HTML Email</title>
  <style type="text/css">
  body {margin: 0; padding: 0; min-width: 100%!important;}
  img {height: auto;}
  .content {width: 100%; max-width: 600px;}
  /*.header {padding: 30px 30px 20px 30px;}*/
  .innerpadding {padding: 30px 30px 30px 30px;}
  .borderbottom {border-bottom: 1px solid #f2eeed;}
  .bordertop {border-top: 1px solid #f2eeed;}
  .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
  .h1, .h2, .h5, .bodycopy {color: #0e2d4c; font-family: sans-serif;}
  .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
  .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
  .h5 {font-size: 15px; line-height: 20px; font-weight: bold;}
  .bodycopy {font-size: 16px; line-height: 22px;}
  .button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
  .button a {color: #ffffff; text-decoration: none;}
/*  .footer {padding: 20px 30px 15px 30px;}*/
  .footer {padding: 20px 0px 15px 0px;}
  .footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}
  .footercopy a {color: #ffffff; text-decoration: underline;}

  @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
  body[yahoo] .hide {display: none!important;}
  body[yahoo] .buttonwrapper {background-color: transparent!important;}
  body[yahoo] .button {padding: 0px!important;}
  body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
  body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
  }

  /*@media only screen and (min-device-width: 601px) {
    .content {width: 600px !important;}
    .col425 {width: 425px!important;}
    .col380 {width: 380px!important;}
    }*/

  </style>
</head>

<body yahoo bgcolor="#f6f8f1">
<table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td>
    <!--[if (gte mso 9)|(IE)]>
      <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td>
    <![endif]-->     
    <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
      <tr>
        <td class="header">
            <img class="fix" src="https://equipeer.com/medias/2020/09/logo-equipeer-sport-email-600x200-2.jpg" width="600" height="200" border="0" alt="" />

            <p class="h2" style="padding: 5px 0 0 0; text-align: center;">
                Achat de chevaux & poneys de sport<br />Sp??cialiste de la vente de chevaux
            </p>
        </td>
      </tr>
      <tr>
        <td class="innerpadding bordertop borderbottom">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td style="color: #0e2d4c;">
                {EMAIL_CONTENT}
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <!--<tr>
        <td class="innerpadding bordertop">
          <table width="115" align="left" border="0" cellpadding="0" cellspacing="0">  
            <tr>
              <td height="115" style="padding: 0 20px 20px 0;">
                <img class="fix" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/article1.png" width="115" height="115" border="0" alt="" />
              </td>
            </tr>
          </table>-->
          <!--[if (gte mso 9)|(IE)]>
            <!--<table width="380" align="left" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>-->
          <![endif]-->
          <!--<table class="col380" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 380px;">  
            <tr>
              <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="bodycopy">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus adipiscing felis, sit amet blandit ipsum volutpat sed. Morbi porttitor, eget accumsan dictum, nisi libero ultricies ipsum, in posuere mauris neque at erat.
                    </td>
                  </tr>
                  <tr>
                    <td style="padding: 20px 0 0 0;">
                      <table class="buttonwrapper" bgcolor="#e05443" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="button" height="45">
                            <a href="#">Claim yours!</a>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>-->
          <!--[if (gte mso 9)|(IE)]>
                <!--</td>
              </tr>
          </table>-->
          <![endif]-->
        <!--</td>
      </tr>-->
      <!--<tr>
        <td class="innerpadding borderbottom">
          <img class="fix" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/wide.png" width="100%" border="0" alt="" />
        </td>
      </tr>-->
      <tr>
        <td class="innerpadding bodycopy" style="font-size: 12px;">
          Equipeer Sport est une plateforme de mise en relation entre vendeurs et acheteurs de chevaux de sport. Les vendeurs et les chevaux &agrave; vendre sont s&eacute;lectionn&eacute;s avec soin par des professionnels et les annonces sont r&eacute;unies sous la forme d'un catalogue en ligne.
        </td>
      </tr>
      <tr>
        <td class="footer" bgcolor="#0e2d4c">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center" style="padding: 0 0 20px 0;">
                    <img src="https://equipeer.com/medias/2020/09/logo-equipeer-sport-blanc-600.png" alt="EQUIPEER SPORT" width="300">
                </td>
            </tr>
            <tr>
              <td align="center" class="footercopy">
                &copy; 2021 <a href="https://equipeer.com/">equipeer.com</a> ??? EQUIPEER SPORT<br>SAS EQUIPEER RCS : 828 989 962 M&acirc;con
              </td>
            </tr>
            <tr>
              <td align="center" style="padding: 20px 0 0 0;">
                <table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="37" style="text-align: center; padding: 0 10px 0 10px;">
                      <a href="https://www.facebook.com/equipeer/">
                        <img src="https://equipeer.com/datas/themes/wp-bootstrap-starter-child/assets/images/email-facebook.png" width="37" height="37" alt="Facebook" border="0" />
                      </a>
                    </td>
                    <td width="37" style="text-align: center; padding: 0 10px 0 10px;">
                      <a href="https://twitter.com/equipeer">
                        <img src="https://equipeer.com/datas/themes/wp-bootstrap-starter-child/assets/images/email-twitter.png" width="37" height="37" alt="Twitter" border="0" />
                      </a>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
    </table>
    <![endif]-->
    </td>
  </tr>
</table>
</body>
</html>

