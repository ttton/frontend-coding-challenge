<?php
/**
 * MailHelper.php
 * @author: Trungtin Ton <tin.developer@gmail.com>
 * @version: 0.2.1
 */

require_once 'php_mailer/class.phpmailer.php';
require_once 'php_mailer/class.smtp.php';

Class MailHelper {

    public function sendMail($params, $config_file_path = 'mail.conf.ini') {
        try {
            $mail = new PHPMailer(true); // set true to throw exceptions on errors
            $mail_config = parse_ini_file($config_file_path, true);
            if (!$mail_config) {
                throw new Exception("Failed to parse config file: '" . $config_file_path . "'");
            }

            // Load the email instance with the provided configurations
            set_common_mail_config($mail, $mail_config);
            $this->handleMailFrom($mail, $mail_config);
            $this->handleWordWrapping($mail, $mail_config);

            // Set user parameters
            $this->handleMailTo($mail, $params);
            $this->handleSubject($mail, $params);
            $this->handleMailTemplateFile($mail, $params);

            $mail->Send();

            echo "Message sent.\n\n";
            return true;
        }
        catch (Exception $e) {
            echo $e->getTraceAsString();
            echo "Error: " . $e->getMessage() . "\n\n";
            return false;
        }
    }

    private function handleMailFrom($mail, $mail_config) {
        if (isset($mail_config["mail_config"]["mail_from"])) {
            // Email addresses can be formatted in various ways, and could
            // include a display name string. Use a regex to obtain the
            // display name and email address separately.
            // Regex taken from http://stackoverflow.com/a/5696364
            preg_match('/^(?:"?([^@"]+)"?\s)?<?([^>]+@[^>]+)>?$/', $mail_config["mail_config"]["mail_from"], $matched_address);
            $mail->setFrom($matched_address[2], $matched_address[1]);
            $mail->ConfirmReadingTo = $matched_address[2];
        } else {
            throw new Exception("the following required configuration is not defined: 'mail_from'");
        }
    }

    private function handleWordWrapping($mail, $mail_config) {
        if (isset($mail_config["mail_config"]["mail_word_wrap"]) && $mail_config["mail_config"]["mail_word_wrap"]) {
            $mail->WordWrap = $mail_config["mail_config"]["mail_word_wrap"];
        }
    }

    private function handleMailTo($mail, $params) {
        if (isset($params["mail_to"])) {
            // The mail_to parameter takes a semicolon-separated list of
            // addresses. Break the list up and add each one by one.
            $matched_addresses = array_map('trim', explode(';', $params["mail_to"]));
            array_walk($matched_addresses, function(&$matched_address) use ($mail) {
                preg_match('/^(?:"?([^@"]+)"?\s)?<?([^>]+@[^>]+)>?$/', $matched_address, $matched_address);
                $mail->addAddress($matched_address[2], $matched_address[1]);
            });
        } else {
            throw new Exception("the following required configuration is not defined: 'mail_to'");
        }
    }

    private function handleSubject($mail, $params) {
        if (isset($params["mail_subject"])) {
            $mail->Subject = ($params["mail_subject"]);
        } else {
            throw new Exception("the following required configuration is not defined: 'mail_subject'");
        }
    }

    private function handleMailTemplateFile($mail, $params) {
        if (isset($params['template_file_path']) AND (strlen($params['template_file_path']) > 0)) {
            $content = file_get_contents($params['template_file_path']);
            if (!$content) {
                throw new Exception('Unable to load template file: ' . $params['template_file_path']);
            }
            $mail->MsgHTML($content);
        } else {
            throw new Exception('No template file found at path: ' . $params['template_file_path']);
        }
    }
}

function set_common_mail_config(&$mail_instance, &$mail_config) {

    if (isset($mail_config["general_mail_config"]["mail_protocol"])) {
        $mail_instance->IsSMTP(strcasecmp($mail_config["general_mail_config"]["mail_protocol"],"SMTP") == 0);
    }
    if (isset($mail_config["general_mail_config"]["host_server"])) {
        $mail_instance->Host = $mail_config["general_mail_config"]["host_server"];
    }
    if (isset($mail_config["general_mail_config"]["authentication_required"])) {
        $mail_instance->SMTPAuth = $mail_config["general_mail_config"]["authentication_required"];
    }
    if (isset($mail_config["general_mail_config"]["secure_connection_method"])) {
        $mail_instance->SMTPSecure = $mail_config["general_mail_config"]["secure_connection_method"];
    }
    if (isset($mail_config["general_mail_config"]["username"])) {
        $mail_instance->Username = $mail_config["general_mail_config"]["username"];
    }
    if (isset($mail_config["general_mail_config"]["password"])) {
        $mail_instance->Password = $mail_config["general_mail_config"]["password"];
    }
    if (isset($mail_config["general_mail_config"]["password_file"])) {
        $passwd_config = parse_ini_file($mail_config["general_mail_config"]["password_file"], true);
        if (isset($mail_config["general_mail_config"]["username"]) AND isset($passwd_config[$mail_config["general_mail_config"]["username"]])) {
            $mail_instance->Password = $passwd_config[$mail_config["general_mail_config"]["username"]];
        }
    }
    if (isset($mail_config["general_mail_config"]["port"])) {
        $mail_instance->Port = $mail_config["general_mail_config"]["port"];
    }
    if (isset($mail_config["general_mail_config"]["smtp_debug"])) {
        $mail_instance->SMTPDebug = $mail_config["general_mail_config"]["smtp_debug"];
    }
}
