<?php
/**
 * Yealink Phone Action URL Setup
 *
 * Miscellaneous functions for the connector application
 *
 * @Author Neo Code
 * @Version 1.0
 * @Created April 2017
 *
 */

// Constants
define( 'EVT_PGM', 'yealink_event.php' );
define( 'EVT_PARAM', '&mac=$mac&ip=$ip&cid=$call_id&dr=$display_remote&lcl=$local&rmt=$remote' );

// grab some needed functions
require 'includes/functions.php';

// get current folder
$folder = basename(__DIR__ );

// get the IP addresses
$ips = getIPaddresses();

$initial_ip = $ips[0];

// get server port
$port = $_SERVER['SERVER_PORT'];

// default action urls
$incoming_url    = 'http://' . $initial_ip . ':' . $port . '/'. $folder . '/' . EVT_PGM . '/?e=ic' . EVT_PARAM;
$terminating_url = 'http://' . $initial_ip . ':' . $port . '/'. $folder . '/' . EVT_PGM . '/?e=term' . EVT_PARAM;
$missed_url      = 'http://' . $initial_ip . ':' . $port . '/'. $folder . '/' . EVT_PGM . '/?e=mis' . EVT_PARAM;
$reject_url      = 'http://' . $initial_ip . ':' . $port . '/'. $folder . '/' . EVT_PGM . '/?e=rejic' . EVT_PARAM;
$answer_url      = 'http://' . $initial_ip . ':' . $port . '/'. $folder . '/' . EVT_PGM . '/?e=ansic' . EVT_PARAM;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Neo Code Yealink Call Connector</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <style>
        /* http://meyerweb.com/eric/tools/css/reset/
           v2.0 | 20110126
           License: none (public domain)
        */

        html, body, div, span, applet, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, embed,
        figure, figcaption, footer, header, hgroup,
        menu, nav, output, ruby, section, summary,
        time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }

        /* HTML5 display-role reset for older browsers */
        article, aside, details, figcaption, figure,
        footer, header, hgroup, menu, nav, section {
            display: block;
        }

        body {
            line-height: 1;
            font-family: Roboto, sans-serif;
        }

        ol, ul {
            list-style: none;
        }

        blockquote, q {
            quotes: none;
        }

        blockquote:before, blockquote:after,
        q:before, q:after {
            content: '';
            content: none;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        /*! borrowed from sanitize.css v5.0.0 | CC0 License | github.com/jonathantneal/sanitize.css */

        *,
        ::before,
        ::after {
            background-repeat: no-repeat;
            box-sizing: inherit;
        }

        strong {
            font-weight: 700;
        }

        p {
            line-height: 1.25;
            margin-bottom: 0.8rem;
        }

        html {
            box-sizing: border-box;
            cursor: default;
            height: 100%;
        }

        body {
            height: 100%;
        }

        header {
            background-color: #202020;
            color: #ffffff;
            float: left;
            height: 50px;
            padding: 14px 0;
            width: 100%;
        }

        .header-container {
            width: 985px;
            padding: 0;
            margin: 0 auto;
        }

        header img {
            height: 22px;
        }

        article {
            background-color: #e75300;
            padding: 84px 0 48px;
            min-height: 100%;
        }

        .article-container {
            background-color: #ffffff;
            border-radius: 7px;
            margin: 0 auto 74px auto;
            overflow: hidden;
            padding: 28px 42px;
            width: 985px;
        }

        h1 {
            border-bottom: thin solid #dedede;
            color: #333333;
            font-weight: 500;
            font-size: 32px;
            margin-bottom: 24px;
            padding-bottom: 16px;
            text-align: center;
        }

        h2 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .ip-select-group {
            line-height: 1.85;
            margin-bottom: 0.8rem;
        }

        .ip-select-group input[type=radio] {
            margin-left: 12px;
        }

        .ip-select-group input[type=text] {
            border-radius: 5px;
            color: #444444;
            display: inline-block;
            font-size: 15px;
            font-weight: 400;
            padding: 3px 6px;
            text-align: center;
            width: 144px;
        }

        #other-ip,
        #other-ip-msg {
            display: none;
            margin-left: 8px;
        }

        .ip-good {
            color: #009000;
            font-weight: 300;
        }

        .ip-bad {
            color: #e00000;
            font-weight: 300;
        }

        ol.setup-steps {
            font-weight: 300;
            list-style: decimal outside;
            margin-bottom: 20px;
            padding-left: 24px;
        }

        ol.setup-steps li {
            margin-bottom: 8px;
        }

        .setup-fields fieldset {
            padding-bottom: 12px;
        }

        .setup-fields label {
            display: block;
            font-weight: 300;
            margin-bottom: 4px;
        }

        .setup-fields input[type=text] {
            border-radius: 5px;
            color: #666666;
            display: block;
            font-size: 12px;
            font-weight: 400;
            padding: 3px 6px;
            width: 100%;
        }

        footer {
            background: linear-gradient(to bottom, #ffffff 0%, #eaeaea 100%);
            bottom: 0;
            height: 40px;
            padding: 12px 0;
            position: fixed;
            width: 100%;
        }

        .footer-container {
            color: #333333;
            font-size: 0.75rem;
            font-weight: 300;
            margin: 0 auto;
            padding: 0;
            text-align: right;
            width: 985px;
        }

    </style>
</head>
<body>
<header>
    <div class="header-container">
        <a href="http://neocode.com/" target="_blank"><img src="images/NeoCodeLogo.png" alt="neo code logo"></a>
    </div>
</header>
<article>
    <div class="article-container">
        <h1>Yealink Action URL Setup Assistant</h1>
        <div>
            <p>Use this page to assist you configuring the phones to send call events to the correct computer on the
                correct TCP/IP port.
            </p>
            <h2>Computer IP address</h2>
            <p>Select the IP of the computer to receive phone events</p>
            <fieldset id="machineIp" class="ip-select-group">
				<?php
				for ( $i = 0; $i < count( $ips ); $i ++ ) {
					$checked = ( $i ? '' : ' checked' );
					echo '<input type="radio" name="machine-ip" class="machine-ip-input" value="' . $ips[ $i ] . '"' . $checked . '> ' . $ips[ $i ] .
					     '<br>';
				}
				echo '<input type="radio" name="machine-ip" class="machine-ip-input" value="other">';
				echo ' Other: <input type="text" id="other-ip"><span id="other-ip-msg"></span>';
				?>
            </fieldset>
            <p>To set up the phone for this computer:</p>
            <ol class="setup-steps">
                <li>Login to the phone for this computer as an administrator</li>
                <li>Navigate to the <em>Action URL</em> page</li>
                <li>Copy and past the values from the following fields</li>
                <li>Save the Action URLS by clicking Confirm</li>
            </ol>
            <div class="setup-fields">
                <h2>Phone Action URL Field Values</h2>
                <fieldset>
                    <label>Incoming Call:</label>
                    <input type="text" id="setup-incoming-call" class="action-url" value="<?php echo $incoming_url; ?>">
                </fieldset>

                <fieldset>
                    <label>Terminated (or Call Terminated):</label>
                    <input type="text" id="setup-terminated-call" class="action-url"
                           value="<?php echo $terminating_url; ?>" readonly>
                </fieldset>

                <fieldset>
                    <label>Missed Call:</label>
                    <input type="text" id="setup-missed-call" class="action-url" value="<?php echo $missed_url; ?>">
                </fieldset>

                <fieldset>
                    <label>Reject Incoming Call:</label>
                    <input type="text" id="setup-rejected-call" class="action-url" value="<?php echo $reject_url; ?>">
                </fieldset>

                <fieldset>
                    <label>Answer New In-Call (or Answer New Call):</label>
                    <input type="text" id="setup-answered-call" class="action-url" value="<?php echo $answer_url; ?>">
                </fieldset>

            </div>
        </div>
    </div>
    <script>
        var i;
        var radionButtons   = document.getElementsByName("machine-ip");
        var otherIpBox      = document.getElementById("other-ip");
        var otherIpMsg      = document.getElementById("other-ip-msg");
        var actionUrlInputs = document.getElementsByClassName("action-url");

        var incomingCallInput   = document.getElementById("setup-incoming-call");
        var terminatedCallInput = document.getElementById("setup-terminated-call");
        var missedCallInput     = document.getElementById("setup-missed-call");
        var rejectedCallInput   = document.getElementById("setup-rejected-call");
        var answeredCallInput   = document.getElementById("setup-answered-call");

        var folder   = "<?php echo $folder; ?>";
        var port     = "<?php echo $port; ?>";
        var evtPgm   = "<?php echo EVT_PGM; ?>";
        var evtParam = "<?php echo EVT_PARAM; ?>";

        var ipReg = new RegExp("^([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5])\\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5])\\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5])\\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5])$");

        // SETUP EVENTS
        //===============
        var len = radionButtons.length;
        for (i = 0; i < len; i++) {
            radionButtons[i].addEventListener("click", function (e) {
                var radioBtnValue = e.currentTarget.valueOf().value;
                console.log("click");
                console.log(radioBtnValue);
                if (radioBtnValue == 'other') {
                    // show other input
                    otherIpBox.style.display = "inline-block";
                    otherIpMsg.style.display = "inline-block";

                    if (validIP(otherIpBox.value)) {
                        // if other has valid IP, set up action URL
                        setActionUrls(otherIpBox.value);
                    } else {
                        // else clear action URLs
                        clearActionUrls();
                    }

                }
                else {
                    // hide other input
                    otherIpBox.style.display = "none";
                    otherIpMsg.style.display = "none";

                    // set up action URL
                    setActionUrls(radioBtnValue);
                }
            }, false);
        }

        otherIpBox.addEventListener("keyup", function (e) {
            //otherIpBox.value = otherIpBox.value.trim();
            if (validIP(otherIpBox.value)) {
                console.log('Good IP');
                setActionUrls(otherIpBox.value);
            } else {
                console.log('Invalid IP, try again');
                clearActionUrls();
            }
        }, false);

        otherIpBox.addEventListener("paste", function (e) {
            // add short pause...
            setTimeout(function () {
                console.log('paste...' + otherIpBox.value);
                otherIpBox.value = otherIpBox.value.trim();
                if (validIP(otherIpBox.value)) {
                    console.log('Good IP');
                    setActionUrls(otherIpBox.value);
                } else {
                    console.log('Invalid IP, try again');
                    clearActionUrls();
                }
            }, 100);

        }, false);

        var actionUrlsLen = actionUrlInputs.length;
        for (i = 0; i < actionUrlsLen; i++) {
            actionUrlInputs[i].addEventListener("click", function (e) {
                e.currentTarget.select();
            });
        }

        // FUNCTIONS
        //===============
        function validIP(ipIn) {
            if (ipReg.test(ipIn)) {
                // valid IP, show green check
                otherIpMsg.innerHTML = '<i class="fa fa-check" aria-hidden="true"></i> Valid IP';
                otherIpMsg.classList.remove('ip-bad');
                otherIpMsg.classList.add('ip-good');
                return true;
            } else {
                // invalid IP, show red !
                otherIpMsg.innerHTML = '<i class="fa fa-exclamation" aria-hidden="true"></i> Enter valid IP';
                otherIpMsg.classList.remove('ip-good');
                otherIpMsg.classList.add('ip-bad');
                return false;
            }
        }

        function setActionUrls(ipIn) {
            var urlPart1 = "http://" + ipIn + ":" + port + "/" + evtPgm + "/" + folder;
            // setup value for new IP
            incomingCallInput.value = urlPart1 + "/?e=ic" + evtParam;
            terminatedCallInput.value = urlPart1 + "/?e=term" + evtParam;
            missedCallInput.value = urlPart1 + "/?e=mis" + evtParam;
            rejectedCallInput.value = urlPart1 + "/?e=rejic" + evtParam;
            answeredCallInput.value = urlPart1 + "/?e=ansic" + evtParam;
        }

        function clearActionUrls() {
            incomingCallInput.value = "";
            terminatedCallInput.value = "";
            missedCallInput.value = "";
            rejectedCallInput.value = "";
            answeredCallInput.value = "";
        }

    </script>
</article>
<footer>
    <div class="footer-container">
        &copy; <?php echo date( "Y" ); ?> Neo Code
    </div>
</footer>
</body>
</html>