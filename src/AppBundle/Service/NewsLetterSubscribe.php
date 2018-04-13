<?php

namespace AppBundle\Service;


use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class NewsLetterSubscribe
{
    private $templating;

    public function __construct(EngineInterface $templating) {
        $this->templating = $templating;
    }

    public function subscribe($email) {
        $list_id = '92b8cefdb9';
        $maiChimp_api_key = '47f380784a74b58a147e6a359f3a34fa-us17';
        $data_center = substr($maiChimp_api_key, strpos($maiChimp_api_key,'-') + 1);
        $url = 'https://'. $data_center .'.api.mailchimp.com/3.0/lists/'. $list_id .'/members';

        // Prepare the request json
        $json = json_encode(array(
            'email_address'  => $email,
            'status'        => 'subscribed'
        ));

        // Send a HTTP POST request with curl
        $curl_request = curl_init($url);
        curl_setopt($curl_request, CURLOPT_USERPWD, 'user:' . $maiChimp_api_key);
        curl_setopt($curl_request, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_request, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl_request, CURLOPT_POST, 1);
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($curl_request);
        $status_code = curl_getinfo($curl_request, CURLINFO_HTTP_CODE);
        curl_close($curl_request);

        $view = 'Core/newsletter_confirmation.html.twig';

        switch ($status_code) {
            case 200:
                $title = "Inscription réussie à la NewsLetter";
                $content = 'Vous êtes bien inscrit à la newsletter, 
                       vous recevrez une newsletter des actualités de notre association chaque mois, 
                       sur votre adresse e-mail : ' . $email;
                return $render = (object) array('view' => $view, 'parameters' => array(
                    'title'     => $title,
                    'content'   => $content
                ));
                break;
            case 400:
                $title = "Déjà inscrit à la newsletter";
                $content = 'Inutile de vous inscrire vous êtes déjà inscrit à la newsletter, 
                       vous recevrez une newsletter des actualités de notre association chaque mois, 
                       sur votre adresse e-mail : ' . $email;
                return $render = (object)array('view' => $view, 'parameters' => array(
                    'title'     => $title,
                    'content'   => $content
                ));
                break;
            default:
                $title = "Erreur " . $status_code;
                $content = 'Un problème est survenu, veuillez réessayer plus tard.';
                return $render= (object) array('view' => $view, 'parameters' => array(
                    'title'     => $title,
                    'content'   => $content
                ));
                break;
        }
    }

}