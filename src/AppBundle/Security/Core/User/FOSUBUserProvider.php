<?php
namespace AppBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;

class FOSUBUserProvider extends BaseClass
{

    /**
     * @param UserInterface $user
     * @param UserResponseInterface $response
     */
    public function connect(UserInterface $user, UserResponseInterface $response) {
        $property = $this->getProperty($response);

        $userName = $response->getUsername();

        // On connect, retrieve the access token and the user id
        $service = $response->getResourceOwner()->getName();

        $setter = 'set' . ucfirst($service);
        $setter_id = $setter . 'Id';
        $setter_token = $setter . 'AccessToken';

        // Disconnect previously connected user
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $userName))) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }

        // Connect using the current user
        $user->$setter_id($userName);
        $user->$setter_token($response->getAccessToken());
        $this->userManager->updateUser($user);
    }

    /**
     * @param UserResponseInterface $response
     * @return \FOS\UserBundle\Model\UserInterface|UserInterface
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response) {

        $userName = $response->getUsername();
        $email = $response->getEmail();
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $userName));
        $firstName = $response->getFirstName();
        $lastName =  $response->getLastName();
        $nickName = $response->getNickname();

        // If the user is new
        if (null === $user){
            $service = $response->getResourceOwner()->getName();
            $setter = 'set' . ucfirst($service);
            $setter_id = $setter . 'Id';
            $setter_token = $setter . 'AccessToken';

            // Create new user
            $user = $this->userManager->createUser();
            $user->$setter_id($userName);
            $user->$setter_token($response->getAccessToken());

            // Set all requested data with the user's username
            if ($service === 'twitter'){
                $user->setUsername($nickName);
            }else{
                $user->setUsername($this->generateRandomeUserName($firstName, $lastName));
            }
            $user->setEmail($email);
            $user->setPassword($userName);
            $user->setEnabled(true);
            $this->userManager->updateUser($user);

            return $user;
        }

        // If the user exists, use the HWIOAuth
        $user = parent::loadUserByOAuthUserResponse($response);

        $serviceName = $response->getResourceOwner()->getName();

        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';

        // Update the access token
        $user->$setter($response->getAccessToken());

        return $user;
    }

    /**
     * @param $userName
     * @param $serviceName
     * @return string
     */
    private function generateRandomeUserName($userName, $serviceName) {
        if (!$userName) {
            $userName = "user" . uniqid((rand()), true) . $serviceName;
        }

        return $userName . "_" . $serviceName;
    }

}

